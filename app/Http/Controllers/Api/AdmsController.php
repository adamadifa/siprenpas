<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Karyawan;
use App\Models\Presensi;
use App\Models\Jamkerja;
use App\Models\Setjamkerjabydate;
use App\Models\Setjamkerjabyday;
use App\Models\MesinFingerprint;
use App\Models\LogMesinPresensi;

class AdmsController extends Controller
{
    /**
     * Menangkap dan mencatat semua request dari mesin Fingerprint ADMS (Fingerspot JSON Format)
     */

    /**
     * Backup method capture lama (sebagai antisipasi)
     */
    public function captureV1(Request $request, $any = null)
    {
        $requestCode = $request->header('request-code');
        if (empty($requestCode)) {
            $requestCode = $_SERVER['HTTP_REQUEST_CODE'] ?? $_SERVER['request-code'] ?? $_SERVER['REQUEST_CODE_RAW'] ?? $request->header('Request-Code', '');
        }

        $transId = $request->header('trans-id');
        if (empty($transId)) {
            $transId = $_SERVER['HTTP_TRANS_ID'] ?? $_SERVER['trans-id'] ?? $_SERVER['TRANS_ID_RAW'] ?? $request->header('Trans-Id', '');
        }

        // 2. Jika ini MURNI HANYA detak jantung (heartbeat / poll request) dari mesin
        $isHeartbeat = (strtolower($requestCode) === 'receive_cmd') ||
            (empty($request->getContent()) && $request->isMethod('GET'));

        // 3. Baca body request
        $rawBody = $request->getContent();
        Log::info('DATA RECEIVED V1', [
            'request-code' => $requestCode,
            'trans-id' => $transId,
            'content' => $request->getContent(),
        ]);

        // 4. Proses data jika bukan heartbeat
        if (!$isHeartbeat) {
            $devId = $request->header('dev-id');
            if (empty($devId)) {
                $devId = $_SERVER['HTTP_DEV_ID'] ?? $_SERVER['dev-id'] ?? $_SERVER['DEV_ID_RAW'] ?? $request->header('Dev-Id', '');
            }

            $mesin = MesinFingerprint::where('sn', $devId)->where('status', 'Aktif')->first();

            if (!$mesin) {
                return response("OK", 200)->header('response_code', 'OK');
            }

            $jsonStart = strpos($rawBody, '{');
            $jsonEnd = strrpos($rawBody, '}');
            $jsonData = [];
            if ($jsonStart !== false && $jsonEnd !== false) {
                $jsonString = substr($rawBody, $jsonStart, $jsonEnd - $jsonStart + 1);
                $jsonData = json_decode($jsonString, true) ?? [];
            }

            if (!empty($jsonData) && isset($jsonData['user_id']) && isset($jsonData['io_time'])) {
                $this->processAttendance($jsonData['user_id'], date('Y-m-d H:i:s'), $jsonData['io_mode'] ?? 0, $mesin);
            }
        }

        return response("OK", 200)->header('response_code', 'OK');
    }

    /**
     * Method baru: Langsung masukkan data tanpa validasi SN/IP yang ribet
     * (Asumsi: Menggunakan mesin aktif pertama jika SN tidak terbaca)
     */
    /**
     * Backup capture method dengan validasi SN wajib terdaftar
     */
    public function captureV2(Request $request, $any = null)
    {
        // 1. Identifikasi Serial Number Mesin (Multi-Format Support)
        $devId = $request->header('dev-id') ??
            $request->header('dev_id') ??
            $request->header('X-Dev-Id') ??
            $_SERVER['HTTP_DEV_ID'] ??
            $_SERVER['DEV_ID'] ??
            $request->query('sn') ??
            '';

        $rawBody = $request->getContent();

        // 2. Parse JSON dari body
        $jsonStart = strpos($rawBody, '{');
        $jsonEnd = strrpos($rawBody, '}');
        $jsonData = [];
        if ($jsonStart !== false && $jsonEnd !== false) {
            $jsonString = substr($rawBody, $jsonStart, $jsonEnd - $jsonStart + 1);
            $jsonData = json_decode($jsonString, true) ?? [];
        }

        // 3. Cari Data Mesin di Database (Wajib Terdaftar)
        $mesin = MesinFingerprint::where('sn', $devId)->where('status', 'Aktif')->first();
        if (!$mesin) {
            Log::warning('Unregistered or inactive machine attempted to send data', [
                'sn' => $devId,
                'ip' => $request->ip(),
                'path' => $request->path()
            ]);

            return response("OK", 200)
                ->header('Content-Type', 'application/octet-stream; charset=utf-8')
                ->header('response_code', 'OK')
                ->header('Connection', 'close');
        }

        // 4. Jika tidak ada isi JSON (Heartbeat Mentah)
        if (empty($jsonData)) {
            return response("OK", 200)
                ->header('Content-Type', 'application/octet-stream; charset=utf-8')
                ->header('response_code', 'OK')
                ->header('Connection', 'close');
        }

        // 5. Proses Data Absensi (Ada user_id dan io_time)
        if (isset($jsonData['user_id']) && isset($jsonData['io_time'])) {
            if ($mesin) {
                // Format waktu: 20260326011015 -> 2026-03-26 01:10:15
                $io_time_str = $jsonData['io_time'];
                $scan = (strlen($io_time_str) == 14)
                    ? substr($io_time_str, 0, 4) . '-' . substr($io_time_str, 4, 2) . '-' . substr($io_time_str, 6, 2) . ' ' . substr($io_time_str, 8, 2) . ':' . substr($io_time_str, 10, 2) . ':' . substr($io_time_str, 12, 2)
                    : date('Y-m-d H:i:s');

                $io_mode = $jsonData['io_mode'] ?? 0;
                $status = ($io_mode >= 16777216) ? ($io_mode / 16777216) - 1 : ($jsonData['status_scan'] ?? 0);

                // Eksekusi Simpan Absensi
                $this->processAttendance($jsonData['user_id'], $scan, $status, $mesin);

                Log::info('ADMS CAPTURE SUCCESS', [
                    'sn' => $mesin->sn,
                    'user_id' => $jsonData['user_id'],
                    'time' => $scan
                ]);
            } else {
                Log::error('ADMS CAPTURE FAILED: No active machine configuration found');
            }
        }

        // 6. Jika ini Heartbeat (fk_info), Log status online
        if (isset($jsonData['fk_info']) && $mesin) {
            Log::debug('Machine Heartbeat', ['machine' => $mesin->nama_mesin, 'sn' => $mesin->sn]);
        }

        return response("OK", 200)
            ->header('Content-Type', 'application/octet-stream; charset=utf-8')
            ->header('response_code', 'OK')
            ->header('Connection', 'close');
    }

    /**
     * Method baru: Langsung masukkan data tanpa validasi SN/IP yang ribet
     * (Asumsi: Menggunakan mesin aktif pertama jika SN tidak terbaca)
     */
    public function capture(Request $request, $any = null)
    {
        // 1. Identifikasi Serial Number Mesin (Multi-Format Support)
        $devId = $request->header('dev-id') ??
            $request->header('dev_id') ??
            $request->header('X-Dev-Id') ??
            $_SERVER['HTTP_DEV_ID'] ??
            $_SERVER['DEV_ID'] ??
            $request->query('sn') ??
            '';
        Log::debug('dev-id-header = ' . $request->header('dev-id'));
        Log::debug('dev_id-header = ' . $request->header('dev_id'));
        Log::debug('http_dev_id = ' . $_SERVER['HTTP_DEV_ID']);
        Log::debug('dev_id = ' . $_SERVER['DEV_ID']);
        Log::debug('devid: ' . $devId);

        $rawBody = $request->getContent();

        // 2. Parse JSON dari body
        $jsonStart = strpos($rawBody, '{');
        $jsonEnd = strrpos($rawBody, '}');
        $jsonData = [];
        if ($jsonStart !== false && $jsonEnd !== false) {
            $jsonString = substr($rawBody, $jsonStart, $jsonEnd - $jsonStart + 1);
            $jsonData = json_decode($jsonString, true) ?? [];
        }

        // 3. Cari Data Mesin di Database
        $mesin = MesinFingerprint::where('sn', $devId)->where('status', 'Aktif')->first();

        // Jika tidak ditemukan berdasarkan SN, gunakan mesin aktif pertama sebagai fallback
        if (!$mesin) {
            $mesin = MesinFingerprint::where('status', 'Aktif')->first();
        }

        if (!$mesin) {
            Log::warning('No active machine found in database to process data', [
                'sn' => $devId,
                'ip' => $request->ip(),
                'path' => $request->path()
            ]);

            header('Content-Type: application/octet-stream; charset=utf-8');
            header('response_code: OK');
            header('Connection: close');
            echo "OK";
            exit;
        }

        // 4. Jika tidak ada isi JSON (Heartbeat Mentah)
        if (empty($jsonData)) {
            $transId = $request->header('trans-id') ?? $request->header('trans_id') ?? 'undefined';
            $cmdCode = $request->header('cmd-code') ?? $request->header('cmd_code') ?? 'undefined';

            header('Content-Type: application/octet-stream; charset=utf-8');
            header('response_code: OK');
            header('trans_id: ' . $transId);
            header('cmd_code: ' . $cmdCode);
            header('Connection: close');
            echo "OK";
            exit;
        }

        // 5. Proses Data Absensi (Ada user_id dan io_time)
        try {
            if (isset($jsonData['user_id']) && isset($jsonData['io_time'])) {
                if ($mesin) {
                    // Format waktu: 20260326011015 -> 2026-03-26 01:10:15
                    $io_time_str = $jsonData['io_time'];
                    $scan = (strlen($io_time_str) == 14)
                        ? substr($io_time_str, 0, 4) . '-' . substr($io_time_str, 4, 2) . '-' . substr($io_time_str, 6, 2) . ' ' . substr($io_time_str, 8, 2) . ':' . substr($io_time_str, 10, 2) . ':' . substr($io_time_str, 12, 2)
                        : date('Y-m-d H:i:s');

                    $io_mode = $jsonData['io_mode'] ?? 0;
                    $status = ($io_mode >= 16777216) ? ($io_mode / 16777216) - 1 : ($jsonData['status_scan'] ?? 0);

                    // Eksekusi Simpan Absensi
                    $this->processAttendance($jsonData['user_id'], $scan, $status, $mesin);

                    Log::info('ADMS CAPTURE SUCCESS', [
                        'sn' => $mesin->sn,
                        'user_id' => $jsonData['user_id'],
                        'time' => $scan
                    ]);
                } else {
                    Log::error('ADMS CAPTURE FAILED: No active machine configuration found');
                }
            }
        } catch (\Exception $e) {
            Log::error('ADMS CAPTURE ERROR: ' . $e->getMessage());
        }

        // 6. Jika ini Heartbeat (fk_info), Log status online
        if (isset($jsonData['fk_info']) && $mesin) {
            Log::debug('Machine Heartbeat', ['machine' => $mesin->nama_mesin, 'sn' => $mesin->sn]);
        }

        $transId = $request->header('trans-id') ?? $request->header('trans_id') ?? 'undefined';
        $cmdCode = $request->header('cmd-code') ?? $request->header('cmd_code') ?? 'undefined';
        $blkNo = $request->header('blk-no') ?? $request->header('blk_no');
        $blkLen = $request->header('blk-len') ?? $request->header('blk_len');

        // Bypass Laravel/Symfony Response Header Normalization to preserve underscores
        header('Content-Type: application/octet-stream; charset=utf-8');
        header('response_code: OK');
        header('trans_id: ' . $transId);
        header('cmd_code: ' . $cmdCode);
        header('Connection: close');

        if ($blkNo !== null) {
            header('blk_no: ' . $blkNo);
        }
        if ($blkLen !== null) {
            header('blk_len: ' . $blkLen);
        }

        echo "OK";
        exit;
    }

    /**
     * Endpoint untuk format asli ADMS ZKTeco / Solution (X100C Plain Text ATTLOG Format)
     */
    public function receiveX100c(Request $request)
    {
        // 1. Ambil SN dari query parameter jika ada, supaya bisa cari data mesin
        $devId = $request->query('SN', '');

        // 2. Jika method GET (Initialization handshake / heartbeat), balas OK
        if ($request->isMethod('GET')) {
            return response("OK\n", 200)->header('Content-Type', 'text/plain');
        }

        // 3. Jika POST (Data Push)
        $rawBody = $request->getContent();

        $mesin = MesinFingerprint::where('sn', $devId)->where('status', 'Aktif')->first();
        if (!$mesin) {
            Log::warning('Unregistered X100C machine attempted to send data', [
                'sn' => $devId,
                'ip' => $request->ip()
            ]);
            return response("OK\n", 200)->header('Content-Type', 'text/plain');
        }

        // Parse Plain Text ATTLOG format: PIN \t Time \t Status \t VerifyType \n
        $lines = explode("\n", $rawBody);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line))
                continue;

            $parts = explode("\t", $line);
            if (count($parts) >= 3) {
                // $parts[0] = PIN
                // $parts[1] = 2026-03-19 16:01:23
                // $parts[2] = Status (0, 1, dll)
                $pin = $parts[0];
                $scan = $parts[1];
                $status = (int) $parts[2];

                // Panggil core logic
                $this->processAttendance($pin, $scan, $status, $mesin);
            }
        }

        // Standard ADMS expect "OK" as response for success
        return response("OK\n", 200)->header('Content-Type', 'text/plain');
    }

    /**
     * Core logic untuk memproses dan menyimpan data absensi dari segala mesin.
     * Logic disesuaikan dengan method store di Api\PresensiController:
     * - Menggunakan npp sebagai identifier karyawan
     * - Menggunakan tabel konfigurasi_jam_kerja
     * - Fallback ke JK01 jika jam kerja tidak ditemukan
     */
    private function processAttendance($pin, $scan, $normalized_status, $mesin)
    {
        Log::info('MASUK KE PROCESS ATTENDANCE', ['pin' => $pin, 'scan' => $scan, 'normalized_status' => $normalized_status]);

        $karyawan = Karyawan::where('pin', $pin)->first();

        if ($karyawan == null) {
            Log::info('Karyawan ADMS Fingerprint Tidak Ditemukan', ['pin' => $pin]);
            $this->recordLogMesin($pin, $scan, $normalized_status, $mesin ? $mesin->id : null, 0, 'Karyawan tidak ditemukan');
            return;
        }

        Log::info('KARYAWAN DITEMUKAN', ['npp' => $karyawan->npp]);

        $tanggal_sekarang = date("Y-m-d", strtotime($scan));
        $jam_sekarang = date("H:i", strtotime($scan));
        $tanggal_kemarin = date("Y-m-d", strtotime("-1 days", strtotime($tanggal_sekarang)));
        $tanggal_besok = date("Y-m-d", strtotime("+1 days", strtotime($tanggal_sekarang)));

        // Cek Presensi Kemarin
        $presensi_kemarin = Presensi::where('npp', $karyawan->npp)
            ->join('konfigurasi_jam_kerja', 'presensi.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
            ->where('presensi.tanggal', $tanggal_kemarin)->first();

        $lintas_hari = $presensi_kemarin ? $presensi_kemarin->lintas_hari : 0;

        // Jika Presensi Kemarin Status Lintas Hari nya 1 Maka Tanggal Presensi Sekarang adalah Tanggal Kemarin
        $tanggal_presensi = $lintas_hari == 1 ? $tanggal_kemarin : $tanggal_sekarang;
        $tanggal_pulang = $lintas_hari == 1 ? $tanggal_besok : $tanggal_sekarang;

        $namahari = getnamaHari(date('D', strtotime($tanggal_presensi)));

        // Cek Jam Kerja By Date
        $jamkerja = Setjamkerjabydate::join('konfigurasi_jam_kerja', 'presensi_jamkerja_bydate.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
            ->where('npp', $karyawan->npp)
            ->where('tanggal', $tanggal_presensi)
            ->first();

        // Jika Tidak Memiliki Jam Kerja By Date
        if ($jamkerja == null) {
            // Cek Jam Kerja harian / Jam Kerja Khusus / Jam Kerja Per Orangannya
            $jamkerja = Setjamkerjabyday::join('konfigurasi_jam_kerja', 'presensi_jamkerja_byday.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
                ->where('npp', $karyawan->npp)->where('hari', $namahari)->first();

            // Jika Jam Kerja Harian Kosong, fallback ke JK01
            if ($jamkerja == null) {
                $jamkerja = Jamkerja::where('kode_jam_kerja', 'JK01')->first();
            }
        }

        Log::info('Status jamkerja', ['is_null' => $jamkerja == null]);

        if ($jamkerja == null) {
            $this->recordLogMesin($pin, $scan, $normalized_status, $mesin ? $mesin->id : null, 0, 'Jam kerja karyawan tidak ditemukan');
            return;
        }

        $kode_jam_kerja = $jamkerja->kode_jam_kerja;
        Log::info('Jam kerja ditemukan', ['kode' => $kode_jam_kerja]);

        $jam_kerja = Jamkerja::where('kode_jam_kerja', $kode_jam_kerja)->first();

        $jam_presensi = $tanggal_sekarang . " " . $jam_sekarang;

        // Cek Presensi hari ini
        $presensi_hariini = Presensi::where('npp', $karyawan->npp)
            ->where('tanggal', $tanggal_presensi)
            ->first();

        // Cek apakah presensi sudah ada dan statusnya bukan 'h' (hadir)
        if ($presensi_hariini != null && $presensi_hariini->status != 'h') {
            Log::info('Presensi sudah ada dengan status selain hadir', ['npp' => $karyawan->npp, 'status' => $presensi_hariini->status]);
            $this->recordLogMesin($pin, $scan, $normalized_status, $mesin ? $mesin->id : null, 0, 'Presensi sudah ada (status: ' . $presensi_hariini->status . ')');
            return;
        }

        Log::info('Presensi hari ini', ['is_null' => $presensi_hariini == null]);

        // Tentukan apakah ini absen masuk (even) atau pulang (odd)
        $is_even = ($normalized_status % 2 == 0);

        // LOGIC AUTO-PULANG (Jika tidak ada tombol keluar yang ditekan di mesin)
        // Jika status dari mesin adalah MASUK (is_even = true),
        // tapi karyawan sudah absen masuk hari ini...
        if ($is_even && $presensi_hariini != null && $presensi_hariini->jam_in != null) {
            $jam_in_time = strtotime($presensi_hariini->jam_in);
            $scan_time = strtotime($scan);

            // Kalau scan berikutnya lebih dari 30 menit (1800 detik) sejak jam masuk pertama,
            // otomatis kita anggap ini sebagai absen PULANG.
            if (($scan_time - $jam_in_time) > 1800) {
                $is_even = false; // Override jadi absen pulang
            } else {
                // Kalau kurang dari 30 menit, ini cuma spam scan masuk. Abaikan saja supaya tidak error.
                Log::info('Abaikan scan berulang (SPAM IN)', ['pin' => $pin, 'time' => $scan]);
                $this->recordLogMesin($pin, $scan, $normalized_status, $mesin ? $mesin->id : null, 0, 'Spam Scan IN (Abaikan scan berulang)');
                return;
            }
        }

        Log::info('Mulai insert/update', ['is_even' => $is_even]);

        if ($is_even) {
            // ABSEN MASUK (status_scan genap: 0, 2, 4, 6, 8)
            if ($presensi_hariini == null || $presensi_hariini->jam_in == null) {
                Log::info('Mencoba simpan masuk');
                try {
                    if ($presensi_hariini != null) {
                        Presensi::where('id', $presensi_hariini->id)->update([
                            'jam_in' => $jam_presensi,
                        ]);
                        Log::info('Berhasil update masuk');
                        $this->recordLogMesin($pin, $scan, $normalized_status, $mesin ? $mesin->id : null, 1, 'Berhasil update absen masuk');
                    } else {
                        Presensi::create([
                            'npp' => $karyawan->npp,
                            'tanggal' => $tanggal_presensi,
                            'jam_in' => $jam_presensi,
                            'jam_out' => null,
                            'lokasi_out' => null,
                            'foto_out' => null,
                            'kode_jam_kerja' => $kode_jam_kerja,
                            'status' => 'h'
                        ]);
                        Log::info('Berhasil create masuk');
                        $this->recordLogMesin($pin, $scan, $normalized_status, $mesin ? $mesin->id : null, 1, 'Berhasil buat absen masuk baru');
                    }
                } catch (\Throwable $e) {
                    Log::error('Gagal simpan absen masuk ADMS', ['npp' => $karyawan->npp, 'error' => $e->getMessage()]);
                    $this->recordLogMesin($pin, $scan, $normalized_status, $mesin ? $mesin->id : null, 0, 'Gagal simpan absen masuk: ' . $e->getMessage());
                }
            }
        } else {
            // ABSEN PULANG (status_scan ganjil: 1, 3, 5, 7, 9)
            try {
                if ($presensi_hariini != null) {
                    Presensi::where('id', $presensi_hariini->id)->update([
                        'jam_out' => $jam_presensi,
                    ]);
                    Log::info('Berhasil update pulang');
                    $this->recordLogMesin($pin, $scan, $normalized_status, $mesin ? $mesin->id : null, 1, 'Berhasil update absen pulang');
                } else {
                    Presensi::create([
                        'npp' => $karyawan->npp,
                        'tanggal' => $tanggal_presensi,
                        'jam_in' => null,
                        'jam_out' => $jam_presensi,
                        'lokasi_in' => null,
                        'foto_in' => null,
                        'kode_jam_kerja' => $kode_jam_kerja,
                        'status' => 'h'
                    ]);
                    Log::info('Berhasil create pulang');
                    $this->recordLogMesin($pin, $scan, $normalized_status, $mesin ? $mesin->id : null, 1, 'Berhasil buat absen pulang baru');
                }
            } catch (\Exception $e) {
                Log::error('Gagal simpan absen pulang ADMS', ['npp' => $karyawan->npp, 'error' => $e->getMessage()]);
                $this->recordLogMesin($pin, $scan, $normalized_status, $mesin ? $mesin->id : null, 0, 'Gagal simpan absen pulang: ' . $e->getMessage());
            }
        }
    }

    /**
     * Mencatat log dari mesin presensi ke tabel log_mesin_presensi
     */
    private function recordLogMesin($pin, $scan, $status_scan, $id_mesin, $status, $keterangan)
    {
        try {
            LogMesinPresensi::create([
                'pin' => $pin,
                'status_scan' => $status_scan,
                'jam_absen' => $scan,
                'id_mesin' => $id_mesin,
                'status' => $status,
                'keterangan' => $keterangan,
            ]);
        } catch (\Exception $ex) {
            Log::error('Gagal mencatat log mesin presensi', ['error' => $ex->getMessage()]);
        }
    }

    /**
     * Method khusus untuk cek data mentah yang dikirim dari mesin fingerprint.
     * Tidak ada logic apapun, hanya log semua data mentah ke file terpisah.
     */
    public function rawDump(Request $request)
    {
        $data = [
            'time' => now()->toDateTimeString(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'headers_laravel' => $request->headers->all(),
            'apache_headers' => function_exists('apache_request_headers') ? apache_request_headers() : 'N/A',
            'server_vars' => $_SERVER,
            'query_string' => $request->query(),
            'body_raw' => $request->getContent(),
            'body_base64' => base64_encode($request->getContent()),
        ];

        // Parse body JSON jika ada
        $rawBody = $request->getContent();
        $jsonStart = strpos($rawBody, '{');
        $jsonEnd = strrpos($rawBody, '}');
        if ($jsonStart !== false && $jsonEnd !== false) {
            $jsonString = substr($rawBody, $jsonStart, $jsonEnd - $jsonStart + 1);
            $data['body_parsed_json'] = json_decode($jsonString, true);
        }

        // Log ke file terpisah supaya mudah dibaca
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/raw-dump.log'),
        ])->info('RAW DUMP FROM MACHINE', $data);

        // Juga log ke laravel.log biasa
        Log::info('RAW DUMP', $data);

        return response("OK", 200)
            ->header('Content-Type', 'application/octet-stream; charset=utf-8')
            ->header('response_code', 'OK')
            ->header('Connection', 'close');
    }
}

<?php

namespace App\Imports;

use App\Models\Biaya;
use App\Models\Biayasiswa;
use App\Models\Kelas;
use App\Models\Kelassiswa;
use App\Models\MigrasiLog;
use App\Models\MigrasiLogDetail;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\Tahunajaran;
use App\Models\Tahunajaranppdb;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Collection;

class MigrasiSiswaImport implements WithMultipleSheets
{
    public $migrasiLogId;
    public $errors = [];
    public $successCount = 0;
    public $failCount = 0;
    public $totalRows = 0;

    public function __construct($migrasiLogId)
    {
        $this->migrasiLogId = $migrasiLogId;
    }

    public function sheets(): array
    {
        return [
            0 => new SiswaSheet($this),
            1 => new PembayaranSheet($this),
        ];
    }
}

// ==========================================
// Sheet 1: Data Siswa
// ==========================================
class SiswaSheet implements ToCollection, WithHeadingRow
{
    protected $parent;

    public function __construct(MigrasiSiswaImport $parent)
    {
        $this->parent = $parent;
    }

    public function collection(Collection $rows)
    {
        // Pre-fetch valid units for validation
        $validUnits = Unit::pluck('kode_unit')->toArray();
        $validTa = Tahunajaran::pluck('kode_ta')->toArray();

        // Cache for generated siswa IDs to handle same student appearing in multiple rows
        $siswaCache = []; // key: "nama|tanggal_lahir" => id_siswa

        $baris = 1; // Excel row counter (after header)
        foreach ($rows as $row) {
            $baris++;
            $this->parent->totalRows++;

            // Skip completely empty rows
            if (empty($row['nama_lengkap'])) {
                continue;
            }

            // === VALIDATION ===
            $rowErrors = [];

            // Required: kode_ta
            if (empty($row['kode_ta'])) {
                $rowErrors[] = 'kode_ta wajib diisi (cek Sheet Referensi)';
            } elseif (!in_array($row['kode_ta'], $validTa)) {
                $rowErrors[] = 'kode_ta "' . $row['kode_ta'] . '" tidak ditemukan di database';
            }

            if (empty($row['nama_lengkap'])) {
                $rowErrors[] = 'nama_lengkap wajib diisi';
            }
            if (empty($row['jenis_kelamin']) || !in_array(strtoupper($row['jenis_kelamin']), ['L', 'P'])) {
                $rowErrors[] = 'jenis_kelamin harus L atau P';
            }
            if (empty($row['tempat_lahir'])) {
                $rowErrors[] = 'tempat_lahir wajib diisi';
            }
            if (empty($row['tanggal_lahir'])) {
                $rowErrors[] = 'tanggal_lahir wajib diisi';
            }
            if (empty($row['kode_unit'])) {
                $rowErrors[] = 'kode_unit wajib diisi';
            } elseif (!in_array($row['kode_unit'], $validUnits)) {
                $rowErrors[] = 'kode_unit "' . $row['kode_unit'] . '" tidak valid';
            }
            if (empty($row['tingkat_sekarang']) || !is_numeric($row['tingkat_sekarang'])) {
                $rowErrors[] = 'tingkat_sekarang wajib diisi (angka)';
            }

            // Check konfigurasi_biaya exists for this unit + tingkat + TA (per-row)
            $biaya = null;
            if (!empty($row['kode_unit']) && !empty($row['tingkat_sekarang']) && !empty($row['kode_ta'])) {
                $biaya = Biaya::where('kode_unit', $row['kode_unit'])
                    ->where('kode_ta', $row['kode_ta'])
                    ->where('tingkat', $row['tingkat_sekarang'])
                    ->where('is_pindahan', 0)
                    ->first();

                if (!$biaya) {
                    $rowErrors[] = 'Konfigurasi biaya untuk unit ' . $row['kode_unit'] . ' tingkat ' . $row['tingkat_sekarang'] . ' TA ' . $row['kode_ta'] . ' belum tersedia';
                }
            }

            // Check NIS uniqueness if provided
            if (!empty($row['nis'])) {
                $existingNis = Pendaftaran::where('nis', $row['nis'])->first();
                if ($existingNis) {
                    $rowErrors[] = 'NIS "' . $row['nis'] . '" sudah digunakan oleh pendaftaran ' . $existingNis->no_pendaftaran;
                }
            }

            // If validation fails, log error and skip
            if (count($rowErrors) > 0) {
                $this->parent->failCount++;
                $this->parent->errors[] = [
                    'baris' => $baris,
                    'nama' => $row['nama_lengkap'] ?? 'N/A',
                    'alasan' => implode('; ', $rowErrors)
                ];

                MigrasiLogDetail::create([
                    'migrasi_log_id' => $this->parent->migrasiLogId,
                    'baris_excel' => $baris,
                    'status' => 'failed',
                    'keterangan' => implode('; ', $rowErrors)
                ]);

                continue;
            }

            // === PROCESS ===
            DB::beginTransaction();
            try {
                // Parse tanggal_lahir
                $tanggalLahir = $this->parseTanggal($row['tanggal_lahir']);

                // Get the TA data for this specific row
                $rowTa = Tahunajaran::where('kode_ta', $row['kode_ta'])->first();
                $ta_parts = explode("/", $rowTa->tahun_ajaran);
                $tahun_masuk = $ta_parts[0];
                $ta_nis = substr($rowTa->tahun_ajaran, 2, 2) . substr($rowTa->tahun_ajaran, 7, 2);

                // 1. Check for duplicate siswa (nama_lengkap + tanggal_lahir)
                $cacheKey = strtolower($row['nama_lengkap']) . '|' . $tanggalLahir;
                $isNewSiswa = true;

                if (isset($siswaCache[$cacheKey])) {
                    // Already created in a previous row of this batch
                    $id_siswa = $siswaCache[$cacheKey];
                    $isNewSiswa = false;
                } else {
                    $existingSiswa = Siswa::where('nama_lengkap', $row['nama_lengkap'])
                        ->where('tanggal_lahir', $tanggalLahir)
                        ->first();

                    if ($existingSiswa) {
                        $id_siswa = $existingSiswa->id_siswa;
                        $isNewSiswa = false;
                    } else {
                        // Generate new id_siswa safely ignoring bad data
                        $last_siswa = Siswa::where('id_siswa', 'like', $tahun_masuk . '%')
                            ->orderBy('id_siswa', 'desc')
                            ->first();
                        $last_id_siswa = $last_siswa != null ? $last_siswa->id_siswa : "";
                        $id_siswa = buatkode($last_id_siswa, $tahun_masuk, 3);

                        Siswa::create([
                            'id_siswa' => $id_siswa,
                            'nisn' => $row['nisn'] ?? null,
                            'nama_lengkap' => $row['nama_lengkap'],
                            'jenis_kelamin' => strtoupper($row['jenis_kelamin']),
                            'tempat_lahir' => $row['tempat_lahir'],
                            'tanggal_lahir' => $tanggalLahir,
                            'anak_ke' => $row['anak_ke'] ?? null,
                            'jumlah_saudara' => $row['jumlah_saudara'] ?? null,
                            'alamat' => $row['alamat'] ?? null,
                            'kode_pos' => $row['kode_pos'] ?? null,
                            'no_kk' => $row['no_kk'] ?? null,
                            'nik_ayah' => $row['nik_ayah'] ?? null,
                            'nama_ayah' => $row['nama_ayah'] ?? null,
                            'pendidikan_ayah' => $row['pendidikan_ayah'] ?? null,
                            'pekerjaan_ayah' => $row['pekerjaan_ayah'] ?? null,
                            'nik_ibu' => $row['nik_ibu'] ?? null,
                            'nama_ibu' => $row['nama_ibu'] ?? null,
                            'pendidikan_ibu' => $row['pendidikan_ibu'] ?? null,
                            'pekerjaan_ibu' => $row['pekerjaan_ibu'] ?? null,
                            'no_hp_orang_tua' => $row['no_hp_orang_tua'] ?? null,
                            'tahun_masuk' => $tahun_masuk,
                        ]);
                    }

                    $siswaCache[$cacheKey] = $id_siswa;
                }

                // 2. Check if pendaftaran already exists for this siswa + TA + unit
                $existingPendaftaran = Pendaftaran::where('id_siswa', $id_siswa)
                    ->where('kode_ta', $row['kode_ta'])
                    ->where('kode_unit', $row['kode_unit'])
                    ->first();

                if ($existingPendaftaran) {
                    // Skip creating duplicate pendaftaran, just log it
                    MigrasiLogDetail::create([
                        'migrasi_log_id' => $this->parent->migrasiLogId,
                        'no_pendaftaran' => $existingPendaftaran->no_pendaftaran,
                        'id_siswa' => $id_siswa,
                        'is_new_siswa' => false,
                        'baris_excel' => $baris,
                        'status' => 'success',
                        'keterangan' => 'Pendaftaran sudah ada (skip), TA: ' . $row['kode_ta'],
                    ]);
                    $this->parent->successCount++;
                    DB::commit();
                    continue;
                }

                // 3. Generate no_pendaftaran
                $ta_pendaftaran = substr($rowTa->tahun_ajaran, 2, 2);
                $format = "REG" . $row['kode_unit'] . $ta_pendaftaran;
                $lastPendaftaran = Pendaftaran::where('no_pendaftaran', 'like', $format . '%')
                    ->orderBy('no_pendaftaran', 'desc')
                    ->first();
                $last_no_pendaftaran = $lastPendaftaran ? $lastPendaftaran->no_pendaftaran : '';
                $no_pendaftaran = buatkode($last_no_pendaftaran, $format, 3);

                // 4. Generate NIS
                if (!empty($row['nis'])) {
                    $nis = $row['nis'];
                } else {
                    $lastNis = Pendaftaran::where('nis', 'like', $ta_nis . '%')
                        ->orderBy('nis', 'desc')
                        ->first();
                    $last_nis = $lastNis ? $lastNis->nis : '';
                    $nis = buatkode($last_nis, $ta_nis, 3);
                }

                // 5. Insert Pendaftaran
                Pendaftaran::create([
                    'no_pendaftaran' => $no_pendaftaran,
                    'tanggal_pendaftaran' => now()->toDateString(),
                    'nis' => $nis,
                    'id_siswa' => $id_siswa,
                    'kode_unit' => $row['kode_unit'],
                    'kode_ta' => $row['kode_ta'],
                    'id_user' => Auth::id(),
                    'jenis_pendaftaran' => 'Migrasi',
                    'tingkat_masuk' => $row['tingkat_sekarang'],
                ]);

                // 6. Insert Siswa Biaya
                Biayasiswa::create([
                    'no_pendaftaran' => $no_pendaftaran,
                    'kode_biaya' => $biaya->kode_biaya,
                ]);

                // 7. Assign Kelas (if nama_kelas provided)
                if (!empty($row['nama_kelas'])) {
                    $kelas = Kelas::where('nama_kelas', $row['nama_kelas'])
                        ->where('kode_unit', $row['kode_unit'])
                        ->where('kode_ta', $row['kode_ta'])
                        ->first();

                    if ($kelas) {
                        // Check if already assigned
                        $existingKelas = Kelassiswa::where('kode_kelas', $kelas->kode_kelas)
                            ->where('id_siswa', $id_siswa)
                            ->first();
                        if (!$existingKelas) {
                            Kelassiswa::create([
                                'kode_kelas' => $kelas->kode_kelas,
                                'id_siswa' => $id_siswa,
                            ]);
                        }
                    }
                }

                // 8. Log success
                MigrasiLogDetail::create([
                    'migrasi_log_id' => $this->parent->migrasiLogId,
                    'no_pendaftaran' => $no_pendaftaran,
                    'id_siswa' => $id_siswa,
                    'is_new_siswa' => $isNewSiswa,
                    'baris_excel' => $baris,
                    'status' => 'success',
                    'keterangan' => ($isNewSiswa ? 'Siswa baru' : 'Siswa existing') . ', TA: ' . $row['kode_ta'] . ', Tingkat: ' . $row['tingkat_sekarang'],
                ]);

                $this->parent->successCount++;
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $this->parent->failCount++;
                $this->parent->errors[] = [
                    'baris' => $baris,
                    'nama' => $row['nama_lengkap'] ?? 'N/A',
                    'alasan' => 'Error sistem: ' . $e->getMessage()
                ];

                MigrasiLogDetail::create([
                    'migrasi_log_id' => $this->parent->migrasiLogId,
                    'baris_excel' => $baris,
                    'status' => 'failed',
                    'keterangan' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        // Update migrasi_log with results
        $migrasiLog = MigrasiLog::find($this->parent->migrasiLogId);
        if ($migrasiLog) {
            $migrasiLog->update([
                'total_baris' => $this->parent->totalRows,
                'berhasil' => $this->parent->successCount,
                'gagal' => $this->parent->failCount,
                'status' => $this->parent->failCount > 0 && $this->parent->successCount == 0 ? 'error' : 'done',
                'catatan_error' => count($this->parent->errors) > 0 ? $this->parent->errors : null,
            ]);
        }
    }

    /**
     * Parse various date formats from Excel
     */
    private function parseTanggal($value)
    {
        if (empty($value)) {
            return null;
        }

        // If it's a numeric value (Excel serial date)
        if (is_numeric($value)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
        }

        // Try standard date parsing
        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}

// ==========================================
// Sheet 2: Status Pembayaran (Mutasi)
// ==========================================
class PembayaranSheet implements ToCollection, WithHeadingRow
{
    protected $parent;

    public function __construct(MigrasiSiswaImport $parent)
    {
        $this->parent = $parent;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip empty rows
            if (empty($row['nama_lengkap']) || empty($row['kode_unit']) || empty($row['kode_ta'])) {
                continue;
            }

            try {
                // Find the matching pendaftaran via migrasi_log_detail
                $details = MigrasiLogDetail::where('migrasi_log_id', $this->parent->migrasiLogId)
                    ->where('status', 'success')
                    ->whereNotNull('no_pendaftaran')
                    ->get();

                $matchedNoPendaftaran = null;
                $matchedKodeBiaya = null;

                foreach ($details as $d) {
                    $pendaftaran = Pendaftaran::where('no_pendaftaran', $d->no_pendaftaran)
                        ->where('kode_unit', $row['kode_unit'])
                        ->where('kode_ta', $row['kode_ta'])
                        ->first();

                    if ($pendaftaran) {
                        $siswa = Siswa::where('id_siswa', $pendaftaran->id_siswa)
                            ->where('nama_lengkap', $row['nama_lengkap'])
                            ->first();

                        if ($siswa) {
                            $matchedNoPendaftaran = $pendaftaran->no_pendaftaran;
                            break;
                        }
                    }
                }

                if (!$matchedNoPendaftaran) {
                    continue; // Skip if no match found
                }

                // Find the biaya for this student
                $biayaSiswa = Biayasiswa::where('no_pendaftaran', $matchedNoPendaftaran)->first();
                if (!$biayaSiswa) {
                    continue;
                }

                // Insert/update mutasi record
                $nominal = floatval($row['jumlah_sudah_bayar'] ?? 0);
                if ($nominal > 0) {
                    $kodeMutasi = $matchedNoPendaftaran . $biayaSiswa->kode_biaya . $row['kode_jenis_biaya'];
                    DB::table('pembayaran_pendidikan_mutasi')->updateOrInsert(
                        ['kode_mutasi' => $kodeMutasi],
                        [
                            'no_pendaftaran' => $matchedNoPendaftaran,
                            'kode_biaya' => $biayaSiswa->kode_biaya,
                            'kode_jenis_biaya' => $row['kode_jenis_biaya'],
                            'jumlah' => $nominal,
                            'keterangan' => $row['keterangan'] ?? 'Migrasi saldo awal',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            } catch (\Exception $e) {
                // Silently skip payment errors — they don't block migration
                continue;
            }
        }
    }
}

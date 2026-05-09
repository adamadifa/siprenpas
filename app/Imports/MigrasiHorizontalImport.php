<?php

namespace App\Imports;

use App\Models\Biaya;
use App\Models\Biayasiswa;
use App\Models\Jenisbiaya;
use App\Models\Kelas;
use App\Models\Kelassiswa;
use App\Models\MigrasiLog;
use App\Models\MigrasiLogDetail;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\Tahunajaran;
use App\Models\Unit;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MigrasiHorizontalImport implements WithMultipleSheets
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
            0 => new HorizontalDataSheet($this),
        ];
    }
}

// ==========================================
// Sheet 1: Horizontal Data (Data Migrasi)
// ==========================================
class HorizontalDataSheet implements ToCollection
{
    protected $parent;

    public function __construct(MigrasiHorizontalImport $parent)
    {
        $this->parent = $parent;
    }

    public function collection(Collection $rows)
    {
        // ==============================
        // PARSE HEADER ROWS
        // Row 0 = "Tahun Ajaran" super-header
        // Row 1 = TA names (merged across jenis biaya blocks)
        // Row 2 = kode_jenis_biaya (merged across Tagihan+Bayar)
        // Row 3 = Tagihan | Bayar sub-labels
        // ==============================
        if ($rows->count() < 5) {
            return; // Need 4 header rows + at least 1 data row
        }

        $headerRow2 = $rows[1]; // TA names / kode_ta
        $headerRow3 = $rows[2]; // kode_jenis_biaya
        $headerRow4 = $rows[3]; // Tagihan | Bayar labels

        $fixedColCount = 7; // A-G

        // Parse TA + Jenis Biaya column mapping
        // Structure: taColumns[ kode_ta => [ kode_jenis_biaya => ['tagihan_idx' => X, 'bayar_idx' => Y] ] ]
        $taColumns = [];
        $jenisBiayaList = Jenisbiaya::orderBy('kode_jenis_biaya', 'asc')->pluck('kode_jenis_biaya')->toArray();
        $jbCount = count($jenisBiayaList);
        $subColsPerJB = 2; // Tagihan + Bayar
        $colsPerTa = $jbCount * $subColsPerJB;

        $colIndex = $fixedColCount;
        $totalCols = $headerRow2->count();

        // Detect TA blocks by reading Row 2 (TA names appear at start of each block)
        while ($colIndex < $totalCols) {
            $taValue = $headerRow2[$colIndex] ?? null;

            // Skip empty columns
            if (empty($taValue)) {
                $colIndex++;
                continue;
            }

            // Check if this is a valid TA (could be tahun_ajaran name or kode_ta)
            $ta = Tahunajaran::where('tahun_ajaran', $taValue)
                ->orWhere('kode_ta', $taValue)
                ->first();

            if (!$ta) {
                $colIndex++;
                continue;
            }

            $kodeTa = $ta->kode_ta;
            $taColumns[$kodeTa] = [
                'tahun_ajaran' => $ta->tahun_ajaran,
                'jenis_biaya' => [],
            ];

            // Read jenis biaya sub-columns for this TA
            for ($jbIdx = 0; $jbIdx < $jbCount; $jbIdx++) {
                $jbColStart = $colIndex + ($jbIdx * $subColsPerJB);
                $kodeJB = $headerRow3[$jbColStart] ?? null;

                if (!empty($kodeJB)) {
                    $taColumns[$kodeTa]['jenis_biaya'][$kodeJB] = [
                        'tagihan_idx' => $jbColStart,
                        'bayar_idx' => $jbColStart + 1,
                    ];
                }
            }

            $colIndex += $colsPerTa;
        }

        // Pre-fetch valid data
        $validUnits = Unit::pluck('kode_unit')->toArray();
        $validTa = Tahunajaran::pluck('kode_ta')->toArray();
        $siswaCache = [];

        // ==============================
        // PROCESS DATA ROWS (starting from row index 4 = Excel row 5)
        // ==============================
        for ($rowIdx = 4; $rowIdx < $rows->count(); $rowIdx++) {
            $row = $rows[$rowIdx];
            $excelRowNum = $rowIdx + 1;

            $namaLengkap = trim($row[1] ?? '');
            if (empty($namaLengkap)) {
                continue;
            }

            $this->parent->totalRows++;

            $nisn = trim($row[0] ?? '');
            $jenisKelamin = strtoupper(trim($row[2] ?? ''));
            $tempatLahir = trim($row[3] ?? '');
            $tanggalLahirRaw = $row[4] ?? '';
            $kodeUnit = trim($row[5] ?? '');
            $tingkatMasuk = trim($row[6] ?? '');

            // === BASIC VALIDATION ===
            $rowErrors = [];

            if (empty($namaLengkap)) {
                $rowErrors[] = 'Nama siswa wajib diisi';
            }
            if (!in_array($jenisKelamin, ['L', 'P'])) {
                $rowErrors[] = 'Jenis kelamin harus L atau P';
            }
            if (empty($tempatLahir)) {
                $rowErrors[] = 'Tempat lahir wajib diisi';
            }
            if (empty($tanggalLahirRaw)) {
                $rowErrors[] = 'Tanggal lahir wajib diisi';
            }
            if (empty($kodeUnit)) {
                $rowErrors[] = 'Kode unit wajib diisi';
            } elseif (!in_array($kodeUnit, $validUnits)) {
                $rowErrors[] = 'Kode unit "' . $kodeUnit . '" tidak valid';
            }
            if (empty($tingkatMasuk) || !is_numeric($tingkatMasuk)) {
                $rowErrors[] = 'Tingkat masuk wajib diisi (angka)';
            }

            if (count($rowErrors) > 0) {
                $this->parent->failCount++;
                MigrasiLogDetail::create([
                    'migrasi_log_id' => $this->parent->migrasiLogId,
                    'baris_excel' => $excelRowNum,
                    'status' => 'failed',
                    'keterangan' => implode('; ', $rowErrors),
                ]);
                continue;
            }

            $tanggalLahir = $this->parseTanggal($tanggalLahirRaw);

            // === CREATE/FIND SISWA ===
            $cacheKey = strtolower($namaLengkap) . '|' . $tanggalLahir;
            $isNewSiswa = true;

            if (isset($siswaCache[$cacheKey])) {
                $id_siswa = $siswaCache[$cacheKey];
                $isNewSiswa = false;
            } else {
                $existingSiswa = Siswa::where('nama_lengkap', $namaLengkap)
                    ->where('tanggal_lahir', $tanggalLahir)
                    ->first();

                if ($existingSiswa) {
                    $id_siswa = $existingSiswa->id_siswa;
                    $isNewSiswa = false;
                } else {
                    $firstTaKey = array_key_first($taColumns);
                    $rowTaForId = $firstTaKey ? Tahunajaran::where('kode_ta', $firstTaKey)->first() : null;
                    $ta_parts = $rowTaForId ? explode("/", $rowTaForId->tahun_ajaran) : [date('Y')];
                    $tahun_masuk = $ta_parts[0];

                    $last_siswa = Siswa::where('id_siswa', 'like', $tahun_masuk . '%')
                        ->orderBy('id_siswa', 'desc')
                        ->first();
                    $last_id_siswa = $last_siswa != null ? $last_siswa->id_siswa : "";
                    $id_siswa = buatkode($last_id_siswa, $tahun_masuk, 3);

                    Siswa::create([
                        'id_siswa' => $id_siswa,
                        'nisn' => $nisn ?: null,
                        'nama_lengkap' => $namaLengkap,
                        'jenis_kelamin' => $jenisKelamin,
                        'tempat_lahir' => $tempatLahir,
                        'tanggal_lahir' => $tanggalLahir,
                        'tahun_masuk' => $tahun_masuk,
                    ]);
                }

                $siswaCache[$cacheKey] = $id_siswa;
            }

            // === PROCESS EACH TA COLUMN ===
            $currentTingkat = intval($tingkatMasuk);

            foreach ($taColumns as $kodeTa => $taData) {
                // Check if this TA has any data filled for this student
                $hasData = false;
                foreach ($taData['jenis_biaya'] as $kodeJB => $indices) {
                    $tagihan = floatval($row[$indices['tagihan_idx']] ?? 0);
                    $bayar = floatval($row[$indices['bayar_idx']] ?? 0);
                    if ($tagihan > 0 || $bayar > 0) {
                        $hasData = true;
                        break;
                    }
                }

                if (!$hasData) {
                    $currentTingkat++;
                    continue;
                }

                if (!in_array($kodeTa, $validTa)) {
                    $currentTingkat++;
                    continue;
                }

                DB::beginTransaction();
                try {
                    $rowTa = Tahunajaran::where('kode_ta', $kodeTa)->first();
                    $ta_nis = substr($rowTa->tahun_ajaran, 2, 2) . substr($rowTa->tahun_ajaran, 7, 2);

                    // Check if pendaftaran already exists
                    $existingPendaftaran = Pendaftaran::where('id_siswa', $id_siswa)
                        ->where('kode_ta', $kodeTa)
                        ->where('kode_unit', $kodeUnit)
                        ->first();

                    if ($existingPendaftaran) {
                        $matchedNoPendaftaran = $existingPendaftaran->no_pendaftaran;
                    } else {
                        // Check biaya config exists
                        $biaya = Biaya::where('kode_unit', $kodeUnit)
                            ->where('kode_ta', $kodeTa)
                            ->where('tingkat', $currentTingkat)
                            ->where('is_pindahan', 0)
                            ->first();

                        if (!$biaya) {
                            DB::rollBack();
                            $this->parent->failCount++;
                            MigrasiLogDetail::create([
                                'migrasi_log_id' => $this->parent->migrasiLogId,
                                'baris_excel' => $excelRowNum,
                                'status' => 'failed',
                                'keterangan' => 'Konfigurasi biaya tidak ditemukan untuk unit ' . $kodeUnit . ' tingkat ' . $currentTingkat . ' TA ' . $kodeTa,
                            ]);
                            $currentTingkat++;
                            continue;
                        }

                        // Generate no_pendaftaran
                        $ta_pendaftaran = substr($rowTa->tahun_ajaran, 2, 2);
                        $format = "REG" . $kodeUnit . $ta_pendaftaran;
                        $lastPendaftaran = Pendaftaran::where('no_pendaftaran', 'like', $format . '%')
                            ->orderBy('no_pendaftaran', 'desc')
                            ->first();
                        $last_no_pendaftaran = $lastPendaftaran ? $lastPendaftaran->no_pendaftaran : '';
                        $no_pendaftaran = buatkode($last_no_pendaftaran, $format, 3);

                        // Generate NIS
                        $lastNis = Pendaftaran::where('nis', 'like', $ta_nis . '%')
                            ->orderBy('nis', 'desc')
                            ->first();
                        $last_nis = $lastNis ? $lastNis->nis : '';
                        $nis = buatkode($last_nis, $ta_nis, 3);

                        // Create Pendaftaran
                        Pendaftaran::create([
                            'no_pendaftaran' => $no_pendaftaran,
                            'tanggal_pendaftaran' => now()->toDateString(),
                            'nis' => $nis,
                            'id_siswa' => $id_siswa,
                            'kode_unit' => $kodeUnit,
                            'kode_ta' => $kodeTa,
                            'id_user' => Auth::id(),
                            'jenis_pendaftaran' => 'Migrasi',
                            'tingkat_masuk' => $currentTingkat,
                        ]);

                        // Create Biaya Siswa
                        Biayasiswa::create([
                            'no_pendaftaran' => $no_pendaftaran,
                            'kode_biaya' => $biaya->kode_biaya,
                        ]);

                        $matchedNoPendaftaran = $no_pendaftaran;
                    }

                    // === HANDLE PAYMENT MUTATIONS PER JENIS BIAYA ===
                    $biayaSiswa = Biayasiswa::where('no_pendaftaran', $matchedNoPendaftaran)->first();

                    if ($biayaSiswa) {
                        foreach ($taData['jenis_biaya'] as $kodeJB => $indices) {
                            $jumlahBayar = floatval($row[$indices['bayar_idx']] ?? 0);

                            if ($jumlahBayar > 0) {
                                $kodeMutasi = $matchedNoPendaftaran . '-' . $kodeJB . '-MIG';
                                DB::table('pembayaran_pendidikan_mutasi')->updateOrInsert(
                                    ['kode_mutasi' => $kodeMutasi],
                                    [
                                        'no_pendaftaran' => $matchedNoPendaftaran,
                                        'kode_biaya' => $biayaSiswa->kode_biaya,
                                        'kode_jenis_biaya' => $kodeJB,
                                        'jumlah' => $jumlahBayar,
                                        'keterangan' => 'Migrasi ' . $kodeJB . ' - ' . $taData['tahun_ajaran'],
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ]
                                );
                            }
                        }
                    }

                    // Log success
                    MigrasiLogDetail::create([
                        'migrasi_log_id' => $this->parent->migrasiLogId,
                        'no_pendaftaran' => $matchedNoPendaftaran,
                        'id_siswa' => $id_siswa,
                        'is_new_siswa' => $isNewSiswa,
                        'baris_excel' => $excelRowNum,
                        'status' => 'success',
                        'keterangan' => ($isNewSiswa ? 'Siswa baru' : 'Siswa existing') . ', TA: ' . $kodeTa . ', Tingkat: ' . $currentTingkat,
                    ]);

                    $this->parent->successCount++;
                    DB::commit();
                    $isNewSiswa = false;
                } catch (\Exception $e) {
                    DB::rollBack();
                    $this->parent->failCount++;
                    MigrasiLogDetail::create([
                        'migrasi_log_id' => $this->parent->migrasiLogId,
                        'baris_excel' => $excelRowNum,
                        'status' => 'failed',
                        'keterangan' => 'Error TA ' . $kodeTa . ': ' . $e->getMessage(),
                    ]);
                }

                $currentTingkat++;
            }
        }

        // Update migrasi_log
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

    private function parseTanggal($value)
    {
        if (empty($value)) {
            return null;
        }

        if (is_numeric($value)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}

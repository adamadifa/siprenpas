<?php

namespace App\Imports;

use App\Models\Jobdesk;
use App\Models\JobdeskGroup;
use App\Models\Unit;
use App\Models\Departemen;
use App\Models\Jabatan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Illuminate\Support\Facades\DB;

class JobdeskImport implements WithMultipleSheets, SkipsUnknownSheets
{
    public $errors = [];
    public $successCount = 0;

    public function sheets(): array
    {
        $sheets = [];
        // We support up to 30 sheets in a single file
        for ($i = 0; $i < 30; $i++) {
            $sheets[$i] = new JobdeskVerticalSheet($this, $i + 1);
        }
        return $sheets;
    }

    public function onUnknownSheet($sheetNameOrIndex)
    {
        // Silently skip out-of-bounds sheets
    }
}

class JobdeskVerticalSheet implements ToCollection
{
    protected $parent;
    protected $sheetIndex;

    public function __construct(JobdeskImport $parent, $sheetIndex)
    {
        $this->parent = $parent;
        $this->sheetIndex = $sheetIndex;
    }

    public function collection(Collection $rows)
    {
        // Skip sheet if it is empty or has no rows
        if ($rows->isEmpty()) {
            return;
        }

        // Check if this sheet is the Reference sheet
        $firstCell = isset($rows->first()[0]) ? trim($rows->first()[0]) : '';
        if (str_contains(strtoupper($firstCell), 'REFERENSI')) {
            return;
        }

        // Parse Vertical Layout:
        // Row index 0: Title "GRUP JOBDESK (HEADER)"
        // Row index 1: Column titles: "kode_unit", "kode_dept", "kode_jabatan"
        // Row index 2: Actual values
        if ($rows->count() < 3) {
            return; // Empty data sheet, skip
        }

        $grupRow = $rows->get(2);
        $kodeUnit = isset($grupRow[0]) ? trim($grupRow[0]) : null;
        $kodeDept = isset($grupRow[1]) ? trim($grupRow[1]) : null;
        $kodeJabatan = isset($grupRow[2]) ? trim($grupRow[2]) : null;

        // If the header row values are all empty, we skip this sheet
        if (empty($kodeUnit) && empty($kodeDept) && empty($kodeJabatan)) {
            return;
        }

        $validUnits = Unit::pluck('kode_unit')->toArray();
        $validDepts = Departemen::pluck('kode_dept')->toArray();
        $validJabatans = Jabatan::pluck('kode_jabatan')->toArray();

        $sheetName = "Sheet {$this->sheetIndex}";

        $headerErrors = [];
        if (empty($kodeDept)) {
            $headerErrors[] = "Kode Departemen wajib diisi";
        } elseif (!in_array($kodeDept, $validDepts)) {
            $headerErrors[] = "Kode Departemen '{$kodeDept}' tidak terdaftar";
        }

        if (empty($kodeJabatan)) {
            $headerErrors[] = "Kode Jabatan wajib diisi";
        } elseif (!in_array($kodeJabatan, $validJabatans)) {
            $headerErrors[] = "Kode Jabatan '{$kodeJabatan}' tidak terdaftar";
        }

        if (!empty($kodeUnit) && !in_array($kodeUnit, $validUnits)) {
            $headerErrors[] = "Kode Unit '{$kodeUnit}' tidak terdaftar";
        }

        if (!empty($headerErrors)) {
            $this->parent->errors[] = "[{$sheetName}] Grup: " . implode(', ', $headerErrors);
            return;
        }

        DB::transaction(function () use ($rows, $kodeUnit, $kodeDept, $kodeJabatan, $sheetName) {
            // Find or create the Group in database
            $unitPart = $kodeUnit ?? 'U00';
            $groupId = substr($kodeJabatan . $kodeDept . $unitPart, 0, 10);

            $group = JobdeskGroup::find($groupId);
            if (!$group) {
                $group = JobdeskGroup::create([
                    'kode_jobdesk_group' => $groupId,
                    'kode_unit' => $kodeUnit,
                    'kode_dept' => $kodeDept,
                    'kode_jabatan' => $kodeJabatan
                ]);
            }

            // Detail rows start from Row Index 6 (Excel Row 7)
            // Row index 4: Title "RINCIAN JOBDESK (DETAIL)"
            // Row index 5: Column headers "no", "rincian_jobdesk"
            for ($i = 6; $i < $rows->count(); $i++) {
                $row = $rows->get($i);

                $jobdeskText = isset($row[1]) ? trim($row[1]) : null;
                if (empty($jobdeskText)) {
                    continue; // Skip if rincian is blank
                }

                // Generate sequential code matching prefix
                $lastjobdesk = Jobdesk::orderBy('kode_jobdesk', 'desc')
                    ->where('kode_jobdesk', 'like', $kodeJabatan . $kodeDept . '%')
                    ->first();
                $last_kode_jobdesk = $lastjobdesk != null ? $lastjobdesk->kode_jobdesk : '';
                $kode_jobdesk = buatkode($last_kode_jobdesk, $kodeJabatan . $kodeDept, 4);

                Jobdesk::create([
                    'kode_jobdesk' => $kode_jobdesk,
                    'jobdesk' => $jobdeskText,
                    'kode_jobdesk_group' => $groupId
                ]);
            }
        });
    }
}

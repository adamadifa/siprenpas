<?php

namespace App\Exports;

use App\Models\Jenisbiaya;
use App\Models\Kelas;
use App\Models\Tahunajaran;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TemplateMigrasiHorizontalExport implements WithMultipleSheets
{
    protected $kodeUnit;

    public function __construct($kodeUnit = null)
    {
        $this->kodeUnit = $kodeUnit;
    }

    public function sheets(): array
    {
        return [
            new Sheets\MigrasiHorizontalDataSheet($this->kodeUnit),
            new Sheets\MigrasiHorizontalReferensiSheet(),
        ];
    }
}

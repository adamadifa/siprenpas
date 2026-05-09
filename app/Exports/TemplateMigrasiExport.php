<?php

namespace App\Exports;

use App\Exports\Sheets\SiswaSheetExport;
use App\Exports\Sheets\PembayaranSheetExport;
use App\Exports\Sheets\ReferensiSheetExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TemplateMigrasiExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new SiswaSheetExport(),
            new PembayaranSheetExport(),
            new ReferensiSheetExport()
        ];
    }
}

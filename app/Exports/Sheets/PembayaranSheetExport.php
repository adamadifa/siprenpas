<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PembayaranSheetExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    public function title(): string
    {
        return 'Status Pembayaran';
    }

    public function headings(): array
    {
        return [
            'kode_ta',
            'nama_lengkap',
            'kode_unit',
            'kode_jenis_biaya',
            'jumlah_sudah_bayar',
            'keterangan'
        ];
    }

    public function collection()
    {
        return collect([]);
    }
}

<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SiswaSheetExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    public function title(): string
    {
        return 'Data Siswa';
    }

    public function headings(): array
    {
        return [
            'kode_ta',
            'nisn',
            'nama_lengkap',
            'jenis_kelamin',
            'tempat_lahir',
            'tanggal_lahir',
            'anak_ke',
            'jumlah_saudara',
            'alamat',
            'kode_pos',
            'no_kk',
            'nik_ayah',
            'nama_ayah',
            'pendidikan_ayah',
            'pekerjaan_ayah',
            'nik_ibu',
            'nama_ibu',
            'pendidikan_ibu',
            'pekerjaan_ibu',
            'no_hp_orang_tua',
            'kode_unit',
            'tingkat_sekarang',
            'nis',
            'nama_kelas'
        ];
    }

    public function collection()
    {
        // Return empty collection for template
        return collect([]);
    }
}

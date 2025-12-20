<?php

namespace App\Exports;

use App\Models\PendaftaranGotTalent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PendaftaranGotTalentExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $pendaftaranGotTalent;

    public function __construct($pendaftaranGotTalent)
    {
        $this->pendaftaranGotTalent = $pendaftaranGotTalent;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->pendaftaranGotTalent;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nomor Register',
            'Nama Lengkap',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenjang Pendidikan',
            'Asal Sekolah',
            'Alamat Sekolah',
            'Alamat Rumah',
            'No. HP',
            'Email',
            'Lomba yang Diikuti',
            'Tanggal Daftar'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        static $no = 0;
        $no++;

        // Ambil data lomba yang diikuti
        $lomba = $row->perlombaan->pluck('jenis_perlombaan')->implode(', ');

        return [
            $no,
            $row->nomor_register,
            $row->nama_lengkap,
            $row->tempat_lahir ?? '-',
            $row->tanggal_lahir ? date('d-m-Y', strtotime($row->tanggal_lahir)) : '-',
            $row->jenjangPendidikan->jenjang_pendidikan ?? '-',
            $row->asal_sekolah ?? '-',
            $row->alamat_sekolah ?? '-',
            $row->alamat_rumah ?? '-',
            $row->no_hp ?? '-',
            $row->email ?? '-',
            $lomba ?: '-',
            $row->created_at ? date('d-m-Y H:i:s', strtotime($row->created_at)) : '-'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}


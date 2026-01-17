<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PendaftaranOnlineExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $pendaftaran;

    public function __construct($pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->pendaftaran;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'No. Register',
            'Tanggal Register',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Unit',
            'Tahun Ajaran',
            'Alamat',
            'No. HP',
            'Asal Sekolah',
            'Nama Ayah',
            'Nama Ibu',
            'Status'
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

        $status = 'Belum Konfirmasi';
        if (!empty($row->no_pendaftaran)) {
            $status = 'Sudah Verifikasi';
        } elseif (!empty($row->id_bayar)) {
            $status = 'Sudah Konfirmasi';
        }

        $jenis_kelamin = $row->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';

        return [
            $no,
            $row->no_register,
            date('d-m-Y', strtotime($row->tanggal_register)),
            $row->nama_lengkap,
            $jenis_kelamin,
            $row->tempat_lahir,
            $row->tanggal_lahir ? date('d-m-Y', strtotime($row->tanggal_lahir)) : '',
            $row->nama_unit,
            $row->tahun_ajaran,
            $row->alamat,
            $row->no_hp,
            $row->asal_sekolah,
            $row->nama_ayah,
            $row->nama_ibu,
            $status
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

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PendaftaranExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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
            'No. Pendaftaran',
            'Tanggal Pendaftaran',
            'NIS',
            'RFID Code',
            'ID Siswa',
            'NISN',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Anak Ke',
            'Jumlah Saudara',
            'Alamat',
            'Provinsi',
            'Kota/Kabupaten',
            'Kecamatan',
            'Desa/Kelurahan',
            'Kode Pos',
            'No. KK',
            'NIK Ayah',
            'Nama Ayah',
            'Pendidikan Ayah',
            'Pekerjaan Ayah',
            'NIK Ibu',
            'Nama Ibu',
            'Pendidikan Ibu',
            'Pekerjaan Ibu',
            'No. HP Orang Tua',
            'Unit',
            'Tahun Ajaran',
            'Tingkat',
            'Kelas',
            'Asal Sekolah',
            'Jenis Pendaftaran',
            'Tingkat Masuk'
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

        $jenis_kelamin = $row->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';

        return [
            $no,
            $row->no_pendaftaran,
            $row->tanggal_pendaftaran ? date('d-m-Y', strtotime($row->tanggal_pendaftaran)) : '',
            $row->nis ?? '-',
            $row->rfid_code ?? '-',
            $row->id_siswa,
            $row->nisn ?? '-',
            $row->nama_lengkap,
            $jenis_kelamin,
            $row->tempat_lahir,
            $row->tanggal_lahir ? date('d-m-Y', strtotime($row->tanggal_lahir)) : '',
            $row->anak_ke ?? '-',
            $row->jumlah_saudara ?? '-',
            $row->alamat,
            $row->provinsi ?? '-',
            $row->kota ?? '-',
            $row->kecamatan ?? '-',
            $row->desa ?? '-',
            $row->kode_pos ?? '-',
            $row->no_kk ? "'" . $row->no_kk : '-', // prepend quote to prevent Excel scientific notation conversion
            $row->nik_ayah ? "'" . $row->nik_ayah : '-',
            $row->nama_ayah ?? '-',
            $row->pendidikan_ayah ?? '-',
            $row->pekerjaan_ayah ?? '-',
            $row->nik_ibu ? "'" . $row->nik_ibu : '-',
            $row->nama_ibu ?? '-',
            $row->pendidikan_ibu ?? '-',
            $row->pekerjaan_ibu ?? '-',
            $row->no_hp_orang_tua ? "'" . $row->no_hp_orang_tua : '-',
            $row->nama_unit ?? '-',
            $row->tahun_ajaran ?? '-',
            $row->tingkat ?? '-',
            $row->nama_kelas ?? '-',
            $row->nama_asal_sekolah ?? '-',
            $row->jenis_pendaftaran ?? 'Regular',
            $row->tingkat_masuk ?? '-'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 11]],
        ];
    }
}

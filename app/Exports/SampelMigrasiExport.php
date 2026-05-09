<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;

class SampelMigrasiExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new SampelSiswaSheet(),
            new SampelPembayaranSheet(),
        ];
    }
}

class SampelSiswaSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    public function title(): string { return 'Data Siswa'; }

    public function headings(): array {
        return [
            'kode_ta', 'nisn', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir',
            'tanggal_lahir', 'anak_ke', 'jumlah_saudara', 'alamat', 'kode_pos',
            'no_kk', 'nik_ayah', 'nama_ayah', 'pendidikan_ayah', 'pekerjaan_ayah',
            'nik_ibu', 'nama_ibu', 'pendidikan_ibu', 'pekerjaan_ibu',
            'no_hp_orang_tua', 'kode_unit', 'tingkat_sekarang', 'nis', 'nama_kelas'
        ];
    }

    public function collection()
    {
        $data = [];
        $namaL = ['Ahmad Fauzi', 'Budi Santoso', 'Cahyo Wibowo', 'Dani Pratama', 'Eko Saputra',
            'Fajar Nugroho', 'Galih Permana', 'Hasan Maulana', 'Ilham Ramadhan', 'Joko Susanto'];
        $namaP = ['Aisyah Putri', 'Bunga Lestari', 'Citra Dewi', 'Dina Rahmawati', 'Ela Fitriani',
            'Fatimah Zahra', 'Gina Amelia', 'Hana Safira', 'Intan Permata', 'Julia Sari'];

        // ============================================================
        // CASE 1: 10 Siswa Tingkat 3 (3 baris per siswa = 3 TA)
        // ============================================================
        foreach ($namaL as $i => $nama) {
            $no = str_pad($i + 1, 3, '0', STR_PAD_LEFT);
            $tglLahir = '2010-' . str_pad(($i % 12) + 1, 2, '0', STR_PAD_LEFT) . '-15';

            // Baris 1: TA 2023/2024, Tingkat 1 (masuk pertama kali)
            $data[] = [
                'TA2324', '0011223' . $no, $nama, 'L', 'Jakarta',
                $tglLahir, $i + 1, 2, 'Jl. Sampel No.' . ($i + 1), '12345',
                '3311001122' . $no, '33110011' . $no, 'Ayah ' . $nama, 'S1', 'Wiraswasta',
                '33110012' . $no, 'Ibu ' . $nama, 'SMA', 'Ibu Rumah Tangga',
                '0812000' . $no, 'U04', 1, '', ''
            ];

            // Baris 2: TA 2024/2025, Tingkat 2 (naik kelas)
            $data[] = [
                'TA2425', '', $nama, 'L', 'Jakarta',
                $tglLahir, '', '', '', '',
                '', '', '', '', '',
                '', '', '', '',
                '', 'U04', 2, '', ''
            ];

            // Baris 3: TA 2025/2026, Tingkat 3 (tahun aktif)
            $data[] = [
                'TA2526', '', $nama, 'L', 'Jakarta',
                $tglLahir, '', '', '', '',
                '', '', '', '', '',
                '', '', '', '',
                '', 'U04', 3, '', ''
            ];
        }

        // ============================================================
        // CASE 2: 10 Siswi Tingkat 2 (2 baris per siswa = 2 TA)
        // ============================================================
        foreach ($namaP as $i => $nama) {
            $no = str_pad($i + 11, 3, '0', STR_PAD_LEFT);
            $tglLahir = '2011-' . str_pad(($i % 12) + 1, 2, '0', STR_PAD_LEFT) . '-20';

            // Baris 1: TA 2024/2025, Tingkat 1 (masuk pertama kali)
            $data[] = [
                'TA2425', '0044556' . $no, $nama, 'P', 'Bandung',
                $tglLahir, $i + 1, 1, 'Jl. Contoh No.' . ($i + 1), '40123',
                '3271001122' . $no, '32710011' . $no, 'Ayah ' . $nama, 'SMA', 'Pedagang',
                '32710012' . $no, 'Ibu ' . $nama, 'S1', 'Guru',
                '0813000' . $no, 'U04', 1, '', ''
            ];

            // Baris 2: TA 2025/2026, Tingkat 2 (tahun aktif)
            $data[] = [
                'TA2526', '', $nama, 'P', 'Bandung',
                $tglLahir, '', '', '', '',
                '', '', '', '', '',
                '', '', '', '',
                '', 'U04', 2, '', ''
            ];
        }

        return collect($data);
    }
}

class SampelPembayaranSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    public function title(): string { return 'Status Pembayaran'; }

    public function headings(): array {
        return ['kode_ta', 'nama_lengkap', 'kode_unit', 'kode_jenis_biaya', 'jumlah_sudah_bayar', 'keterangan'];
    }

    public function collection()
    {
        $data = [];
        $namaL = ['Ahmad Fauzi', 'Budi Santoso', 'Cahyo Wibowo', 'Dani Pratama', 'Eko Saputra',
            'Fajar Nugroho', 'Galih Permana', 'Hasan Maulana', 'Ilham Ramadhan', 'Joko Susanto'];
        $namaP = ['Aisyah Putri', 'Bunga Lestari', 'Citra Dewi', 'Dina Rahmawati', 'Ela Fitriani',
            'Fatimah Zahra', 'Gina Amelia', 'Hana Safira', 'Intan Permata', 'Julia Sari'];

        // ============================================================
        // Siswa Tingkat 3: Pembayaran di 3 TA
        // ============================================================
        foreach ($namaL as $nama) {
            // TA 2023/2024 - Infaq Bangunan (lunas)
            $data[] = ['TA2324', $nama, 'U04', 'B02', 5000000, 'Infaq Bangunan TA 2023/2024 - LUNAS'];
            // TA 2024/2025 - Infaq Bangunan (lunas)
            $data[] = ['TA2425', $nama, 'U04', 'B02', 5000000, 'Infaq Bangunan TA 2024/2025 - LUNAS'];
            // TA 2025/2026 - Infaq Bangunan (baru bayar sebagian)
            $data[] = ['TA2526', $nama, 'U04', 'B02', 2000000, 'Infaq Bangunan TA 2025/2026 - Cicilan 1'];
        }

        // ============================================================
        // Siswi Tingkat 2: Pembayaran di 2 TA
        // ============================================================
        foreach ($namaP as $nama) {
            // TA 2024/2025 - Infaq Bangunan (lunas)
            $data[] = ['TA2425', $nama, 'U04', 'B02', 5000000, 'Infaq Bangunan TA 2024/2025 - LUNAS'];
            // TA 2025/2026 - Infaq Bangunan (belum bayar)
            // Tidak diisi = tagihan masih penuh
        }

        return collect($data);
    }
}

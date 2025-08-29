<?php

namespace Database\Seeders;

use App\Models\PrestasiSiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrestasiSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prestasiSiswa = [
            [
                'nama_siswa' => 'Ahmad Fadli',
                'prestasi' => 'Juara 1 Lomba Matematika Tingkat Kecamatan',
                'tingkat' => 'kecamatan',
                'status' => 1
            ],
            [
                'nama_siswa' => 'Siti Nurhaliza',
                'prestasi' => 'Juara 2 Lomba Membaca Puisi Tingkat Kabupaten',
                'tingkat' => 'kabupaten',
                'status' => 1
            ],
            [
                'nama_siswa' => 'Muhammad Rizki',
                'prestasi' => 'Juara 1 Olimpiade Sains Nasional (OSN) Tingkat Nasional',
                'tingkat' => 'nasional',
                'status' => 1
            ],
            [
                'nama_siswa' => 'Nurul Hidayati',
                'prestasi' => 'Juara 3 Lomba Menulis Cerpen Tingkat Kecamatan',
                'tingkat' => 'kecamatan',
                'status' => 1
            ],
            [
                'nama_siswa' => 'Budi Santoso',
                'prestasi' => 'Juara 1 Lomba Robotik Tingkat Kabupaten',
                'tingkat' => 'kabupaten',
                'status' => 1
            ],
            [
                'nama_siswa' => 'Dewi Sartika',
                'prestasi' => 'Juara 2 Lomba Bahasa Inggris Tingkat Nasional',
                'tingkat' => 'nasional',
                'status' => 1
            ],
            [
                'nama_siswa' => 'Rizki Pratama',
                'prestasi' => 'Juara 1 Lomba Menggambar Tingkat Kecamatan',
                'tingkat' => 'kecamatan',
                'status' => 1
            ],
            [
                'nama_siswa' => 'Anisa Putri',
                'prestasi' => 'Juara 3 Lomba Cerdas Cermat Tingkat Kabupaten',
                'tingkat' => 'kabupaten',
                'status' => 1
            ]
        ];

        foreach ($prestasiSiswa as $prestasi) {
            PrestasiSiswa::create($prestasi);
        }
    }
}

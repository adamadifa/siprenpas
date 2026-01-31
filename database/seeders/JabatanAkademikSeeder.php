<?php

namespace Database\Seeders;

use App\Models\JabatanAkademik;
use Illuminate\Database\Seeder;

class JabatanAkademikSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode_jabatan' => 'KEPSEK',
                'nama_jabatan' => 'Kepala Sekolah',
                'urutan' => 1,
                'tampil_di_raport' => 1
            ],
            [
                'kode_jabatan' => 'WAKA_KUR',
                'nama_jabatan' => 'Waka Kurikulum',
                'urutan' => 2,
                'tampil_di_raport' => 0
            ],
            [
                'kode_jabatan' => 'WAKA_KES',
                'nama_jabatan' => 'Waka Kesiswaan',
                'urutan' => 3,
                'tampil_di_raport' => 0
            ],
            [
                'kode_jabatan' => 'GURU',
                'nama_jabatan' => 'Guru Mata Pelajaran',
                'urutan' => 4,
                'tampil_di_raport' => 0 // Biasanya wali kelas yang tanda tangan, bukan guru mapel di raport utama, tapi nanti bisa disesuaikan
            ],
            [
                'kode_jabatan' => 'WALI_KELAS',
                'nama_jabatan' => 'Wali Kelas',
                'urutan' => 5,
                'tampil_di_raport' => 1
            ]
        ];

        foreach ($data as $d) {
            JabatanAkademik::updateOrCreate(['kode_jabatan' => $d['kode_jabatan']], $d);
        }
    }
}

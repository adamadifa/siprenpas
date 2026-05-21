<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Misi;

class MisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataMisi = [
            [
                'judul' => 'Pencetak Kader Muslim 5M',
                'deskripsi' => 'Menjadi lembaga pencetak kader muslim dengan predikat 5M'
            ],
            [
                'judul' => 'Amar Ma\'ruf Nahyi Munkar',
                'deskripsi' => 'Menjadi lembaga dan wahana amar ma\'ruf nahyi munkar'
            ],
            [
                'judul' => 'Penopang Masyarakat',
                'deskripsi' => 'Menjadi penopang, pendorong, dan pemandu majunya masyarakat'
            ],
            [
                'judul' => 'Pilot Proyek Masyarakat Islam',
                'deskripsi' => 'Menjadi pilot proyek masyarakat islam yang menjunjung tinggi Al-Qur\'an dan Hadits dalam wadah NKRI'
            ],
            [
                'judul' => 'Corong Usaha Pertanian',
                'deskripsi' => 'Menjadi corong usaha bidang Pertanian'
            ],
            [
                'judul' => 'Ekonomi & Perdagangan',
                'deskripsi' => 'Peternakan, Ekonomi, Perdagangan, dan Perindustrian'
            ]
        ];

        foreach ($dataMisi as $misi) {
            Misi::firstOrCreate(['judul' => $misi['judul']], $misi);
        }
    }
}

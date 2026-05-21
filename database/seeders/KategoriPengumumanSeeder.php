<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriPengumuman;

class KategoriPengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            ['nama_kategori' => 'Keuangan'],
            ['nama_kategori' => 'Akademik'],
            ['nama_kategori' => 'Kegiatan'],
            ['nama_kategori' => 'Umum'],
            ['nama_kategori' => 'Beasiswa'],
        ];

        foreach ($kategori as $kat) {
            KategoriPengumuman::firstOrCreate($kat);
        }
    }
}

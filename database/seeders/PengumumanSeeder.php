<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengumuman;
use App\Models\KategoriPengumuman;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil kategori keuangan
        $kategoriKeuangan = KategoriPengumuman::where('nama_kategori', 'Keuangan')->first();
        
        if ($kategoriKeuangan) {
            Pengumuman::create([
                'judul' => 'Pembayaran UKT',
                'isi' => 'Segera lakukan pembayaran UKT semester ganjil.',
                'tanggal' => '2025-06-26',
                'kategori_id' => $kategoriKeuangan->id,
                'lokasi' => 'Bank Syariah Mandiri, Kampus Pusat',
            ]);
        }

        // Tambah beberapa pengumuman contoh lainnya
        $kategoriAkademik = KategoriPengumuman::where('nama_kategori', 'Akademik')->first();
        if ($kategoriAkademik) {
            Pengumuman::create([
                'judul' => 'Jadwal Ujian Semester',
                'isi' => 'Ujian semester akan dilaksanakan pada tanggal 15-20 Juni 2025.',
                'tanggal' => '2025-06-15',
                'kategori_id' => $kategoriAkademik->id,
                'lokasi' => 'Ruang Kelas',
            ]);
        }

        $kategoriKegiatan = KategoriPengumuman::where('nama_kategori', 'Kegiatan')->first();
        if ($kategoriKegiatan) {
            Pengumuman::create([
                'judul' => 'Kegiatan Outbound',
                'isi' => 'Kegiatan outbound akan dilaksanakan pada tanggal 25 Juni 2025.',
                'tanggal' => '2025-06-25',
                'kategori_id' => $kategoriKegiatan->id,
                'lokasi' => 'Taman Wisata Alam',
            ]);
        }
    }
}

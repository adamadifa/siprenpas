<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\DB;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('mata_pelajaran')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $kodeUnit = 'U04';
        $counter = 1;

        // Helper function to generate code
        $generateCode = function() use ($kodeUnit, &$counter) {
            return 'MP' . $kodeUnit . str_pad($counter++, 3, '0', STR_PAD_LEFT);
        };

        // --- KELOMPOK A ---

        // 1. Ilmu Tauhid
        MataPelajaran::create([
            'kode_matpel' => $generateCode(),
            'nama_matpel' => 'Ilmu Tauhid',
            'kelompok' => 'A',
            'urutan' => 1,
            'kode_unit' => $kodeUnit
        ]);

        // 2. Ilmu Akhlak
        MataPelajaran::create([
            'kode_matpel' => $generateCode(),
            'nama_matpel' => 'Ilmu Akhlak (Bulughul Marom)',
            'kelompok' => 'A',
            'urutan' => 2,
            'kode_unit' => $kodeUnit
        ]);

        // 3. Al-Qur'an (PARENT)
        $alquran = MataPelajaran::create([
            'kode_matpel' => $generateCode(),
            'nama_matpel' => "Al-Qur'an",
            'kelompok' => 'A',
            'urutan' => 3,
            'kode_unit' => $kodeUnit
        ]);

            // Child Al-Qur'an
            MataPelajaran::create(['kode_matpel' => $generateCode(), 'kode_unit' => $kodeUnit, 'nama_matpel' => 'Tafsir', 'kelompok' => 'A', 'parent_id' => $alquran->id, 'urutan' => 1]);
            MataPelajaran::create(['kode_matpel' => $generateCode(), 'kode_unit' => $kodeUnit, 'nama_matpel' => 'Tahsin', 'kelompok' => 'A', 'parent_id' => $alquran->id, 'urutan' => 2]);
            MataPelajaran::create(['kode_matpel' => $generateCode(), 'kode_unit' => $kodeUnit, 'nama_matpel' => 'Tajwid', 'kelompok' => 'A', 'parent_id' => $alquran->id, 'urutan' => 3]);
            MataPelajaran::create(['kode_matpel' => $generateCode(), 'kode_unit' => $kodeUnit, 'nama_matpel' => 'Tahfidz', 'kelompok' => 'A', 'parent_id' => $alquran->id, 'urutan' => 4]);

        // 4. Syari'ah (PARENT)
        $syariah = MataPelajaran::create([
            'kode_matpel' => $generateCode(),
            'nama_matpel' => "Syari'ah",
            'kelompok' => 'A',
            'urutan' => 4,
            'kode_unit' => $kodeUnit
        ]);

            // Child Syari'ah
            MataPelajaran::create(['kode_matpel' => $generateCode(), 'kode_unit' => $kodeUnit, 'nama_matpel' => 'Fiqih', 'kelompok' => 'A', 'parent_id' => $syariah->id, 'urutan' => 1]);
            MataPelajaran::create(['kode_matpel' => $generateCode(), 'kode_unit' => $kodeUnit, 'nama_matpel' => 'Ushul Fiqih', 'kelompok' => 'A', 'parent_id' => $syariah->id, 'urutan' => 2]);
            MataPelajaran::create(['kode_matpel' => $generateCode(), 'kode_unit' => $kodeUnit, 'nama_matpel' => "Faro'idh", 'kelompok' => 'A', 'parent_id' => $syariah->id, 'urutan' => 3]);

        // 5. Mustholah Hadits
        MataPelajaran::create([
            'kode_matpel' => $generateCode(),
            'nama_matpel' => 'Mustholah Hadits',
            'kelompok' => 'A',
            'urutan' => 5,
            'kode_unit' => $kodeUnit
        ]);

        // 6. Shohih Bukhori
        MataPelajaran::create([
            'kode_matpel' => $generateCode(),
            'nama_matpel' => 'Shohih Bukhori',
            'kelompok' => 'A',
            'urutan' => 6,
            'kode_unit' => $kodeUnit
        ]);

        // 7. Bahasa Arab I (PARENT)
        $bArab1 = MataPelajaran::create([
            'kode_matpel' => $generateCode(),
            'nama_matpel' => "Bahasa Arab I",
            'kelompok' => 'A',
            'urutan' => 7,
            'kode_unit' => $kodeUnit
        ]);
            // Child B.Arab I
            MataPelajaran::create(['kode_matpel' => $generateCode(), 'kode_unit' => $kodeUnit, 'nama_matpel' => 'Nahwiyyah', 'kelompok' => 'A', 'parent_id' => $bArab1->id, 'urutan' => 1]);
            MataPelajaran::create(['kode_matpel' => $generateCode(), 'kode_unit' => $kodeUnit, 'nama_matpel' => 'Shorof', 'kelompok' => 'A', 'parent_id' => $bArab1->id, 'urutan' => 2]);
            MataPelajaran::create(['kode_matpel' => $generateCode(), 'kode_unit' => $kodeUnit, 'nama_matpel' => 'Insya', 'kelompok' => 'A', 'parent_id' => $bArab1->id, 'urutan' => 3]);
            MataPelajaran::create(['kode_matpel' => $generateCode(), 'kode_unit' => $kodeUnit, 'nama_matpel' => "I'rob", 'kelompok' => 'A', 'parent_id' => $bArab1->id, 'urutan' => 4]);

        // 8. Bahasa Arab II (PARENT)
        $bArab2 = MataPelajaran::create([
            'kode_matpel' => $generateCode(),
            'nama_matpel' => "Bahasa Arab II",
            'kelompok' => 'A',
            'urutan' => 8,
            'kode_unit' => $kodeUnit
        ]);
            // Child B.Arab II
            MataPelajaran::create(['kode_matpel' => $generateCode(), 'kode_unit' => $kodeUnit, 'nama_matpel' => 'Hiwar/Muhadatsah', 'kelompok' => 'A', 'parent_id' => $bArab2->id, 'urutan' => 1]);
            MataPelajaran::create(['kode_matpel' => $generateCode(), 'kode_unit' => $kodeUnit, 'nama_matpel' => 'Balaghoh', 'kelompok' => 'A', 'parent_id' => $bArab2->id, 'urutan' => 2]);

        // 9. Tarikh/Siroh Nabawiyah
        MataPelajaran::create([
            'kode_matpel' => $generateCode(),
            'nama_matpel' => 'Tarikh/Siroh Nabawiyah',
            'kelompok' => 'A',
            'urutan' => 9,
            'kode_unit' => $kodeUnit
        ]);


        // --- KELOMPOK B ---

        // 1. Imla/Khot
        MataPelajaran::create([
            'kode_matpel' => $generateCode(),
            'nama_matpel' => 'Imla/Khot',
            'kelompok' => 'B',
            'urutan' => 1,
            'kode_unit' => $kodeUnit
        ]);

        // 2. Khitobah
        MataPelajaran::create([
            'kode_matpel' => $generateCode(),
            'nama_matpel' => 'Khitobah',
            'kelompok' => 'B',
            'urutan' => 2,
            'kode_unit' => $kodeUnit
        ]);
    }
}

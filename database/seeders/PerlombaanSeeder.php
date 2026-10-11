<?php

namespace Database\Seeders;

use App\Models\JenjangPendidikan;
use App\Models\Perlombaan;
use Illuminate\Database\Seeder;

class PerlombaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID Jenjang Pendidikan
        $kober = JenjangPendidikan::where('jenjang_pendidikan', 'like', '%Kober%')->first();
        $tk = JenjangPendidikan::where('jenjang_pendidikan', 'like', '%TK%')->first();
        $sd = JenjangPendidikan::where('jenjang_pendidikan', 'like', '%SD%')->first();
        $smp = JenjangPendidikan::where('jenjang_pendidikan', 'like', '%SMP%')->first();

        $defaultContact = '081234567890';
        $defaultBiaya = 0;

        $daftarPerlombaan = [
            // 1. Lomba mewarnai ibu dan anak tingkat Kober
            [
                'jenis_perlombaan' => 'Lomba Mewarnai Ibu dan Anak',
                'id_jenjang' => $kober ? $kober->id : 1,
                'biaya_pendaftaran' => $defaultBiaya,
                'contact_person' => $defaultContact,
            ],
            // 2. Lomba mewarnai ibu dan anak tingkat TK/ RA/ sederajat
            [
                'jenis_perlombaan' => 'Lomba Mewarnai Ibu dan Anak',
                'id_jenjang' => $tk ? $tk->id : 2,
                'biaya_pendaftaran' => $defaultBiaya,
                'contact_person' => $defaultContact,
            ],
            // 3. Lomba menggambar tingkat sd
            [
                'jenis_perlombaan' => 'Lomba Menggambar',
                'id_jenjang' => $sd ? $sd->id : 3,
                'biaya_pendaftaran' => $defaultBiaya,
                'contact_person' => $defaultContact,
            ],
            // 4. Lomba dai cilik tingkat sd
            [
                'jenis_perlombaan' => 'Lomba Dai Cilik',
                'id_jenjang' => $sd ? $sd->id : 3,
                'biaya_pendaftaran' => $defaultBiaya,
                'contact_person' => $defaultContact,
            ],
            // 5. Lomba tahfidz tingkat SD
            [
                'jenis_perlombaan' => 'Lomba Tahfidz',
                'id_jenjang' => $sd ? $sd->id : 3,
                'biaya_pendaftaran' => $defaultBiaya,
                'contact_person' => $defaultContact,
            ],
            // 6. Lomba coc olimpiade matematika tingkat SMP/ mts sederajat
            [
                'jenis_perlombaan' => 'Lomba COC Olimpiade Matematika',
                'id_jenjang' => $smp ? $smp->id : 4,
                'biaya_pendaftaran' => $defaultBiaya,
                'contact_person' => $defaultContact,
            ],
            // 7. Lomba olimpiade BHS inggris tingkat SMP/ mts sederajat
            [
                'jenis_perlombaan' => 'Lomba Olimpiade Bahasa Inggris',
                'id_jenjang' => $smp ? $smp->id : 4,
                'biaya_pendaftaran' => $defaultBiaya,
                'contact_person' => $defaultContact,
            ],
            // 8. Lomba tahfidz tingkat SMP / mts sederajat
            [
                'jenis_perlombaan' => 'Lomba Tahfidz',
                'id_jenjang' => $smp ? $smp->id : 4,
                'biaya_pendaftaran' => $defaultBiaya,
                'contact_person' => $defaultContact,
            ],
            // 9. Archery tingkat sd
            [
                'jenis_perlombaan' => 'Lomba Archery (Panahan)',
                'id_jenjang' => $sd ? $sd->id : 3,
                'biaya_pendaftaran' => $defaultBiaya,
                'contact_person' => $defaultContact,
            ],
            // 10. Archery tingkat smp/ mts / sederajat
            [
                'jenis_perlombaan' => 'Lomba Archery (Panahan)',
                'id_jenjang' => $smp ? $smp->id : 4,
                'biaya_pendaftaran' => $defaultBiaya,
                'contact_person' => $defaultContact,
            ],
        ];

        foreach ($daftarPerlombaan as $lomba) {
            Perlombaan::create($lomba);
        }
    }
}

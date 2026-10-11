<?php

namespace Database\Seeders;

use App\Models\Perlombaan;
use Illuminate\Database\Seeder;

class BiayaPerlombaanSeeder extends Seeder
{
    /**
     * Set biaya pendaftaran untuk setiap cabang lomba AGT sesuai ketentuan:
     * - Mewarnai Kober dan TK: Gratis (Rp 0)
     * - Archery (SD & SMP): Rp 75.000 / orang
     * - Olimpiade Matematika (COC): Rp 75.000 / group (1 group 3 org)
     * - Olimpiade Bahasa Inggris: Rp 20.000
     * - Dai Cilik: Rp 15.000
     * - MHQ / Tahfidz SD: Rp 20.000
     * - MHQ / Tahfidz MTs / SMP: Rp 20.000
     */
    public function run(): void
    {
        $perlombaanList = Perlombaan::with('jenjangPendidikan')->get();

        foreach ($perlombaanList as $item) {
            $nama = strtolower($item->jenis_perlombaan);
            $jenjang = strtolower($item->jenjangPendidikan?->jenjang_pendidikan ?? '');

            // 1. Mewarnai Kober dan TK -> Gratis
            if (str_contains($nama, 'mewarnai') || str_contains($nama, 'menggambar')) {
                if (str_contains($jenjang, 'kober') || str_contains($jenjang, 'tk')) {
                    $item->update(['biaya_pendaftaran' => 0]);
                } else {
                    // Jenjang SD/MI jika ada lomba menggambar/mewarnai
                    $item->update(['biaya_pendaftaran' => 0]);
                }
            }

            // 2. Archery -> 75.000 per orang (SD & SMP)
            elseif (str_contains($nama, 'archery') || str_contains($nama, 'panah')) {
                $item->update(['biaya_pendaftaran' => 75000]);
            }

            // 3. Olimpiade Matematika -> 75.000 per group (3 orang)
            elseif (str_contains($nama, 'matematika')) {
                $item->update(['biaya_pendaftaran' => 75000]);
            }

            // 4. Bahasa Inggris -> 20.000
            elseif (str_contains($nama, 'inggris')) {
                $item->update(['biaya_pendaftaran' => 20000]);
            }

            // 5. Dai Cilik -> 15.000
            elseif (str_contains($nama, 'dai')) {
                $item->update(['biaya_pendaftaran' => 15000]);
            }

            // 6. MHQ SD -> 20.000 & MHQ MTs -> 20.000
            elseif (str_contains($nama, 'tahfidz') || str_contains($nama, 'mhq')) {
                $item->update(['biaya_pendaftaran' => 20000]);
            }
        }
    }
}

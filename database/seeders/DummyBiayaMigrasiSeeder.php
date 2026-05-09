<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder untuk membuat data dummy konfigurasi biaya
 * yang dibutuhkan untuk testing migrasi siswa.
 *
 * Data yang dibuat:
 * - TA 2023/2024 (TA2324) -> jika belum ada
 * - Konfigurasi Biaya U04 (MTs) Tingkat 1,2,3 untuk TA2324, TA2425, TA2526
 * - Detail biaya (B01-B10) untuk setiap konfigurasi
 */
class DummyBiayaMigrasiSeeder extends Seeder
{
    public function run(): void
    {
        // ===================================
        // 1. Pastikan TA 2023/2024 ada
        // ===================================
        DB::table('konfigurasi_tahun_ajaran')->updateOrInsert(
            ['kode_ta' => 'TA2324'],
            [
                'tahun_ajaran' => '2023/2024',
                'status' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        echo "✓ TA 2023/2024 (TA2324) ready\n";

        // ===================================
        // 2. Template detail biaya (sama untuk semua tingkat/TA)
        // ===================================
        $detailBiaya = [
            ['kode_jenis_biaya' => 'B01', 'jumlah' => 300000],    // Pendaftaran
            ['kode_jenis_biaya' => 'B02', 'jumlah' => 5000000],   // Infaq Bangunan
            ['kode_jenis_biaya' => 'B03', 'jumlah' => 1000000],   // Infaq Sarana Prasarana
            ['kode_jenis_biaya' => 'B04', 'jumlah' => 750000],    // Media Pembelajaran
            ['kode_jenis_biaya' => 'B05', 'jumlah' => 1000000],   // Seragam
            ['kode_jenis_biaya' => 'B06', 'jumlah' => 1300000],   // Kegiatan Santri Baru
            ['kode_jenis_biaya' => 'B07', 'jumlah' => 3600000],   // SPP
        ];

        // ===================================
        // 3. Buat konfigurasi biaya per TA per Tingkat
        // ===================================
        $configs = [
            // TA 2023/2024 - Tingkat 1, 2, 3
            ['kode_biaya' => 'U0412324', 'kode_unit' => 'U04', 'tingkat' => 1, 'kode_ta' => 'TA2324'],
            ['kode_biaya' => 'U0422324', 'kode_unit' => 'U04', 'tingkat' => 2, 'kode_ta' => 'TA2324'],
            ['kode_biaya' => 'U0432324', 'kode_unit' => 'U04', 'tingkat' => 3, 'kode_ta' => 'TA2324'],
            // TA 2024/2025 - Tingkat 1, 2, 3
            ['kode_biaya' => 'U0412425', 'kode_unit' => 'U04', 'tingkat' => 1, 'kode_ta' => 'TA2425'],
            ['kode_biaya' => 'U0422425', 'kode_unit' => 'U04', 'tingkat' => 2, 'kode_ta' => 'TA2425'],
            ['kode_biaya' => 'U0432425', 'kode_unit' => 'U04', 'tingkat' => 3, 'kode_ta' => 'TA2425'],
            // TA 2025/2026 - Tingkat 2, 3 (Tingkat 1 sudah ada: U0412526)
            ['kode_biaya' => 'U0422526', 'kode_unit' => 'U04', 'tingkat' => 2, 'kode_ta' => 'TA2526'],
            ['kode_biaya' => 'U0432526', 'kode_unit' => 'U04', 'tingkat' => 3, 'kode_ta' => 'TA2526'],
        ];

        foreach ($configs as $config) {
            // Insert konfigurasi_biaya
            DB::table('konfigurasi_biaya')->updateOrInsert(
                ['kode_biaya' => $config['kode_biaya']],
                [
                    'kode_unit' => $config['kode_unit'],
                    'tingkat' => $config['tingkat'],
                    'kode_ta' => $config['kode_ta'],
                    'asrama' => 0,
                    'is_pindahan' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Insert detail biaya
            foreach ($detailBiaya as $detail) {
                DB::table('konfigurasi_biaya_detail')->updateOrInsert(
                    [
                        'kode_biaya' => $config['kode_biaya'],
                        'kode_jenis_biaya' => $detail['kode_jenis_biaya'],
                    ],
                    [
                        'jumlah' => $detail['jumlah'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            echo "✓ Biaya {$config['kode_biaya']} (Unit {$config['kode_unit']}, Tingkat {$config['tingkat']}, TA {$config['kode_ta']}) + " . count($detailBiaya) . " detail\n";
        }

        echo "\n=== SELESAI ===\n";
        echo "Total konfigurasi biaya: " . count($configs) . "\n";
        echo "Detail per konfigurasi: " . count($detailBiaya) . " jenis biaya\n";
    }
}

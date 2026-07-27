<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Pendaftaran;
use App\Models\Biayasiswa;
use App\Models\Biaya;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MAPendaftaranTambahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kode_unit = 'U05'; // MA
        $kode_ta = 'TA2627'; // Tahun Ajaran 2026/2027
        $tahun_ajaran_str = '2026/2027';
        $ta_ppdb = explode("/", $tahun_ajaran_str);
        $tahun_masuk = $ta_ppdb[0]; // '2026'
        $ta_pendaftaran = substr($tahun_ajaran_str, 2, 2); // '26'
        
        // Ambil konfigurasi biaya untuk unit MA TA 2026/2027 tingkat 1
        $biaya = Biaya::where('kode_unit', $kode_unit)
            ->where('kode_ta', $kode_ta)
            ->where('tingkat', 1)
            ->where('is_pindahan', 0)
            ->first();
            
        if (!$biaya) {
            $this->command->error("Konfigurasi biaya untuk MA TA 2026/2027 Tingkat 1 belum ditetapkan!");
            return;
        }

        // Ambil ID User untuk pencatat pendaftaran (default user pertama)
        $user = User::first();
        $id_user = $user ? $user->id : 1;

        $records = [
            ['nis' => '2627.10.018', 'nama_lengkap' => 'HANDZOLAH AKROM MUBAROK', 'jenis_kelamin' => 'L'],
            ['nis' => '2627.10.019', 'nama_lengkap' => 'HANIFA HASNA', 'jenis_kelamin' => 'P'],
            ['nis' => '2627.10.020', 'nama_lengkap' => 'ALYAA SYAHLA NAFISAH', 'jenis_kelamin' => 'P'],
        ];

        $count = 0;
        foreach ($records as $data) {
            // Cek apakah siswa dengan NIS ini sudah ada
            $existingPendaftaran = Pendaftaran::where('nis', $data['nis'])
                ->where('kode_ta', $kode_ta)
                ->first();

            if ($existingPendaftaran) {
                continue;
            }

            // Dapatkan ID Siswa berikutnya
            $last_siswa = Siswa::where('tahun_masuk', $tahun_masuk)
                ->orderBy('id_siswa', 'desc')
                ->first();
            $last_id_siswa = $last_siswa ? $last_siswa->id_siswa : "";
            $id_siswa = buatkode($last_id_siswa, $tahun_masuk, 3);

            // Dapatkan No Pendaftaran berikutnya
            $lastpendaftaran = Pendaftaran::where('kode_ta', $kode_ta)
                ->where('kode_unit', $kode_unit)
                ->orderBy('no_pendaftaran', 'desc')
                ->first();
            
            $last_no_pendaftaran = $lastpendaftaran ? $lastpendaftaran->no_pendaftaran : '';
            $format = "REG" . $kode_unit . $ta_pendaftaran;
            $no_pendaftaran = buatkode($last_no_pendaftaran, $format, 3);

            DB::transaction(function () use ($id_siswa, $no_pendaftaran, $data, $tahun_masuk, $kode_unit, $kode_ta, $biaya, $id_user) {
                // 1. Simpan data Siswa
                Siswa::create([
                    'id_siswa' => $id_siswa,
                    'nama_lengkap' => $data['nama_lengkap'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'tempat_lahir' => '',
                    'tanggal_lahir' => null,
                    'alamat' => '',
                    'tahun_masuk' => $tahun_masuk,
                ]);

                // 2. Simpan data Pendaftaran
                Pendaftaran::create([
                    'no_pendaftaran' => $no_pendaftaran,
                    'tanggal_pendaftaran' => date('Y-m-d'),
                    'nis' => $data['nis'],
                    'id_siswa' => $id_siswa,
                    'kode_unit' => $kode_unit,
                    'kode_ta' => $kode_ta,
                    'id_user' => $id_user,
                    'jenis_pendaftaran' => 'Baru',
                    'tingkat_masuk' => 1,
                ]);

                // 3. Simpan data Biayasiswa
                Biayasiswa::create([
                    'no_pendaftaran' => $no_pendaftaran,
                    'kode_biaya' => $biaya->kode_biaya,
                ]);
            });

            $count++;
        }

        $this->command->info("Berhasil membuat seeder untuk {$count} data tambahan pendaftaran MA 2026/2027.");
    }
}

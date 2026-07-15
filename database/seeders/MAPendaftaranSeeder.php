<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Pendaftaran;
use App\Models\Biayasiswa;
use App\Models\Biaya;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MAPendaftaranSeeder extends Seeder
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
            ['nis' => '2627.10.001', 'nama_lengkap' => 'ANNISA FITRI NURJANNAH', 'jenis_kelamin' => 'P'],
            ['nis' => '2627.10.002', 'nama_lengkap' => 'BARRAN RACHMAT MUZAKI', 'jenis_kelamin' => 'L'],
            ['nis' => '2627.10.003', 'nama_lengkap' => 'DAFFA FAATIH FAUZAN', 'jenis_kelamin' => 'L'],
            ['nis' => '2627.10.004', 'nama_lengkap' => 'DINDA NADIA NURAFIYAH', 'jenis_kelamin' => 'P'],
            ['nis' => '2627.10.005', 'nama_lengkap' => 'DZIKRI ANWARUL MATIN', 'jenis_kelamin' => 'L'],
            ['nis' => '2627.10.006', 'nama_lengkap' => 'ILMA DINA KHALISA', 'jenis_kelamin' => 'P'],
            ['nis' => '2627.10.007', 'nama_lengkap' => 'JANEETA DAHAYU', 'jenis_kelamin' => 'P'],
            ['nis' => '2627.10.008', 'nama_lengkap' => 'MAHIRA MUTI AZZAHRA', 'jenis_kelamin' => 'P'],
            ['nis' => '2627.10.009', 'nama_lengkap' => 'MUHAMMAD FAZA FADILLAH RIZKI', 'jenis_kelamin' => 'L'],
            ['nis' => '2627.10.010', 'nama_lengkap' => 'MUHAMMAD LUTHFI DHIAULHAQ', 'jenis_kelamin' => 'L'],
            ['nis' => '2627.10.011', 'nama_lengkap' => 'MUHAMMAD YUSUF FIRDAUS', 'jenis_kelamin' => 'L'],
            ['nis' => '2627.10.012', 'nama_lengkap' => 'NABIL AL GHIFFARI', 'jenis_kelamin' => 'L'],
            ['nis' => '2627.10.013', 'nama_lengkap' => 'NAILA ARFA SAKINA', 'jenis_kelamin' => 'P'],
            ['nis' => '2627.10.014', 'nama_lengkap' => 'NAURA HASNA RUSIDANA', 'jenis_kelamin' => 'P'],
            ['nis' => '2627.10.015', 'nama_lengkap' => 'RAHMANIA ZAHRA MARDIYA', 'jenis_kelamin' => 'P'],
            ['nis' => '2627.10.016', 'nama_lengkap' => 'SARAH AZZAHRA WAANI', 'jenis_kelamin' => 'P'],
            ['nis' => '2627.10.017', 'nama_lengkap' => 'SITI SALSA SABILA HASNA', 'jenis_kelamin' => 'P'],
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
                    'nis' => $data['nis'], // Menggunakan NIS dari gambar
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

        $this->command->info("Berhasil membuat seeder untuk {$count} data pendaftaran MA 2026/2027.");
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Pendaftaran;
use App\Models\Biayasiswa;
use App\Models\Biaya;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MTsPendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kode_unit = 'U04'; // MTs
        $kode_ta = 'TA2627'; // Tahun Ajaran 2026/2027
        $tahun_ajaran_str = '2026/2027';
        $ta_ppdb = explode("/", $tahun_ajaran_str);
        $tahun_masuk = $ta_ppdb[0]; // '2026'
        
        $ta_nis = substr($tahun_ajaran_str, 2, 2) . substr($tahun_ajaran_str, 7, 2); // '2627'
        $ta_pendaftaran = substr($tahun_ajaran_str, 2, 2); // '26'
        
        // Ambil konfigurasi biaya untuk unit MTs TA 2026/2027 tingkat 1
        $biaya = Biaya::where('kode_unit', $kode_unit)
            ->where('kode_ta', $kode_ta)
            ->where('tingkat', 1)
            ->where('is_pindahan', 0)
            ->first();
            
        if (!$biaya) {
            $this->command->error("Konfigurasi biaya untuk MTs TA 2026/2027 Tingkat 1 belum ditetapkan!");
            return;
        }

        // Ambil ID User untuk pencatat pendaftaran (default user pertama)
        $user = User::first();
        $id_user = $user ? $user->id : 1;

        $records = [
            ['nama_lengkap' => 'Abdurrahman Atstsaany', 'jenis_kelamin' => 'L'],
            ['nama_lengkap' => 'Achmad Athallah Azfar K', 'jenis_kelamin' => 'L'],
            ['nama_lengkap' => 'Agni Khadija Akhiru Salima', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Akmal Lathif Khalifah', 'jenis_kelamin' => 'L'],
            ['nama_lengkap' => 'Alika Talita Sakhi', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Alkhalifi Dzikri Tauhid', 'jenis_kelamin' => 'L'],
            ['nama_lengkap' => 'Aretha Farha', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Arsyad Aufa Raffansyah', 'jenis_kelamin' => 'L'],
            ['nama_lengkap' => 'Attaya Awatif Azra Aunatillah', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Azzahra Rheva Ananda', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Fathan Alwi Athariez', 'jenis_kelamin' => 'L'],
            ['nama_lengkap' => 'Fauzan Ardiansah', 'jenis_kelamin' => 'L'],
            ['nama_lengkap' => 'Hansa Althofunnisa Hidayati', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Izza Samha Thafana', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Kaisya Bani Sophia', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Muhammad Ridzwan Fadillah', 'jenis_kelamin' => 'L'],
            ['nama_lengkap' => 'Mikyal Lathifah Sidqi', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Nada Nafisah Amatillah', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Novita Salsyabillah Abil', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Putra Danis Aprilio', 'jenis_kelamin' => 'L'],
            ['nama_lengkap' => 'Putri Kharisma Aprillia', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Qaireen Batrisya Balqis', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Qaireen Qaisyara Asyabil', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Rayna Fatharani Aisha Kirana', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Rubina Afrin Nurrahman', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Ryuga Shafiq Rahman', 'jenis_kelamin' => 'L'],
            ['nama_lengkap' => 'Shifa Naisa Putri', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Ulfa Khairunnisa', 'jenis_kelamin' => 'P'],
            ['nama_lengkap' => 'Yasser Nazwan', 'jenis_kelamin' => 'L'],
        ];

        $count = 0;
        foreach ($records as $data) {
            // Cek apakah siswa dengan nama ini sudah ada di tahun masuk ini
            $existingSiswa = Siswa::where('nama_lengkap', $data['nama_lengkap'])
                ->where('tahun_masuk', $tahun_masuk)
                ->first();

            if ($existingSiswa) {
                continue;
            }

            // Dapatkan ID Siswa berikutnya
            $last_siswa = Siswa::where('tahun_masuk', $tahun_masuk)
                ->orderBy('id_siswa', 'desc')
                ->first();
            $last_id_siswa = $last_siswa ? $last_siswa->id_siswa : "";
            $id_siswa = buatkode($last_id_siswa, $tahun_masuk, 3);

            // Dapatkan No Pendaftaran & NIS berikutnya
            $lastpendaftaran = Pendaftaran::where('kode_ta', $kode_ta)
                ->where('kode_unit', $kode_unit)
                ->orderBy('no_pendaftaran', 'desc')
                ->first();
            
            $last_no_pendaftaran = $lastpendaftaran ? $lastpendaftaran->no_pendaftaran : '';
            $last_nis = $lastpendaftaran ? $lastpendaftaran->nis : '';
            
            $format = "REG" . $kode_unit . $ta_pendaftaran;
            $format_nis = $ta_nis;
            
            $no_pendaftaran = buatkode($last_no_pendaftaran, $format, 3);
            $nis = buatkode($last_nis, $format_nis, 3);

            DB::transaction(function () use ($id_siswa, $no_pendaftaran, $nis, $data, $tahun_masuk, $kode_unit, $kode_ta, $biaya, $id_user) {
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
                    'nis' => $nis,
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

        $this->command->info("Berhasil membuat seeder untuk {$count} data pendaftaran MTs 2026/2027.");
    }
}

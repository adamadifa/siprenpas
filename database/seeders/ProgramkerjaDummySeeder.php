<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Programkerja;
use App\Models\ProgramkerjaGroup;
use App\Models\Tahunajaran;
use App\Models\User;

class ProgramkerjaDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ta_aktif = Tahunajaran::where('status', 1)->first();
        if (!$ta_aktif) {
            $ta_aktif = Tahunajaran::first();
        }

        $superadmin = User::role('super admin')->first();
        $userId = $superadmin ? $superadmin->id : 1;

        $kode_dept = 'SKR';
        $kode_jabatan = 'J22';
        $kode_unit = 'U06'; // Pesantren

        $ta = explode("/", $ta_aktif->tahun_ajaran);
        $format = substr($ta[0], 2, 2) . substr($ta[1], 2, 2) . $kode_dept;

        $groupId = substr($ta_aktif->kode_ta . $kode_jabatan . $kode_dept . $kode_unit, 0, 15);

        // Ensure group exists
        ProgramkerjaGroup::updateOrCreate(
            ['kode_program_kerja_group' => $groupId],
            [
                'kode_unit' => $kode_unit,
                'kode_dept' => $kode_dept,
                'kode_jabatan' => $kode_jabatan,
                'kode_ta' => $ta_aktif->kode_ta,
                'id_user' => $userId
            ]
        );

        // Clean existing IT J22 program kerja in SKR and Pesantren under this group
        Programkerja::where('kode_program_kerja_group', $groupId)->delete();

        $items = [
            [
                'program' => 'Implementasi Portal Sistem Informasi Pesantren (Sipren) Terintegrasi',
                'target' => 'Semua modul akademik, kepegawaian, dan keuangan online 100%.',
                'ket' => 'Fokus pada penyelarasan data induk santri dan guru.'
            ],
            [
                'program' => 'Penyediaan Infrastruktur Jaringan Fiber Optic Area Pesantren',
                'target' => 'Seluruh area asrama, kelas, dan kantor sekretariat terhubung internet stabil.',
                'ket' => 'Kerja sama dengan provider lokal untuk bandwidth dedicated.'
            ],
            [
                'program' => 'Migrasi dan Integrasi Database Siswa ke Cloud Server',
                'target' => 'Keamanan data 100% cadangan otomatis harian.',
                'ket' => 'Pemindahan data dari server fisik lama untuk efisiensi biaya perawatan.'
            ],
            [
                'program' => 'Pelatihan Pemanfaatan LMS (Learning Management System) bagi Asatidz',
                'target' => 'Seluruh guru asatidz mampu menggunakan LMS untuk pembelajaran.',
                'ket' => 'Workshop 3 hari bersertifikat internal pesantren.'
            ],
            [
                'program' => 'Pembuatan Aplikasi Mobile Kehadiran Santri Berbasis RFID/QR',
                'target' => 'Presensi santri tercatat digital waktu-nyata.',
                'ket' => 'Integrasi ke WA Gateway untuk notifikasi otomatis ke wali santri.'
            ],
            [
                'program' => 'Pengembangan Website Profil Baru Pesantren Al-Amin',
                'target' => 'Tampilan website modern, responsif, dan SEO-friendly.',
                'ket' => 'Menyediakan halaman berita, galeri, dan profil unit pendidikan.'
            ],
            [
                'program' => 'Audit Keamanan Sistem Informasi dan Penetrasi Server',
                'target' => 'Identifikasi celah keamanan dan pembaruan patch server.',
                'ket' => 'Menggunakan jasa konsultan cybersecurity independen.'
            ],
            [
                'program' => 'Penyusunan Standard Operating Procedure (SOP) Manajemen Aset IT',
                'target' => 'SOP resmi pengelolaan dan pemeliharaan inventaris IT.',
                'ket' => 'Mencakup prosedur peminjaman laptop, perbaikan PC, dan instalasi software.'
            ],
            [
                'program' => 'Penerapan Sistem Pembayaran Biaya Pendidikan (PPDB) Cashless',
                'target' => 'Integrasi payment gateway untuk memudahkan wali santri.',
                'ket' => 'Dukungan transfer bank virtual account dan e-wallet.'
            ],
            [
                'program' => 'Instalasi CCTV dan Monitoring Sentral di Lingkungan Pondok',
                'target' => 'Pengawasan 24 jam di titik rawan untuk keamanan pesantren.',
                'ket' => 'Pemasangan 16 titik kamera IP resolusi tinggi terhubung ruang monitor sekretariat.'
            ],
        ];

        foreach ($items as $item) {
            $lastprogramkerja = Programkerja::where('kode_program_kerja_group', $groupId)
                ->orderBy('kode_program_kerja', 'desc')
                ->first();

            $last_kode_program_kerja = $lastprogramkerja !== null ? $lastprogramkerja->kode_program_kerja : '';
            $kode_program_kerja = buatkode($last_kode_program_kerja, $format, 4);

            Programkerja::create([
                'kode_program_kerja' => $kode_program_kerja,
                'kode_program_kerja_group' => $groupId,
                'program_kerja' => $item['program'],
                'target_pencapaian' => $item['target'],
                'keterangan' => $item['ket']
            ]);
        }
    }
}

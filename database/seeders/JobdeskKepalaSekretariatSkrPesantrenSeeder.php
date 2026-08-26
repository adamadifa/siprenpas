<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Jobdesk;
use App\Models\JobdeskGroup;

class JobdeskKepalaSekretariatSkrPesantrenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kode_jabatan = 'J05'; // Kepala Sekretariat
        $kode_dept = 'SKR';    // Sekretariat (SKR)
        $kode_unit = 'U06';    // Pesantren
        $groupId = 'J05SKRU06';

        // Clean existing data for this group first
        DB::table('jobdesk')->where('kode_jobdesk_group', $groupId)->delete();

        // Ensure group exists
        $group = JobdeskGroup::find($groupId);
        if (!$group) {
            $group = JobdeskGroup::create([
                'kode_jobdesk_group' => $groupId,
                'kode_unit' => $kode_unit,
                'kode_dept' => $kode_dept,
                'kode_jabatan' => $kode_jabatan
            ]);
        }

        $tasks = [
            'Mengelola dan mengkoordinasikan staff kesekretarian.',
            'Menyusun dan mengirimkan surat, email dan laporan.',
            'Melakukan pengorganisasian administrasi umum.',
            'Membantu sekretaris dalam memfasilitasi rapat rapat.',
            'Bertanggung jawab dalam pendokumentasian hasil rapat.',
            'Bertanggung jawab atas pengarsipan surat surat berharga pesantren.',
            'Melaksanakan tata usaha Pesantren terkait surat menyurat dll.',
            'Menyusun, mengelola, menyajikan data pesantren serta mengelola informasi ke luar dan ke dalam.',
            'Bersama staf SDM memfasilitasi pelaksanaan agenda kegiatan peningkatan kualitas SDM dilingkungan Pesantren.',
            'Menyusun seluruh database pegawai di lingkungan Pesantren.',
            'Menyusun kalender kegiatan Pesantren.',
            'Menghadiri setiap rapat pengurus.',
            'Pembinaan dan pengendalian administrasi keuangan dan kepegawaian.',
            'Mengurus perizinan registrasi Pesantren serta mengkoordinasikan kegiatan dan acara.',
            'Menyusun bahan laporan pelaksanaan kegiatan sekretariat dan Pesantren secara berkala.',
            'Bertanggung jawab kepada pimpinan pesantren.',
            'Melaksanakan tugas lain yang diberikan pimpinan pesantren atau sekretaris Pesantren selama tidak bertentangan dengan syariat islam dan tujuan Pesantren.'
        ];

        foreach ($tasks as $taskText) {
            // Generate sequential code matching prefix
            $lastjobdesk = Jobdesk::orderBy('kode_jobdesk', 'desc')
                ->where('kode_jobdesk', 'like', $kode_jabatan . $kode_dept . '%')
                ->first();
            $last_kode_jobdesk = $lastjobdesk != null ? $lastjobdesk->kode_jobdesk : '';
            $kode_jobdesk = buatkode($last_kode_jobdesk, $kode_jabatan . $kode_dept, 4);

            Jobdesk::create([
                'kode_jobdesk' => $kode_jobdesk,
                'jobdesk' => $taskText,
                'kode_jobdesk_group' => $groupId
            ]);
        }
    }
}

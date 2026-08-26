<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Jobdesk;
use App\Models\JobdeskGroup;

class JobdeskSekretarisBphPesantrenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kode_jabatan = 'J02'; // Sekretaris
        $kode_dept = 'BPH';    // BPH
        $kode_unit = 'U06';    // Pesantren
        $groupId = 'J02BPHU06';

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
            'Bertanggung jawab atas terselenggaranya kegiatan operasional pesantren.',
            'Mengatur dan mentertibkan pengorganisasian administrasi pesantren.',
            'Mengatur, mengelola, memelihara dan menginventarisasi aset pesantren.',
            'Mengkoordinasikan kegiatan atau program pesantren.',
            'Mengatur jadwal pertemuan dan rapat.',
            'Mengelola, memelihara dokumen dan pengarsipan dokumen pesantren.',
            'Mewakili pimpinan pesantren jika berhalangan.',
            'Bertanggung jawab kepada pimpinan pesantren.',
            'Melaksanakan tugas lain yang diberikan pimpinan pesantren selama tidak bertentangan dengan syariat islam dan tujuan Pesantren.'
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

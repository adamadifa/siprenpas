<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Jobdesk;
use App\Models\JobdeskGroup;

class JobdeskDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean existing IT J22 dummy data in SKR first
        DB::table('jobdesk')
            ->join('jobdesk_group', 'jobdesk.kode_jobdesk_group', '=', 'jobdesk_group.kode_jobdesk_group')
            ->where('jobdesk_group.kode_dept', 'SKR')
            ->where('jobdesk_group.kode_jabatan', 'J22')
            ->delete();

        $tasks = [
            ['unit' => 'U06', 'jobdesk' => 'Memelihara jaringan internet dan server lokal Pesantren.'],
            ['unit' => 'U06', 'jobdesk' => 'Melakukan troubleshooting perangkat keras di lingkungan Pesantren.'],
            ['unit' => 'U06', 'jobdesk' => 'Mengelola backup database sistem informasi Pesantren.'],
            ['unit' => 'U06', 'jobdesk' => 'Membantu guru dan staf dalam penggunaan aplikasi pembelajaran digital Pesantren.'],
            ['unit' => 'U06', 'jobdesk' => 'Mengembangkan dan memperbarui fitur website profil Pesantren.']
        ];

        foreach ($tasks as $t) {
            $kode_jabatan = 'J22';
            $kode_dept = 'SKR';
            $kode_unit = $t['unit'];
            $groupId = substr($kode_jabatan . $kode_dept . $kode_unit, 0, 10);

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

            // Generate sequential code matching prefix
            $lastjobdesk = Jobdesk::orderBy('kode_jobdesk', 'desc')
                ->where('kode_jobdesk', 'like', $kode_jabatan . $kode_dept . '%')
                ->first();
            $last_kode_jobdesk = $lastjobdesk != null ? $lastjobdesk->kode_jobdesk : '';
            $kode_jobdesk = buatkode($last_kode_jobdesk, $kode_jabatan . $kode_dept, 4);

            Jobdesk::create([
                'kode_jobdesk' => $kode_jobdesk,
                'jobdesk' => $t['jobdesk'],
                'kode_jobdesk_group' => $groupId
            ]);
        }
    }
}

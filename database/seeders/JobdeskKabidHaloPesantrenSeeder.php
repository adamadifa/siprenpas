<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Jobdesk;
use App\Models\JobdeskGroup;

class JobdeskKabidHaloPesantrenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kode_jabatan = 'J27'; // Kepala Bidang
        $kode_dept = 'HLO';    // HALO (HLO)
        $kode_unit = 'U06';    // Pesantren
        $groupId = 'J27HLOU06';

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
            // Bagian Hubungan Antar Lembaga / Humas
            'Mendampingi dan membantu pimpinan pesantren dalam melaksanakan tugas pesantren terkait hubungan antar Lembaga.',
            'Bertanggungjawab dalam mengkoordinir program program pesantren yang terkait dengan hubungan komunikasi yang baik di internal maupun eksternal.',
            'Membangun jaringan Kerjasama antar Lembaga baik pemerintah maupun non pemerintah.',
            'Melakukan sosialisasi program pesantren baik di dalam maupun di luar pesantren.',
            'Membuat presentasi dan materi promosi.',
            'Mengidentifikasi peluang Kerjasama.',
            'Mengembangkan proposal Kerjasama.',
            'Memantau kemajuan dan evaluasi Kerjasama.',
            'Menganalisis kebutuhan dan pengembangan strategi.',
            'Membuat pedoman, regulasi dan SOP HALO dan Bidang SOSIAL.',

            // Bagian Sosial & Penggalangan Dana
            'Merencanakan program penggalangan dana berekesinambungan untuk menopang kebutuhan Pesantren.',
            'Menyusun dan mengkoordinir program pesantren terkait pendanaan dan pemberdayaan sosial.',
            'Meningkatkan pemberdayaan "Peduli Al Amin" {beasiswa, Santunan anak yatim, pengabdian Masyarakat, wali asuh}.',
            'Mengkoordinasikan kegiatan kekeluargaan baik tahniyah maupun takjiyah.',
            'Mengelola anggaran dan sumber daya.',
            'Membuat laporan kegiatan dan laporan keuangan bidang sosial.',
            'Melaksanakan evaluasi dan rencana tindak lanjut.'
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

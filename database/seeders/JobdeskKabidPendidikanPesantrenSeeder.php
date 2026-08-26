<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Jobdesk;
use App\Models\JobdeskGroup;

class JobdeskKabidPendidikanPesantrenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kode_jabatan = 'J06'; // Kepala Bidang
        $kode_dept = 'PDD';    // Pendidikan
        $kode_unit = 'U06';    // Pesantren
        $groupId = 'J06PDDU06';

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
            'Menyusun Rencana Kerja & Anggaran (RKA) jangka menengah & tahunan: Menerima rencana strategis dan kebijakan dari Pesantren.',
            'Menyusun Rencana Kerja & Anggaran (RKA) jangka menengah & tahunan: Menjabarkan rencana strategis kedalam RKA jangka menengah & tahunan.',
            'Menyusun Rencana Kerja & Anggaran (RKA) jangka menengah & tahunan: Menyampaikan RKA yang akan dicapai kepada Tim dibawah wewenangnya, baik yang bersifat jangka pendek, menengah maupun jangka panjang.',
            'Menyusun Rencana Kerja & Anggaran (RKA) jangka menengah & tahunan: Mengkoordinir penyusunan anggaran bagian-bagian di bawah Manajemen Bidang Pendidikan.',
            'Menyusun Rencana Kerja & Anggaran (RKA) jangka menengah & tahunan: Menyusun kebijakan Divisi Pendidikan untuk menunjang pencapaian sasaran dan mensosialisasikannya kepada seluruh Tim Manajemen Bidang Pendidikan.',
            'Pengembangan Kebijakan Pendidikan: Bidang Pendidikan bertanggung jawab untuk mengembangkan kebijakan Pendidikan seperti kurikulum, peraturan-peraturan dan lain-lain yang sesuai dengan visi, misi, dan nilai-nilai pesantren, memahami tren dan perubahan dalam dunia pendidikan, serta memastikan bahwa program pendidikan yang ditawarkan Pesantren sesuai dengan standar yang ditetapkan.',
            'Pengawasan dan Koordinasi pelaksanaan program-program di bawah tiap Divisi untuk mengimplementasikan rencana kerja tahunan: Bidang Pendidikan bertanggung jawab atas pengawasan dan koordinasi semua program pendidikan yang diselenggarakan oleh sekolah. Memastikan bahwa program-program tersebut dirancang dengan baik, sesuai dengan kurikulum yang ditetapkan, dan mencakup metode pengajaran yang efektif. Melakukan penataan struktur kurikulum pesantren dan kurikulum kemenag/diknas dengan koordinasi ke masing masing unit, melakukan pengawasan, monitoring dan evaluasi program ppdb di semua unit, Melakukan evaluasi pemenuhan standar Pendidikan nasional, mendukung program akreditasi dan kegiatan sejenisnya di setiap unit.',
            'Pengelolaan Sumber Daya dan Manajemen Pegawai Pendidikan: Bidang Pendidikan memimpin dan mengelola semua pegawai pendidikan, kepala sekolah, guru, dan staf pendukung lainnya. Koordinasi dengan bidang MSDM untuk melakukan rekrutmen, pengembangan, dan evaluasi kinerja pegawai pendidikan, serta menyelenggarakan kegiatan pelatihan dan pengembangan profesional untuk meningkatkan kualitas pengajaran dan manajemen. Pengelolaan sumber daya pendidikan, termasuk anggaran, fasilitas, dan peralatan. Memastikan penggunaan yang efisien dan efektif dari sumber daya yang ada, serta mengawasi pemeliharaan dan peningkatan fasilitas Pendidikan.',
            'Membangun koordinasi dengan Pengurus Pesantren untuk menunjang pencapaian sasaran kerja: Mengadakan rapat koordinasi dengan Pengurus Yayasan untuk mendapatkan dukungan dalam proses implementasi program.',
            'Membangun koordinasi dengan Pengurus Pesantren untuk menunjang pencapaian sasaran kerja: Memberikan usulan-usulan pengembangan prosedur kerja yang terkait dalam rapat koordinasi pesantren.',
            'Monitoring dan evaluasi pencapaian program Divisi Pendidikan: Menerima laporan kegiatan bulanan dan kwartalan dari para kepala sekolah.',
            'Monitoring dan evaluasi pencapaian program Divisi Pendidikan: Menganalisa laporan kegiatan yang diterima dan membahasnya dalam rapat rutin pekanan, memberikan masukan, dan memecahkan masalah yang muncul.',
            'Monitoring dan evaluasi pencapaian program Divisi Pendidikan: Menerima dan mengevaluasi laporan pencapaian program setiap 1 bulan sekali.',
            'Monitoring dan evaluasi pencapaian program Divisi Pendidikan: Memberikan arahan kepada Kepala Sekolah untuk melaporkan hasil belajar kepada orang tua peserta didik dan atasannya.'
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

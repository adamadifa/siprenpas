<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Jobdesk;
use App\Models\JobdeskGroup;

class JobdeskKabidMsdmPesantrenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kode_jabatan = 'J06'; // Kepala Bidang
        $kode_dept = 'SDM';    // MSDM
        $kode_unit = 'U06';    // Pesantren
        $groupId = 'J06SDMU06';

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
            'Menyusun Rencana Kerja & Anggaran (RKA) HRD jangka pendek, menengah & tahunan: Menerima rencana strategis dan kebijakan dari Pengurus Pesantren.',
            'Menyusun Rencana Kerja & Anggaran (RKA) HRD jangka pendek, menengah & tahunan: Menjabarkan rencana strategis Bidang MSDM kedalam Rencana Kerja dan Anggaran (RKA)/Program Kerja Bidang MSDM jangka pendek, menengah & tahunan.',
            'Menyusun Rencana Kerja & Anggaran (RKA) HRD jangka pendek, menengah & tahunan: Menyampaikan RKA yang akan dicapai Bidang MSDM kepada Pimpinan pesantren, baik yang bersifat jangka pendek, menengah maupun jangka panjang.',
            "Menyusun Rencana Kerja & Anggaran (RKA) HRD jangka pendek, menengah & tahunan: Menyusun kebijakan/SOP terkait kepegawaian di pesantren maupun Sekolah dan Asrama untuk menunjang pencapaian sasaran dan mensosialisasikannya kepada seluruh Tim Pesantren, Sekolah dan Asrama.\ni. Memiliki SOP yang mengatur berbagai aspek pengelolaan secara tertulis (seperti: Struktur organisasi, proses seleksi pegawai, pembagian tugas guru dan tenaga kependidikan, peraturan kepegawaian, tatib sekolah, kode etik pegawai, dll) yang mudah dibaca oleh pihak-pihak yang terkait.\nii. Menetapkan kebijakan program secara tertulis mengenai pengelolaan SDM.\niii. Menyusun mekanisme penilaian kinerja pegawai yang berkeadilan, bertanggung jawab, dan berkesinambungan.\niv. Menyusun kebijakan lainnya sesuai kebutuhan.",
            'Menyusun Rencana Kerja & Anggaran (RKA) HRD jangka pendek, menengah & tahunan: Mempresentasikan RKA menengah & tahunan dalam rapat dengan Pengurus Pesantren.',
            'Menyusun Rencana Kerja & Anggaran (RKA) HRD jangka pendek, menengah & tahunan: Menerima pengesahan RKA Bidang MSDM dari Pengurus Pesantren.',
            'Menyusun Rencana Kerja & Anggaran (RKA) HRD jangka pendek, menengah & tahunan: Melakukan sosialisasi rencana strategis Bidang MSDM yang telah disahkan oleh Pengurus Pesantren kepada seluruh Pegawai.',
            
            'Rekrutmen SDM (Recruitment): Menyusun SOP terkait rekrutmen pegawai baru yang mekanisme dan prosedurnya menyesuaikan dengan peraturan kepegawaian Pesantren.',
            'Rekrutmen SDM (Recruitment): Membuat Term of References (ToR) pelaksanaan program terkait rekrutmen SDM yang telah di sesuaikan dengan kebutuhan (Training need analysis (TNA)) lengkap dengan anggaran biaya dan kemudian mendapatkan persetujuan dari Pengurus Pesantren.',
            'Rekrutmen SDM (Recruitment): Membentuk panitia khusus dalam membantu pelaksanaan rekrutmen SDM.',
            'Rekrutmen SDM (Recruitment): Bersama dengan panitia khusus yang telah ditunjuk, menyusun alat tes yang akan digunakan dalam pelaksanaan tes pegawai baru.',
            'Rekrutmen SDM (Recruitment): Bertanggung jawab terhadap pelaksanaan rekrutmen SDM mulai dari seleksi administrasi, tes tertulis, tes interview, tes praktik sampai dengan pengajuan rekomendasi pegawai yang lulus kepada Pengurus Pesantren.',
            'Rekrutmen SDM (Recruitment): Menyebarluaskan iklan terkait penerimaan pegawai baru baik melalui media sosial atau media promosi lainnya.',
            'Rekrutmen SDM (Recruitment): Dalam proses mencari calon pegawai untuk mengisi kebutuhan SDM di Pesantren, Sekolah dan Asrama, Kabid MSDM harus melakukan analisis jabatan dan menjelaskan deskripsi pekerjaan juga spesifikasi pekerjaan tersebut.',
            'Rekrutmen SDM (Recruitment): Menyusun laporan pertanggung jawaban kegiatan dan pencapaian program.',
            
            'Menyusun program Orientasi/pelatihan dan pendidikan pegawai baru: Menyusun SOP terkait pelatihan dan pendidikan pegawai baru yang mekanisme dan prosedurnya menyesuaikan dengan peraturan kepegawaian Pesantren.',
            'Menyusun program Orientasi/pelatihan dan pendidikan pegawai baru: Membuat Term of References (ToR) pelaksanaan program terkait pelatihan & pendidikan pegawai baru yang telah di sesuaikan dengan kebutuhan jabatan yang diterima lengkap dengan anggaran biaya dan kemudian mendapatkan persetujuan dari Pengurus Pesantren.'
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

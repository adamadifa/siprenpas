<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Jobdesk;
use App\Models\JobdeskGroup;

class JobdeskStaffMsdmPesantrenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kode_jabatan = 'J21'; // Staff
        $kode_dept = 'SDM';    // MSDM
        $kode_unit = 'U06';    // Pesantren
        $groupId = 'J21SDMU06';

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
            'Melaksanakan Rekrutmen dan Seleksi: Menangani proses rekrutmen dan seleksi karyawan baru, termasuk penulisan dan pemasangan iklan lowongan, penyeleksian berkas, wawancara, dan pengecekan referensi. Membantu dalam membuat keputusan penerimaan karyawan baru.',
            'Menyelenggarakan Onboarding dan Orientasi: Setelah calon karyawan terpilih, Staff MSDM membantu dalam proses onboarding, yaitu memperkenalkan mereka pada budaya, kebijakan, dan prosedur yayasan. Memberikan informasi yang diperlukan, memastikan pengisian dokumen administrasi, serta menyelenggarakan orientasi agar karyawan baru dapat dengan cepat beradaptasi.',
            'Merancang Pengembangan karyawan: Merencanakan dan melaksanakan program pengembangan karyawan, seperti pelatihan, workshop, atau seminar yang relevan dengan kebutuhan yayasan pendidikan. Membantu dalam membuat rencana pengembangan karir bagi karyawan yang berprestasi.',
            'Melaksanakan Manajemen Kinerja: Sebagai Staff MSDM, terlibat dalam pengelolaan kinerja karyawan. Membantu merancang dan melaksanakan program penilaian kinerja, memberikan umpan balik kepada karyawan, dan mendukung pengembangan karir mereka dengan memberikan pelatihan dan pengembangan.',
            'Penggajian dan Manajemen Kepegawaian: Bertanggung jawab untuk mengelola sistem penggajian karyawan dan berkoordinasi dengan bagian finance, termasuk menghitung gaji, mengurus administrasi terkait pajak dan tunjangan, serta memastikan kepatuhan terhadap peraturan ketenagakerjaan. Mengelola data kepegawaian, seperti absensi, cuti, dan rekam jejak karyawan.',
            'Administrasi SDM: Bertanggung jawab untuk administrasi kepegawaian dan dokumen-dokumen terkait, seperti kontrak kerja, perjanjian kerja, perubahan data karyawan, dan pencatatan absensi. Memastikan kepatuhan dengan hukum ketenagakerjaan dan peraturan yang berlaku.',
            'Pengelolaan Kebijakan dan Prosedur: Membantu dalam pengembangan dan penerapan kebijakan dan prosedur yayasan terkait sumber daya manusia. Memastikan kepatuhan terhadap peraturan ketenagakerjaan, menjawab pertanyaan dan memberikan bantuan kepada karyawan terkait kebijakan dan prosedur tersebut.',
            'Mengkoordinasikan Hubungan Karyawan: Berperan dalam membangun dan menjaga hubungan yang baik antara karyawan dan manajemen. Menjadi perantara dalam menyelesaikan masalah, mengelola konflik, serta mengadakan kegiatan atau acara yang meningkatkan semangat kerjasama dan kebersamaan di antara karyawan.',
            'Kesejahteraan karyawan: Memastikan kesejahteraan karyawan dengan mengurus kebutuhan dan fasilitas karyawan, termasuk tunjangan, asuransi kesehatan, program kesejahteraan, dan manajemen stres.',
            'Penyelesaian konflik: Menangani konflik atau masalah antara karyawan atau departemen yang mungkin timbul, dan mencari solusi yang sesuai dengan kebijakan dan hukum.',
            'Kepatuhan dan Pelaporan: Sebagai Staff MSDM, memastikan kepatuhan yayasan pendidikan terhadap peraturan ketenagakerjaan dan hukum yang berlaku. Menyusun laporan yang diperlukan, seperti laporan kepegawaian, laporan absensi, dan laporan lainnya sesuai dengan kebutuhan internal dan eksternal.',
            'Pemenuhan hukum ketenagakerjaan: Memastikan kepatuhan dengan hukum ketenagakerjaan yang berlaku, termasuk regulasi terkait upah, jam kerja, cuti, dan perizinan.'
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

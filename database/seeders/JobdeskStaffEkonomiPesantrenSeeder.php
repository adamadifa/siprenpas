<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Jobdesk;
use App\Models\JobdeskGroup;

class JobdeskStaffEkonomiPesantrenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kode_jabatan = 'J26'; // Staff
        $kode_dept = 'EKM';    // EKONOMI
        $kode_unit = 'U06';    // Pesantren
        $groupId = 'J26EKMU06';

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
            // Jobdesk
            'Mengelola Manajemen Keuangan: Bertanggung jawab untuk mengelola semua aspek keuangan pendapatan dan pengeluaran dengan administrasi yang lengkap. Bersama Kepala bidang ekonomi membuat rencana pendapatan dan pengeluaran Bidang ekonomi.',
            'Menyusun Laporan Keuangan: Menyusun laporan keuangan yang akurat dan lengkap untuk menunjukkan kondisi keuangan bidang ekonomi baik bulanan, semesteran dan tahunan kepada kepala bidang ekonomi dan kepada pihak eksternal yang menjalin kerjasama dengan bidang ekonomi.',
            'Pengembangan Bidang Ekonomi: Bersama kepala bidang ekonomi membuat rencana pengembangan jangka pendek, jangka menengah dan jangka panjang.',
            'Mengelola usaha: Mengelola usaha yang dimiliki Pesantren seperti kebun, catering, penyewaan tempat dan sumber pendapatan lainnya seperti penagihan tunggakan aktif dan alumni.',
            'Membuat Pedoman Bidang Ekonomi: Bersama Kabid Ekonomi menyusun pedoman bidang ekonomi.',
            'Kerjasama dengan Pihak Luar: Membangun Kerjasama dengan pihak luar seperti dengan pemerintah atau perusahaan dll.',
            'Koordinasi dengan Pihak Terkait: Melaksanakan koordinasi dengan pihak pihak terkait.',
            'Analisis dan evaluasi: Bersama Kabid Ekonomi melakukan evaluasi program bulanan, semesteran dan tahunan serta tindak lanjutnya.',
            'Melaksanakan arahan/intruksi atasan: diluar poin diatas selama tidak bertentangan dengan syariat dan untuk kepentingan Pesantren/Sekolah.',

            // Wewenang
            'Wewenang: Mengembangkan program ekonomi.',
            'Wewenang: Mengelola aset usaha pesantren atau sumber pendapatan pesantren.',
            'Wewenang: Koordinasi dg kepala bidang ekonomi dalam mengambil keputusan.',
            'Wewenang: Membangun kerjasama dengan pihak internal dan eksternal.',
            'Wewenang: Bersama kabid Ekonomi Mengawasi dan mengontrol unit usaha pesantren atau sumber pendapatan lainnya di pesantren.',
            'Wewenang: Membuat laporan pengelolaan bidang ekonomi.'
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

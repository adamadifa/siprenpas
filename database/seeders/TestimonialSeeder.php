<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'nama' => 'Ahmad Rizki',
                'testimoni' => 'Sekolah Al-Amin telah memberikan pendidikan yang berkualitas tinggi kepada anak-anak kami. Guru-guru yang profesional dan lingkungan belajar yang kondusif membuat anak-anak merasa nyaman dan termotivasi untuk belajar.',
                'status' => 1
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'testimoni' => 'Sebagai wali murid, saya sangat puas dengan perkembangan akademik dan karakter anak saya di sekolah Al-Amin. Program-program yang diselenggarakan sangat bermanfaat untuk masa depan anak-anak.',
                'status' => 1
            ],
            [
                'nama' => 'Dr. Muhammad Fadli',
                'testimoni' => 'Saya mengamati bahwa lulusan SD Al-Amin memiliki fondasi akademik yang kuat dan karakter yang baik. Ini menunjukkan bahwa sekolah ini berhasil dalam mendidik siswa secara holistik.',
                'status' => 1
            ],
            [
                'nama' => 'Nurul Hidayati',
                'testimoni' => 'Siswa-siswa dari SD Al-Amin yang melanjutkan ke sekolah kami menunjukkan kemampuan akademik yang baik dan sikap yang positif. Ini membuktikan kualitas pendidikan di Al-Amin.',
                'status' => 1
            ],
            [
                'nama' => 'Budi Santoso',
                'testimoni' => 'Saya mendukung penuh program-program yang diselenggarakan oleh SD Al-Amin. Pendidikan karakter dan akademik yang seimbang sangat penting untuk membentuk generasi masa depan yang berkualitas.',
                'status' => 1
            ]
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::firstOrCreate(['nama' => $testimonial['nama']], $testimonial);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\ProgramUnggulan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramUnggulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'nama_program' => 'Pembentukan Karakter',
                'deskripsi' => 'Program ini fokus pada pembentukan akhlak mulia, kedisiplinan, tanggung jawab, dan etika peserta didik melalui kegiatan rutin, mentoring, dan keteladanan.',
                'urutan' => 1,
            ],
            [
                'nama_program' => 'Tahsin & Tahfizh Al Quran',
                'deskripsi' => 'Meningkatkan kemampuan membaca Al-Quran dengan tajwid yang benar (tahsin) dan membina peserta didik agar mampu menghafal Al-Quran secara terstruktur dan konsisten (tahfizh).',
                'urutan' => 2,
            ],
            [
                'nama_program' => 'Bahasa Asing',
                'deskripsi' => 'Membekali peserta didik dengan kemampuan dasar dalam berbahasa Arab dan Inggris secara aktif, baik lisan maupun tulisan, melalui pembelajaran kontekstual dan praktik langsung.',
                'urutan' => 3,
            ],
            [
                'nama_program' => 'Science',
                'deskripsi' => 'Menumbuhkan rasa ingin tahu dan keterampilan sains melalui eksperimen, observasi, dan pembelajaran berbasis proyek yang mendorong peserta didik berpikir kritis dan kreatif.',
                'urutan' => 4,
            ],
        ];

        foreach ($programs as $program) {
            ProgramUnggulan::firstOrCreate(['nama_program' => $program['nama_program']], $program);
        }
    }
}



<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('unit_landing_settings', function (Blueprint $table) {
            $table->string('kode_unit', 10)->primary();
            
            // Hero Section
            $table->string('hero_tag')->nullable(); // e.g. "Pondok Pesantren Al-Amin" / "Pendidikan Anak Usia Dini Berkarakter"
            $table->string('hero_title_prefix')->nullable(); // e.g. "Membentuk Karakter & Potensi"
            $table->string('hero_title_highlight')->nullable(); // e.g. "Anak Usia Dini Islami"
            $table->text('hero_description')->nullable();
            $table->string('hero_model_image')->nullable(); // Foto model siswa/siswi
            $table->string('hero_badge_text')->nullable(); // e.g. "Buka Pendaftaran"
            $table->string('hero_badge_subtext')->nullable(); // e.g. "Tahun Ajaran 2026/2027"
            $table->string('hero_badge_status')->nullable(); // e.g. "Kuota Terbatas"
            $table->string('hero_badge_icon')->nullable(); // e.g. "ti ti-sparkles"
            
            // Stats / Counter Badges
            $table->string('stat_1_val')->nullable(); // e.g. "A" / "100%"
            $table->string('stat_1_label')->nullable(); // e.g. "Akreditasi BAN-SM"
            $table->string('stat_2_val')->nullable(); // e.g. "1:10" / "15+"
            $table->string('stat_2_label')->nullable(); // e.g. "Rasio Guru & Siswa"
            $table->string('stat_3_val')->nullable(); // e.g. "30+" / "100%"
            $table->string('stat_3_label')->nullable(); // e.g. "Program & Kegiatan Seru"
            $table->string('stat_4_val')->nullable(); // e.g. "500+"
            $table->string('stat_4_label')->nullable(); // e.g. "Alumni Berprestasi"

            // Prakata Kepala Sekolah / Pimpinan
            $table->string('prakata_tag')->nullable(); // e.g. "Sambutan Kepala Sekolah"
            $table->string('prakata_title')->nullable(); // e.g. "Mendidik dengan Hati, Membina Generasi Islami"
            $table->string('prakata_quote')->nullable(); // Quote singkat
            $table->text('prakata_content')->nullable(); // Teks sambutan lengkap
            $table->string('prakata_custom_nama')->nullable(); // Override nama jika ada
            $table->string('prakata_custom_jabatan')->nullable(); // Override jabatan
            $table->string('prakata_custom_foto')->nullable(); // Foto custom jika tidak pakai foto karyawan

            // Program Unggulan & Fasilitas (Bisa simpan item custom JSON)
            $table->string('program_tag')->nullable();
            $table->string('program_title')->nullable();
            $table->text('program_description')->nullable();
            $table->json('custom_programs')->nullable(); // [{title, desc, icon, badge}]
            
            $table->string('fasilitas_tag')->nullable();
            $table->string('fasilitas_title')->nullable();
            $table->text('fasilitas_description')->nullable();
            $table->json('custom_fasilitas')->nullable(); // [{name, desc, image, icon}]

            // Testimoni Section
            $table->string('testimoni_tag')->nullable();
            $table->string('testimoni_title')->nullable();
            $table->text('testimoni_description')->nullable();
            $table->json('custom_testimoni')->nullable(); // [{name, role, quote, avatar, rating}]

            // CTA Banner Section
            $table->string('cta_tag')->nullable();
            $table->string('cta_title')->nullable();
            $table->text('cta_description')->nullable();
            $table->string('cta_button_text')->nullable();
            $table->string('cta_button_url')->nullable();
            $table->string('cta_wa_text')->nullable();
            $table->string('cta_model_image')->nullable();

            // Kontak & Medsos Khusus Unit
            $table->string('unit_phone')->nullable();
            $table->string('unit_whatsapp')->nullable();
            $table->string('unit_email')->nullable();
            $table->string('unit_instagram')->nullable();
            $table->string('unit_facebook')->nullable();
            $table->string('unit_youtube')->nullable();

            $table->timestamps();

            $table->foreign('kode_unit')->references('kode_unit')->on('unit')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_landing_settings');
    }
};

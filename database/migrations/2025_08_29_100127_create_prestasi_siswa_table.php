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
        Schema::create('prestasi_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('id_siswa', 7)->nullable(); // Bisa null jika nama diinput manual
            $table->string('nama_siswa'); // Nama siswa (bisa dari tabel siswa atau input manual)
            $table->text('prestasi');
            $table->enum('tingkat', ['kecamatan', 'kabupaten', 'nasional']);
            $table->string('foto')->nullable();
            $table->boolean('status')->default(1); // 1 = aktif, 0 = nonaktif
            $table->timestamps();

            // Foreign key ke tabel siswa
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi_siswa');
    }
};

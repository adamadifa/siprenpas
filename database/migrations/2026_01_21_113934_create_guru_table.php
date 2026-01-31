<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->string('npp', 20)->unique(); // Relasi ke tabel karyawan
            $table->string('kode_unit', 10); // Relasi ke tabel unit
            $table->string('kode_jabatan', 10)->nullable(); // Relasi ke tabel jabatan_akademik
            $table->string('nomor_kemenag_dinas', 30)->nullable(); // NIP/NUPTK/PEGID
            $table->string('file_ttd', 255)->nullable();
            $table->boolean('status_aktif_ajar')->default(1);
            $table->timestamps();

            // Foreign Keys (Optional - good for integrity but sometimes skipped in existing apps, adding simplified index first)
            $table->index('npp');
            $table->index('kode_unit');
            $table->index('kode_jabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};

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
        Schema::create('bobot_penilaian', function (Blueprint $table) {
            $table->id();
            $table->char('kode_kelas', 9)->index();
            $table->unsignedBigInteger('mata_pelajaran_id')->index();
            $table->unsignedBigInteger('guru_id')->nullable()->index();
            $table->char('kode_ta', 6)->index();
            $table->enum('semester', ['1', '2']);
            $table->integer('bobot_sumatif');
            $table->integer('bobot_sas');
            $table->timestamps();

            $table->foreign('kode_kelas')->references('kode_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('mata_pelajaran_id')->references('id')->on('mata_pelajaran')->onDelete('cascade');
            $table->foreign('guru_id')->references('id')->on('guru')->onDelete('set null');
            $table->foreign('kode_ta')->references('kode_ta')->on('konfigurasi_tahun_ajaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bobot_penilaian');
    }
};

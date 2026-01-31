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
        Schema::create('presensi_mapel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_pelajaran_id')->nullable()->index();
            $table->char('kode_unit', 3)->index();
            $table->char('kode_kelas', 9)->index();
            $table->unsignedBigInteger('mata_pelajaran_id')->index();
            $table->unsignedBigInteger('guru_id')->index();
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai')->nullable();
            $table->text('materi')->nullable();
            $table->string('status_pertemuan')->nullable()->comment('e.g. Terlaksana, Kosong');
            $table->timestamps();

            $table->foreign('jadwal_pelajaran_id')->references('id')->on('jadwal_pelajaran')->onDelete('set null');
            $table->foreign('kode_unit')->references('kode_unit')->on('unit')->onDelete('cascade');
            $table->foreign('kode_kelas')->references('kode_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('mata_pelajaran_id')->references('id')->on('mata_pelajaran')->onDelete('restrict');
            $table->foreign('guru_id')->references('id')->on('guru')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_mapel');
    }
};

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
        Schema::create('jadwal_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->char('kode_unit', 3)->index();
            $table->char('kode_ta', 6)->index();
            $table->char('kode_kelas', 9)->index();
            $table->unsignedBigInteger('mata_pelajaran_id')->index();
            $table->unsignedBigInteger('guru_id')->index();
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad']);
            $table->integer('jam_ke');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->char('semester', 1)->comment('1=Ganjil, 2=Genap');
            $table->timestamps();

            $table->foreign('kode_unit')->references('kode_unit')->on('unit')->onDelete('cascade');
            $table->foreign('kode_ta')->references('kode_ta')->on('konfigurasi_tahun_ajaran')->onDelete('cascade');
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
        Schema::dropIfExists('jadwal_pelajaran');
    }
};

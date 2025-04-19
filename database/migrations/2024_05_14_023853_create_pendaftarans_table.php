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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->char('no_pendaftaran_online', 10)->primary();
            $table->date('tanggal_');
            $table->char('nisn', 11)->nullable();
            $table->string('nama_lengkap');
            $table->char('jenis_kelamin', 1);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->smallInteger('anak_ke')->nullable();
            $table->smallInteger('jumlah_saudara')->nullable();
            $table->string('alamat')->nullable();
            $table->char('kode_pos', 5)->nullable();
            $table->char('no_kk', 16)->nullable();
            $table->char('nik_ayah', 16)->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->char('nik_ibu', 16)->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('no_hp_orang_tua', 15)->nullable();
            $table->char('kode_unit', 3);
            $table->char('kode_ta', 6);
            $table->foreign('kode_unit')->references('kode_unit')->on('unit')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('kode_ta')->references('kode_ta')->on('konfigurasi_tahun_ajaran')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};

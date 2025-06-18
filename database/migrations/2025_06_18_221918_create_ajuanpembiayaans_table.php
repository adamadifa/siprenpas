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
        Schema::create('koperasi_pembiayaan_ajuan', function (Blueprint $table) {
            $table->char('no_ajuan', 10)->primary();
            $table->date('tanggal');
            $table->char('no_anggota', 10);
            $table->char('kode_pembiayaan', 3);
            $table->integer('jumlah');
            $table->smallInteger('persentase');
            $table->smallInteger('jangka_waktu');
            $table->integer('jmlbayar');
            $table->string('keperluan', 100);
            $table->string('jaminan', 100);
            $table->char('ktp_pemohon', 1)->nullable();
            $table->char('ktp_pasangan', 1)->nullable();
            $table->char('kartu_keluarga', 1)->nullable();
            $table->char('struk_gaji', 1)->nullable();
            $table->char('rincian_barang', 1)->nullable();
            $table->char('status', 1)->default(0);
            $table->timestamps();
            $table->foreign('no_anggota')->references('no_anggota')->on('koperasi_anggota')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('kode_pembiayaan')->references('kode_pembiayaan')->on('koperasi_jenis_pembiayaan')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koperasi_pembiayaan_ajuan');
    }
};

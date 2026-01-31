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
        Schema::create('rencana_penilaian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bobot_penilaian_id')->index();
            $table->enum('kategori_penilaian', ['SUMATIF', 'SAS']);
            $table->string('kode_penilaian', 10); // PH1, PH2, SAS
            $table->string('nama_penilaian', 100); // Bab 1, Ujian Akhir
            $table->text('keterangan')->nullable();
            $table->date('tanggal_penilaian')->nullable();
            $table->timestamps();

            $table->foreign('bobot_penilaian_id')->references('id')->on('bobot_penilaian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencana_penilaian');
    }
};

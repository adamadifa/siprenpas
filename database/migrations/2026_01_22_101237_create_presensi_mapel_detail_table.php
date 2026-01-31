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
        Schema::create('presensi_mapel_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('presensi_mapel_id')->index();
            // Assuming siswa table uses 'id_siswa' as PK which is BigInt or similar.
            $table->char('siswa_id', 7)->index(); 
            $table->enum('status', ['H', 'I', 'S', 'A'])->default('H');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('presensi_mapel_id')->references('id')->on('presensi_mapel')->onDelete('cascade');
            $table->foreign('siswa_id')->references('id_siswa')->on('siswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_mapel_detail');
    }
};

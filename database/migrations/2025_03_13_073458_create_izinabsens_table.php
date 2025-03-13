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
        Schema::create('presensi_izinabsen', function (Blueprint $table) {
            $table->char('kode_izin')->primary();
            $table->date('tanggal');
            $table->date('dari');
            $table->date('sampai');
            $table->char('npp', 10);
            $table->string('keterangan');
            $table->char('status', 1);
            $table->foreign('npp')->references('npp')->on('karyawan')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_izinabsen');
    }
};

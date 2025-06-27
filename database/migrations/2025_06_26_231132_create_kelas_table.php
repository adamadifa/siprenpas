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
        Schema::create('kelas', function (Blueprint $table) {
            $table->char('kode_kelas', 9)->primary();
            $table->string('nama_kelas', 20);
            $table->char('kode_unit', 3);
            $table->char('tingkat', 1);
            $table->char('kode_ta', 6);
            $table->foreign('kode_unit')->references('kode_unit')->on('unit')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('kode_ta')->references('kode_ta')->on('konfigurasi_tahun_ajaran')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};

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
        Schema::create('kelas_siswa', function (Blueprint $table) {
            $table->char('kode_kelas', 9);
            $table->char('id_siswa', 7);
            $table->foreign('kode_kelas')->references('kode_kelas')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_siswa');
    }
};

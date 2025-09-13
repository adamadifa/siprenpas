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
        Schema::create('siswa_anggota', function (Blueprint $table) {
            $table->char('id_siswa', 7);
            $table->char('no_anggota', 10);
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('no_anggota')->references('no_anggota')->on('koperasi_anggota')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            
            // Composite primary key
            $table->primary(['id_siswa', 'no_anggota']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_anggota');
    }
};

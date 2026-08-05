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
        Schema::table('guru', function (Blueprint $table) {
            $table->foreign('npp')->references('npp')->on('karyawan')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('kode_unit')->references('kode_unit')->on('unit')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('kode_jabatan')->references('kode_jabatan')->on('jabatan_akademik')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            $table->dropForeign(['npp']);
            $table->dropForeign(['kode_unit']);
            $table->dropForeign(['kode_jabatan']);
        });
    }
};

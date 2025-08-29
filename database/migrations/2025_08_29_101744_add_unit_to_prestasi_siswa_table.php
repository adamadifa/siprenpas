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
        Schema::table('prestasi_siswa', function (Blueprint $table) {
            $table->string('kode_unit', 3)->nullable()->after('id_siswa'); // Foreign key ke tabel unit
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi_siswa', function (Blueprint $table) {
            $table->dropColumn('kode_unit');
        });
    }
};

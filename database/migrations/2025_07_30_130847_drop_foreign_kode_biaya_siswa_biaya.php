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
        Schema::table('siswa_biaya', function (Blueprint $table) {
            $table->dropForeign('siswa_biaya_kode_biaya_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa_biaya', function (Blueprint $table) {
            $table->foreign('kode_biaya')->references('kode_biaya')->on('konfigurasi_biaya')->onDelete('cascade');
        });
    }
};

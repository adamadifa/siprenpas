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
        Schema::table('pendaftaran_potongan', function (Blueprint $table) {
            $table->char('kode_biaya', 10)->change();
            $table->foreign('kode_biaya')->references('kode_biaya')->on('konfigurasi_biaya')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_potongan', function (Blueprint $table) {
            $table->char('kode_biaya', 8)->change();
            $table->foreign('kode_biaya')->references('kode_biaya')->on('konfigurasi_biaya')->onDelete('restrict');
        });
    }
};

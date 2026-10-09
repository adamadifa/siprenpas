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
        Schema::table('konfigurasi_biaya', function (Blueprint $table) {
            $table->dropForeign('konfigurasi_biaya_kode_ta_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konfigurasi_biaya', function (Blueprint $table) {
            $table->foreign('kode_ta')->references('kode_ta')->on('konfigurasi_tahun_ajaran')->restrictOnDelete()->cascadeOnUpdate();
        });
    }
};

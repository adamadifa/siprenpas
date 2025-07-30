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
        Schema::table('spp_rencana', function (Blueprint $table) {
            $table->char('kode_biaya', 10)->change();
            $table->foreign('kode_biaya')->references('kode_biaya')->on('konfigurasi_biaya')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spp_rencana', function (Blueprint $table) {
            $table->dropForeign('spp_rencana_kode_biaya_foreign');
            $table->string('kode_biaya', 8)->change();
        });
    }
};

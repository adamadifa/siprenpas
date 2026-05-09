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
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->enum('jenis_pendaftaran', ['Baru', 'Pindahan'])->default('Baru')->after('tanggal_pendaftaran');
            $table->integer('tingkat_masuk')->default(1)->after('jenis_pendaftaran');
        });

        Schema::table('konfigurasi_biaya', function (Blueprint $table) {
            $table->boolean('is_pindahan')->default(false)->after('asrama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['jenis_pendaftaran', 'tingkat_masuk']);
        });

        Schema::table('konfigurasi_biaya', function (Blueprint $table) {
            $table->dropColumn('is_pindahan');
        });
    }
};

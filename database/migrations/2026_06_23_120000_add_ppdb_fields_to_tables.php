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
        Schema::table('pengaturan_umum', function (Blueprint $table) {
            if (!Schema::hasColumn('pengaturan_umum', 'brosur_utama')) {
                $table->string('brosur_utama')->nullable()->after('session_lifetime');
            }
        });

        Schema::table('unit', function (Blueprint $table) {
            if (!Schema::hasColumn('unit', 'brosur_unit')) {
                $table->string('brosur_unit')->nullable()->after('keterangan');
            }
            if (!Schema::hasColumn('unit', 'rincian_biaya')) {
                $table->string('rincian_biaya')->nullable()->after('brosur_unit');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaturan_umum', function (Blueprint $table) {
            if (Schema::hasColumn('pengaturan_umum', 'brosur_utama')) {
                $table->dropColumn('brosur_utama');
            }
        });

        Schema::table('unit', function (Blueprint $table) {
            if (Schema::hasColumn('unit', 'brosur_unit')) {
                $table->dropColumn('brosur_unit');
            }
            if (Schema::hasColumn('unit', 'rincian_biaya')) {
                $table->dropColumn('rincian_biaya');
            }
        });
    }
};

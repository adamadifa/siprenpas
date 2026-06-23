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
        Schema::table('unit', function (Blueprint $table) {
            if (Schema::hasColumn('unit', 'rincian_biaya')) {
                $table->dropColumn('rincian_biaya');
            }
            if (!Schema::hasColumn('unit', 'rincian_biaya_fullday')) {
                $table->string('rincian_biaya_fullday')->nullable()->after('brosur_unit');
            }
            if (!Schema::hasColumn('unit', 'rincian_biaya_boarding')) {
                $table->string('rincian_biaya_boarding')->nullable()->after('rincian_biaya_fullday');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit', function (Blueprint $table) {
            if (Schema::hasColumn('unit', 'rincian_biaya_fullday')) {
                $table->dropColumn('rincian_biaya_fullday');
            }
            if (Schema::hasColumn('unit', 'rincian_biaya_boarding')) {
                $table->dropColumn('rincian_biaya_boarding');
            }
            if (!Schema::hasColumn('unit', 'rincian_biaya')) {
                $table->string('rincian_biaya')->nullable()->after('brosur_unit');
            }
        });
    }
};

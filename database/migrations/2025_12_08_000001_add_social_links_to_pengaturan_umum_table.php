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
            $table->string('facebook', 255)->nullable()->after('website');
            $table->string('youtube', 255)->nullable()->after('facebook');
            $table->string('instagram', 255)->nullable()->after('youtube');
            $table->string('tiktok', 255)->nullable()->after('instagram');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaturan_umum', function (Blueprint $table) {
            $table->dropColumn(['facebook', 'youtube', 'instagram', 'tiktok']);
        });
    }
};



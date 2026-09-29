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
        Schema::table('unit_landing_settings', function (Blueprint $table) {
            $table->string('hero_background_image')->nullable()->after('hero_model_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit_landing_settings', function (Blueprint $table) {
            $table->dropColumn('hero_background_image');
        });
    }
};

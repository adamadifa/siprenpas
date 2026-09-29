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
            $table->string('testimoni_image_1')->nullable()->after('testimoni_description');
            $table->string('testimoni_image_2')->nullable()->after('testimoni_image_1');
            $table->string('testimoni_image_3')->nullable()->after('testimoni_image_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit_landing_settings', function (Blueprint $table) {
            $table->dropColumn(['testimoni_image_1', 'testimoni_image_2', 'testimoni_image_3']);
        });
    }
};

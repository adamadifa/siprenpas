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
            $table->string('model_1')->nullable()->after('background_login');
            $table->string('model_2')->nullable()->after('model_1');
            $table->string('model_3')->nullable()->after('model_2');
            $table->string('model_4')->nullable()->after('model_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaturan_umum', function (Blueprint $table) {
            $table->dropColumn(['model_1', 'model_2', 'model_3', 'model_4']);
        });
    }
};

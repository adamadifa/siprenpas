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
        Schema::table('siswa_biaya', function (Blueprint $table) {
            $table->string('status_naik_kelas')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa_biaya', function (Blueprint $table) {
            $table->dropColumn('status_naik_kelas');
        });
    }
};

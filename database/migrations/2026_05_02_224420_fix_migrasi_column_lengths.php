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
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('nisn', 20)->nullable()->change();
        });

        Schema::table('migrasi_log_detail', function (Blueprint $table) {
            $table->text('keterangan')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->char('nisn', 10)->change();
        });

        Schema::table('migrasi_log_detail', function (Blueprint $table) {
            $table->string('keterangan', 255)->change();
        });
    }
};

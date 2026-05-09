<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // DB::statement is used because modifying enum columns in older Laravel/MySQL 
        // can be tricky with standard Blueprint methods without extra packages.
        DB::statement("ALTER TABLE pendaftaran MODIFY COLUMN jenis_pendaftaran ENUM('Baru', 'Pindahan', 'Migrasi') NOT NULL DEFAULT 'Baru'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE pendaftaran MODIFY COLUMN jenis_pendaftaran ENUM('Baru', 'Pindahan') NOT NULL DEFAULT 'Baru'");
    }
};

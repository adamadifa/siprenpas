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
        Schema::table('pendaftaran_online', function (Blueprint $table) {
            $table->char('id_province', 2)->after('alamat')->nullable();
            $table->char('id_regency', 4)->after('id_province')->nullable();
            $table->char('id_district', 7)->after('id_regency')->nullable();
            $table->char('id_village', 10)->after('id_district')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_online', function (Blueprint $table) {
            $table->dropColumn('id_province');
            $table->dropColumn('id_regency');
            $table->dropColumn('id_district');
            $table->dropColumn('id_village');
        });
    }
};

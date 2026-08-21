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
        Schema::table('agenda_kegiatan', function (Blueprint $table) {
            $table->char('kode_unit', 3)->nullable()->after('kode_jabatan');
            $table->foreign('kode_unit')->references('kode_unit')->on('unit')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agenda_kegiatan', function (Blueprint $table) {
            $table->dropForeign(['kode_unit']);
            $table->dropColumn('kode_unit');
        });
    }
};

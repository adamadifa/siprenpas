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
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            $table->char('kode_unit', 3)->after('kode_ta')->nullable();
            
            // Foreign key to unit table
            $table->foreign('kode_unit')->references('kode_unit')->on('unit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            $table->dropForeign(['kode_unit']);
            $table->dropColumn('kode_unit');
        });
    }
};

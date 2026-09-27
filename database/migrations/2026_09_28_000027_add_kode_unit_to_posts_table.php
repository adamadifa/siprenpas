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
        Schema::table('posts', function (Blueprint $table) {
            $table->char('kode_unit', 3)->nullable()->default('U06')->after('category_id');
            $table->foreign('kode_unit')->references('kode_unit')->on('unit')->onDelete('set null')->onUpdate('cascade');
        });

        // Set existing records without kode_unit to U06 (Pesantren)
        \Illuminate\Support\Facades\DB::table('posts')
            ->whereNull('kode_unit')
            ->orWhere('kode_unit', '')
            ->update(['kode_unit' => 'U06']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['kode_unit']);
            $table->dropColumn('kode_unit');
        });
    }
};

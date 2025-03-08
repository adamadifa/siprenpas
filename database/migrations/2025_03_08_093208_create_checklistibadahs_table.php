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
        Schema::create('checklist_ibadah', function (Blueprint $table) {
            $table->char('kode_checklist_ibadah', 10)->primary();
            $table->date('tanggal');
            $table->char('npp', 10);
            $table->timestamps();
            $table->foreign('npp')->references('npp')->on('karyawan')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_ibadah');
    }
};

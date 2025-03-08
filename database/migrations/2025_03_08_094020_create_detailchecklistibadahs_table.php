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
        Schema::create('checklist_ibadah_detail', function (Blueprint $table) {
            $table->char('kode_checklist_ibadah', 10);
            $table->unsignedBigInteger('id_kegiatan_ibadah');
            $table->foreign('kode_checklist_ibadah')->references('kode_checklist_ibadah')->on('checklist_ibadah')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('id_kegiatan_ibadah')->references('id')->on('kegiatan_ibadah')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_ibadah_detail');
    }
};

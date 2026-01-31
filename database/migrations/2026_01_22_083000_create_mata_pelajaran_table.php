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
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->char('kode_unit', 3)->nullable()->index();
            $table->string('kode_matpel', 20)->nullable();
            $table->string('nama_matpel');
            $table->enum('kelompok', ['A', 'B', 'C', 'D'])->default('A');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('mata_pelajaran')->onDelete('cascade');
            $table->foreign('kode_unit')->references('kode_unit')->on('unit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_pelajaran');
    }
};

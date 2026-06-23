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
        Schema::create('nilai_ekstrakurikuler', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ekstrakurikuler_id');
            $table->integer('id_siswa'); // references siswa table
            $table->char('nilai', 2)->nullable(); // A, B, C, D
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();

            // Foreign keys / Indexes
            $table->foreign('ekstrakurikuler_id')->references('id')->on('ekstrakurikuler')->onDelete('cascade');
            $table->unique(['ekstrakurikuler_id', 'id_siswa']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_ekstrakurikuler');
    }
};

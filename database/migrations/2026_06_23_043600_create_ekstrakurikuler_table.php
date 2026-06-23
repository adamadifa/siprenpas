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
        Schema::create('ekstrakurikuler', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ekstrakurikuler', 100);
            $table->string('kode_ta', 10);
            $table->unsignedBigInteger('guru_id'); // koordinator
            $table->timestamps();

            // Foreign keys / Indexes
            $table->foreign('guru_id')->references('id')->on('guru')->onDelete('cascade');
            $table->index('kode_ta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekstrakurikuler');
    }
};

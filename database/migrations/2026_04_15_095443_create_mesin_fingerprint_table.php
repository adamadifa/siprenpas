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
        Schema::create('mesin_fingerprint', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mesin');
            $table->string('sn')->unique()->comment('Serial Number mesin');
            $table->string('ip')->nullable();
            $table->string('titik_koordinat')->nullable();
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesin_fingerprint');
    }
};

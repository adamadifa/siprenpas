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
        Schema::create('pendaftaran_got_talent', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_register', 50)->unique();
            $table->string('nama_lengkap', 100);
            $table->unsignedBigInteger('id_jenjang');
            $table->timestamps();

            $table->foreign('id_jenjang')->references('id')->on('jenjang_pendidikan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_got_talent');
    }
};

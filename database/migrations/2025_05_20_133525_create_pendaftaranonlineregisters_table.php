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
        Schema::create('pendaftaran_online_register', function (Blueprint $table) {
            $table->char('no_register', 10)->primary()->comment('Nomor register pendaftaran online');
            $table->char('no_pendaftaran', 11)->unique()->comment('Nomor pendaftaran yang sudah diregistrasi');

            $table->timestamps();

            // Foreign key ke tabel pendaftaran_online
            $table->foreign('no_register')
                ->references('no_register')
                ->on('pendaftaran_online')
                ->onDelete('restrict');

            // Foreign key ke tabel pendaftaran
            $table->foreign('no_pendaftaran')
                ->references('no_pendaftaran')
                ->on('pendaftaran')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_online_register');
    }
};

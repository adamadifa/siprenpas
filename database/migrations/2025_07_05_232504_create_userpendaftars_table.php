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
        Schema::create('user_pendaftar', function (Blueprint $table) {
            $table->char('no_register', 10)->unique();
            $table->bigInteger('id_user')->unsigned();
            $table->foreign('no_register')->references('no_register')->on('pendaftaran_online')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_pendaftar');
    }
};

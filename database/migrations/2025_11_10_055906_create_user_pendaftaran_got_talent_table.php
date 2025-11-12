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
        Schema::create('user_pendaftaran_got_talent', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pendaftaran');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_pendaftaran')->references('id')->on('pendaftaran_got_talent')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('id_user')->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_pendaftaran_got_talent');
    }
};

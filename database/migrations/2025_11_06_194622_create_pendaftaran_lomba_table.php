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
        Schema::create('pendaftaran_lomba', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pendaftaran');
            $table->unsignedBigInteger('id_perlombaan');
            $table->timestamps();

            $table->foreign('id_pendaftaran')->references('id')->on('pendaftaran_got_talent')->onDelete('cascade');
            $table->foreign('id_perlombaan')->references('id')->on('perlombaan')->onDelete('cascade');
            $table->unique(['id_pendaftaran', 'id_perlombaan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_lomba');
    }
};

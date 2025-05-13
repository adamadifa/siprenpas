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
        Schema::create('pendaftaran_online_dokumen', function (Blueprint $table) {
            $table->char('no_register', 10);
            $table->char('kode_dokumen', 3);
            $table->string('nama_file');
            $table->timestamps();

            $table->foreign('no_register')
                ->references('no_register')
                ->on('pendaftaran_online')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_online_dokumen');
    }
};

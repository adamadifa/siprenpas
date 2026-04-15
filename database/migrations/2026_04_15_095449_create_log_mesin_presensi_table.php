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
        Schema::create('log_mesin_presensi', function (Blueprint $table) {
            $table->id();
            $table->string('pin');
            $table->integer('status_scan')->default(0);
            $table->datetime('jam_absen')->nullable();
            $table->unsignedBigInteger('id_mesin')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=gagal, 1=berhasil');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_mesin')->references('id')->on('mesin_fingerprint')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_mesin_presensi');
    }
};

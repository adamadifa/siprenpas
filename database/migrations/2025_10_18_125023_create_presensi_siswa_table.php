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
        Schema::create('presensi_siswa', function (Blueprint $table) {
            $table->id();
            $table->char('no_pendaftaran', 11);
            $table->date('tanggal');
            $table->time('jam_in')->nullable();
            $table->time('jam_out')->nullable();
            $table->enum('status', ['h', 'i', 's', 'a'])->default('h'); // h=hadir, i=izin, s=sakit, a=alpha
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('no_pendaftaran')->references('no_pendaftaran')->on('pendaftaran')->onDelete('cascade');

            // Index untuk performa
            $table->index(['no_pendaftaran', 'tanggal']);
            $table->index('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_siswa');
    }
};

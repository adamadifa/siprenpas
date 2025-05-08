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
        Schema::create('pendaftaran_online_bayar', function (Blueprint $table) {
            $table->id('id');
            $table->string('no_register');
            $table->date('tanggal_pembayaran');
            $table->decimal('jumlah_pembayaran', 12, 2);
            $table->enum('metode_pembayaran', ['transfer', 'tunai']);
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Foreign key ke tabel pendaftaran
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
        Schema::dropIfExists('pendaftaran_online_bayar');
    }
};

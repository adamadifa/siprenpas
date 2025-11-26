<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('konfirmasi_pembayaran_got_talent', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftaran_got_talent_id'); // Foreign key ke tabel pendaftaran
            $table->date('tanggal_pembayaran');
            $table->decimal('jumlah_pembayaran', 15, 2);
            $table->enum('metode_pembayaran', ['transfer', 'tunai']);
            $table->string('bukti_pembayaran')->nullable(); // Path/URL file bukti
            $table->text('keterangan')->nullable();
            $table->enum('status', ['pending', 'diverifikasi', 'ditolak'])->default('pending');
            $table->text('catatan_admin')->nullable(); // Catatan dari admin saat verifikasi
            $table->unsignedBigInteger('diverifikasi_oleh')->nullable(); // ID admin yang verifikasi
            $table->timestamp('diverifikasi_pada')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('pendaftaran_got_talent_id', 'kpbgt_pendaftaran_fk')
                  ->references('id')
                  ->on('pendaftaran_got_talent')
                  ->onDelete('cascade');
                  
            $table->foreign('diverifikasi_oleh', 'kpbgt_user_fk')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
                  
            // Index untuk performa
            $table->index('pendaftaran_got_talent_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('konfirmasi_pembayaran_got_talent');
    }
};


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
        Schema::create('migrasi_log_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('migrasi_log_id');
            $table->char('no_pendaftaran', 11)->nullable();
            $table->char('id_siswa', 7)->nullable();
            $table->boolean('is_new_siswa')->default(true);
            $table->integer('baris_excel');
            $table->enum('status', ['success', 'failed', 'rolled_back'])->default('success');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('migrasi_log_id')->references('id')->on('migrasi_log')->onDelete('cascade');
            // Foreign keys to pendaftaran and siswa are optional here to avoid issues during rollback/delete, 
            // but helpful for data integrity if needed.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('migrasi_log_detail');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jabatan_akademik', function (Blueprint $table) {
            $table->string('kode_jabatan', 10)->primary();
            $table->string('nama_jabatan', 100);
            $table->integer('urutan')->default(0);
            $table->boolean('tampil_di_raport')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan_akademik');
    }
};

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
        Schema::table('pendaftaran_got_talent', function (Blueprint $table) {
            $table->string('asal_sekolah', 200)->nullable()->after('id_jenjang');
            $table->text('alamat_sekolah')->nullable()->after('asal_sekolah');
            $table->text('alamat_rumah')->nullable()->after('alamat_sekolah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_got_talent', function (Blueprint $table) {
            $table->dropColumn(['asal_sekolah', 'alamat_sekolah', 'alamat_rumah']);
        });
    }
};



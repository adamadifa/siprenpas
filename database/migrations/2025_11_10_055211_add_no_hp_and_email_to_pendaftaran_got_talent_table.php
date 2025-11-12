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
            $table->string('no_hp', 20)->nullable()->after('alamat_rumah');
            $table->string('email', 100)->nullable()->after('no_hp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_got_talent', function (Blueprint $table) {
            $table->dropColumn(['no_hp', 'email']);
        });
    }
};

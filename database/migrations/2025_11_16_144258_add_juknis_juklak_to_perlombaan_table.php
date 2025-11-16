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
        Schema::table('perlombaan', function (Blueprint $table) {
            $table->string('juknis_juklak')->nullable()->after('id_jenjang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perlombaan', function (Blueprint $table) {
            $table->dropColumn('juknis_juklak');
        });
    }
};

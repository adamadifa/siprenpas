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
            if (!Schema::hasColumn('perlombaan', 'biaya_pendaftaran')) {
                $table->decimal('biaya_pendaftaran', 15, 2)->default(0)->after('id_jenjang');
            }
            if (!Schema::hasColumn('perlombaan', 'contact_person')) {
                $table->string('contact_person', 150)->nullable()->after('biaya_pendaftaran');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perlombaan', function (Blueprint $table) {
            if (Schema::hasColumn('perlombaan', 'contact_person')) {
                $table->dropColumn('contact_person');
            }
            if (Schema::hasColumn('perlombaan', 'biaya_pendaftaran')) {
                $table->dropColumn('biaya_pendaftaran');
            }
        });
    }
};



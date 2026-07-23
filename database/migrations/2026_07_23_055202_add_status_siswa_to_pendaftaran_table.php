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
        Schema::table('pendaftaran', function (Blueprint $table) {
            // 1: Aktif, 2: Lulus/Naik Kelas, 3: Mengundurkan Diri, 4: Pindah Sekolah, 5: Dikeluarkan
            $table->smallInteger('status_siswa')->default(1)->after('kode_ta');
            $table->date('tanggal_keluar')->nullable()->after('status_siswa');
            $table->string('alasan_keluar')->nullable()->after('tanggal_keluar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['status_siswa', 'tanggal_keluar', 'alasan_keluar']);
        });
    }
};

<?php

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Jobs\SendChecklistIbadahJob;

$tanggal = date('Y-m-d');
echo "Testing SendChecklistIbadahJob for date: $tanggal\n";

try {
    // Check if tables have records
    $karyawanCount = DB::table('karyawan')->count();
    $checklistCount = DB::table('checklist_ibadah')->count();
    $detailCount = DB::table('checklist_ibadah_detail')->count();
    echo "Karyawan count: $karyawanCount\n";
    echo "Checklist count: $checklistCount\n";
    echo "Detail count: $detailCount\n";

    echo "Last 5 checklist_ibadah entries:\n";
    $lastChecklists = DB::table('checklist_ibadah')->orderBy('tanggal', 'desc')->limit(5)->get();
    foreach ($lastChecklists as $c) {
        echo "Kode: {$c->kode_checklist_ibadah}, Tanggal: {$c->tanggal}, NPP: {$c->npp}\n";
    }

    echo "Last 5 checklist_ibadah_detail entries:\n";
    $lastDetails = DB::table('checklist_ibadah_detail')->orderBy('kode_checklist_ibadah', 'desc')->limit(5)->get();
    foreach ($lastDetails as $d) {
        echo "Kode: {$d->kode_checklist_ibadah}, Kegiatan ID: {$d->id_kegiatan_ibadah}\n";
    }

    // Run query directly
    $users = DB::table('checklist_ibadah')
        ->join('karyawan', 'checklist_ibadah.npp', '=', 'karyawan.npp')
        ->join('checklist_ibadah_detail', 'checklist_ibadah.kode_checklist_ibadah', '=', 'checklist_ibadah_detail.kode_checklist_ibadah')
        ->where('checklist_ibadah.tanggal', $tanggal)
        ->orderBy('karyawan.nama_lengkap', 'asc')
        ->select('karyawan.nama_lengkap')
        ->distinct()
        ->get();

    echo "Found " . $users->count() . " users who filled today's checklist:\n";
    foreach ($users as $user) {
        echo "- " . $user->nama_lengkap . "\n";
    }

    echo "Dispatching Job synchronously...\n";
    $job = new SendChecklistIbadahJob($tanggal);
    $job->handle();
    echo "Done.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

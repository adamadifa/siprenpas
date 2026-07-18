<?php

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tanggal = date('Y-m-d');
echo "Generating dummy checklist_ibadah for date: $tanggal\n";

$npps = [101, 103, 104, 106];

foreach ($npps as $npp) {
    // Check if employee exists
    $karyawan = DB::table('karyawan')->where('npp', $npp)->first();
    if (!$karyawan) {
        echo "Employee with NPP $npp not found, skipping...\n";
        continue;
    }

    // Check if already has checklist for today
    $exists = DB::table('checklist_ibadah')
        ->where('tanggal', $tanggal)
        ->where('npp', $npp)
        ->first();

    if ($exists) {
        echo "Checklist for NPP $npp already exists for today.\n";
        continue;
    }

    // Generate kode_checklist_ibadah
    $last_checklist_ibadah = DB::table('checklist_ibadah')
        ->orderBy('kode_checklist_ibadah', 'desc')
        ->first();
    $last_kode = $last_checklist_ibadah ? $last_checklist_ibadah->kode_checklist_ibadah : '';
    
    if (empty($last_kode)) {
        $kode_checklist_ibadah = date('ymd') . '0001';
    } else {
        $kode_checklist_ibadah = strval(intval($last_kode) + 1);
    }

    // Create checklist_ibadah
    DB::table('checklist_ibadah')->insert([
        'kode_checklist_ibadah' => $kode_checklist_ibadah,
        'tanggal' => $tanggal,
        'npp' => $npp,
    ]);

    // Create details
    DB::table('checklist_ibadah_detail')->insert([
        'kode_checklist_ibadah' => $kode_checklist_ibadah,
        'id_kegiatan_ibadah' => 1,
    ]);

    echo "Created dummy checklist for {$karyawan->nama_lengkap} (NPP: $npp) with code $kode_checklist_ibadah\n";
}

echo "Done generating dummy data.\n";

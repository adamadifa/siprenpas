<?php

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$users = DB::table('checklist_ibadah')
    ->join('karyawan', 'checklist_ibadah.npp', '=', 'karyawan.npp')
    ->join('checklist_ibadah_detail', 'checklist_ibadah.kode_checklist_ibadah', '=', 'checklist_ibadah_detail.kode_checklist_ibadah')
    ->where('checklist_ibadah.tanggal', date('Y-m-d'))
    ->orderBy('karyawan.nama_lengkap', 'asc')
    ->select('karyawan.nama_lengkap')
    ->distinct()
    ->get();

$unitRecap = DB::table('checklist_ibadah')
    ->join('karyawan', 'checklist_ibadah.npp', '=', 'karyawan.npp')
    ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
    ->where('checklist_ibadah.tanggal', date('Y-m-d'))
    ->select('unit.nama_unit', DB::raw('count(distinct checklist_ibadah.npp) as total'))
    ->groupBy('unit.nama_unit')
    ->orderBy('unit.nama_unit', 'asc')
    ->get();

$formattedDate = date('d-m-Y');

$message = "Daftar SDM Yang sudah Mengisi Checklist Ibadah (" . $formattedDate . "):\n";
$i = 1;
foreach ($users as $user) {
    $message .= $i . ". " . $user->nama_lengkap . "\n";
    $i++;
}

$message .= "\n*Rekapitulasi per Unit:*\n";
$message .= "```\n";
$message .= sprintf("%-18s | %s\n", "Unit", "Jumlah");
$message .= str_repeat("-", 27) . "\n";
foreach ($unitRecap as $recap) {
    $unitName = strlen($recap->nama_unit) > 18 ? substr($recap->nama_unit, 0, 15) . '...' : $recap->nama_unit;
    $message .= sprintf("%-18s | %d\n", $unitName, $recap->total);
}
$message .= "```\n";

echo $message;

<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PresensiMapel;
use App\Models\PresensiMapelDetail;

$today = date('Y-m-d');
echo "Today's date on server: $today\n";

$presensi = PresensiMapel::with('details')->get();
echo "Total presensi records: " . $presensi->count() . "\n";

foreach ($presensi as $p) {
    echo "ID: {$p->id}, Jadwal ID: {$p->jadwal_pelajaran_id}, Tanggal: {$p->tanggal}, Materi: {$p->materi}, Details Count: " . $p->details->count() . "\n";
}

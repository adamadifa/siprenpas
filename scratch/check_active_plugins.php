<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$plugins = DB::table('plugins')->get();
echo "--- ALL PLUGINS ---\n";
foreach ($plugins as $p) {
    echo "ID: {$p->id}, Name: {$p->name}, UUID: {$p->uuid}, Active: {$p->is_active}, Device ID: {$p->device_id}, Bot Type: {$p->typeBot}\n";
    echo "Main Data: {$p->main_data}\n";
    echo "Extra Data: {$p->extra_data}\n\n";
}

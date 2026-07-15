<?php
$file = 'e:\\02 - PROJECT\\gateway\\stderr.log';
if (!file_exists($file)) {
    echo "stderr.log not found!\n";
    exit;
}

$handle = fopen($file, "r");
$lines = [];
while (($line = fgets($handle)) !== false) {
    $lines[] = $line;
    if (count($lines) > 150) {
        array_shift($lines);
    }
}
fclose($handle);

echo "Last 150 lines:\n";
echo implode("", $lines);

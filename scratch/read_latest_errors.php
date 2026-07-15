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
    if (count($lines) > 20000) {
        array_shift($lines);
    }
}
fclose($handle);

echo "Searching for 'gemini' or 'error' in last 20000 lines:\n";
foreach ($lines as $i => $line) {
    if (stripos($line, 'gemini') !== false || stripos($line, 'error') !== false) {
        if (stripos($line, 'printQRInTerminal') === false && stripos($line, 'Connection Closed') === false) {
            echo "Line " . ($i + 1) . ": " . $line;
        }
    }
}

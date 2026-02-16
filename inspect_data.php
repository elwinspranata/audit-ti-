<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\AuditReport;

$report = AuditReport::find(3);
if (!$report) die("No report 3");

$data = $report->toArray();
foreach ($data as $key => $value) {
    if (is_string($value)) {
        echo "[$key]: " . $value . "\n";
    } elseif (is_array($value)) {
        echo "[$key]: (Array) " . json_encode($value) . "\n";
    }
}

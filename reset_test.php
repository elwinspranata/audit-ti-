<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Assessment;

$a = Assessment::find(1);
if ($a) {
    $a->status = 'approved';
    $a->assigned_auditor_id = null;
    $a->assigned_at = null;
    $a->verified_by = null;
    $a->verified_at = null;
    $a->completed_at = null;
    $a->save();
    echo "Assessment 1 reset to approved.\n";
} else {
    echo "Assessment 1 not found.\n";
}

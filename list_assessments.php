<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Assessment;
use App\Models\User;

foreach (Assessment::all() as $a) {
    echo "ID: " . $a->id . " | User: " . $a->user->email . " | Status: " . $a->status . " | Auditor: " . ($a->assigned_auditor_id ? $a->assignedAuditor->email : 'NONE') . "\n";
}

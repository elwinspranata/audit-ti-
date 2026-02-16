<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Assessment;
use App\Models\User;

$a = Assessment::find(1);
$auditor = User::where('role', 'auditor')->first();

if ($a && $auditor) {
    // We use the constants if available, or strings if not.
    // Based on my view_code_item, they are Assessment::STATUS_COMPLETED etc.
    $a->update([
        'status' => 'completed', 
        'assigned_auditor_id' => $auditor->id,
        'assigned_at' => now()
    ]);
    echo "Updated assessment 1 to COMPLETED and assigned to " . $auditor->email . "\n";
} else {
    echo "Failed to update assessment or auditor not found\n";
}

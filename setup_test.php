<?php
// Setup test data for auditor testing

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Assessment;
use App\Models\User;

// Find auditor
$auditor = User::where('role', 'auditor')->first();
if ($auditor) {
    echo "Auditor: {$auditor->email}\n";
} else {
    echo "No auditor found. Creating one...\n";
    $auditor = User::create([
        'name' => 'Test Auditor',
        'email' => 'auditor@test.com',
        'password' => bcrypt('password'),
        'role' => 'auditor',
    ]);
    echo "Created auditor: auditor@test.com (password: password)\n";
}

// Find or update assessment to completed
$assessment = Assessment::first();
if ($assessment) {
    $assessment->status = 'completed';
    $assessment->completed_at = now();
    $assessment->save();
    echo "Assessment ID: {$assessment->id} - Status set to 'completed'\n";
    echo "Assessment Name: {$assessment->name}\n";
} else {
    echo "No assessment found. Please create one from admin panel first.\n";
}

echo "\n--- TESTING INSTRUCTIONS ---\n";
echo "1. Login Admin: http://localhost:8000/login\n";
echo "2. Go to: http://localhost:8000/admin/assessments/{$assessment->id}\n";
echo "3. Assign auditor '{$auditor->email}' to the assessment\n";
echo "4. Logout, login as auditor: {$auditor->email}\n";
echo "5. Go to: http://localhost:8000/auditor/dashboard\n";
echo "Password: password (if newly created)\n";

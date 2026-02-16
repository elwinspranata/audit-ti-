<?php

use App\Models\User;
use App\Models\Package;
use App\Models\Assessment;
use App\Models\AssessmentItem;
use App\Models\CobitItem;
use App\Models\Jawaban;
use App\Models\Quisioner;
use Illuminate\Support\Facades\DB;

$user = User::where('email', 'test@example.com')->first();
$auditor = User::where('email', 'auditor@example.com')->first();
$package = Package::first();

if (!$user || !$package) {
    echo "User or Package not found. Please ensure users and packages exist.\n";
    exit(1);
}

echo "Activating subscription for user: {$user->email}\n";
$user->activateSubscription($package);

echo "Creating/retrieving assessment...\n";
$assessment = Assessment::where('user_id', $user->id)
    ->whereIn('status', [Assessment::STATUS_PENDING_SUBMISSION, Assessment::STATUS_IN_PROGRESS, Assessment::STATUS_APPROVED])
    ->first();

if (!$assessment) {
    $assessment = Assessment::create([
        'user_id' => $user->id,
        'name' => 'Assessment Manual Testing ' . now()->format('Y-m-d H:i'),
        'status' => Assessment::STATUS_APPROVED,
    ]);
}

echo "Filling questionnaires...\n";
$cobitItems = CobitItem::all();
foreach ($cobitItems as $cobitItem) {
    $assessmentItem = AssessmentItem::firstOrCreate([
        'assessment_id' => $assessment->id,
        'cobit_item_id' => $cobitItem->id,
    ]);

    $kategoris = $cobitItem->kategoris()->with('levels.quisioners')->get();
    foreach ($kategoris as $kategori) {
        foreach ($kategori->levels as $level) {
            foreach ($level->quisioners as $quisioner) {
                Jawaban::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'quisioner_id' => $quisioner->id,
                        'assessment_id' => $assessment->id,
                    ],
                    [
                        'level_id' => $level->id,
                        'jawaban' => 'F', // Fully achieved
                        'verification_status' => 'pending',
                        'evidence_type' => 'link',
                        'evidence_path' => 'https://example.com/evidence_dummy.png',
                        'evidence_original_name' => 'evidence_dummy.png',
                    ]
                );
            }
        }
    }
    $assessmentItem->updateProgress();
}

echo "Submitting assessment and assigning auditor...\n";
$assessment->status = Assessment::STATUS_COMPLETED;
$assessment->submitted_at = now();

if ($auditor) {
    $assessment->assigned_auditor_id = $auditor->id;
    $assessment->assigned_at = now();
    echo "Assigned to auditor: {$auditor->email}\n";
}

$assessment->save();

echo "SUCCESS: Assessment is now ready for audit.\n";

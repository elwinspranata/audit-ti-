<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\Assessment;
use App\Models\AuditReport;
use App\Models\User;

$id = 4;
$assessment = Assessment::with(['user', 'cobitItems'])->find($id);

if (!$assessment) {
    echo "Assessment $id not found\n";
    exit;
}

// Check if report exists
if ($assessment->auditReport) {
    $assessment->auditReport->delete();
}

$focalPoints = [];
foreach ($assessment->cobitItems as $item) {
    $focalPoints[] = [
        'process_name' => $item->nama_item . ' - ' . ($item->deskripsi ?? 'Assessment of ' . $item->nama_item),
        'rating' => rand(2, 4),
        'justification_text' => "Evidence gathered confirms that the process for {$item->nama_item} is implemented.\nDocumented policies exist and are followed in most cases.\nControl activities show consistent results.",
        'indicators_text' => "Monthly Compliance Report\nInternal Review Minutes\nSystem Logs Audit",
        'justification_points' => [
            "Evidence gathered confirms that the process for {$item->nama_item} is implemented.",
            "Documented policies exist and are followed in most cases.",
            "Control activities show consistent results."
        ],
        'indicators' => [
            "Monthly Compliance Report",
            "Internal Review Minutes",
            "System Logs Audit"
        ]
    ];
}

$report = AuditReport::create([
    'assessment_id' => $assessment->id,
    'auditor_id' => $assessment->assigned_auditor_id ?? User::where('role', 'auditor')->first()->id,
    'report_title' => 'JOINT RISK ASSESSMENT: ' . strtoupper($assessment->name),
    'company_name' => $assessment->user->company_name ?? 'PT. GLOBAL TEKNOLOGI SOLUSI',
    'company_address' => $assessment->user->department ?? 'Gedung Cyber 2, Lantai 15, Jakarta Selatan',
    'sign_off_authority' => 'Bpk. Ahmad Subarjo - IT Director',
    'audit_director' => 'Ir. Bambang Wijaya, M.Kom',
    'audit_director_phone' => '+62 811-2345-6789',
    'audit_manager' => 'Siska Amelia, S.T., CISA',
    'audit_manager_phone' => '+62 812-9876-5432',
    'lead_auditor_name' => User::find($assessment->assigned_auditor_id)->name ?? 'Auditor Senior',
    'lead_auditor_phone' => '+62 813-0000-1111',
    'executive_summary' => "The assessment for the period of 2026 indicates that the IT Governance framework is largely in place. The maturity level across the evaluated domains averages at an 'Established' level. However, there are significant opportunities to enhance automation in the monitoring of control activities.\n\nOverall, the control environment is stable, and management has demonstrated commitment to addressing identified gaps in a timely manner.",
    'background' => "This assessment was initiated as part of the annual compliance cycle for the IT department. The goal is to evaluate the effectiveness of IT processes in supporting business objectives and ensuring risk mitigation strategies are aligned with current industry standards.",
    'scope' => "The scope of this audit covers the selected COBIT 2019 Management Objectives including: " . $assessment->cobitItems->pluck('nama_item')->implode(', ') . ". The evaluation focuses on process outcomes and evidence of control implementation during the last 6 months.",
    'officer_name' => 'Hendro Pratama',
    'officer_title' => 'Head of IT Operations',
    'officer_response' => "We acknowledge the findings presented in this report. The IT Operations team is already working on a roadmap to implement the suggested improvements, particularly in automating our monitoring controls. We target to reach a 'Predictable' level for all key processes by the end of next fiscal year.",
    'officer_response_date' => now()->format('Y-m-d'),
    'it_process_focal_points' => $focalPoints,
    'status' => 'draft'
]);

echo "SUCCESS: Report created for Assessment #4\n";
echo "URL: http://127.0.0.1:8000/auditor/report/" . $report->id . "\n";

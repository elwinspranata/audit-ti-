<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AuditReport;
use App\Models\CobitItem;
use App\Services\UserProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AuditReportExport;

class AuditReportController extends Controller
{
    /**
     * Show form to create new audit report
     */
    public function create(Assessment $assessment)
    {
        // Verify auditor is assigned to this assessment
        if ($assessment->assigned_auditor_id !== Auth::id()) {
            return redirect()->route('auditor.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke assessment ini.');
        }

        // Only allow report creation for verified assessments
        if ($assessment->status !== Assessment::STATUS_VERIFIED) {
            return back()->with('error', 'Laporan audit hanya bisa dibuat setelah semua bukti diverifikasi.');
        }

        // Check if report already exists
        if ($assessment->auditReport) {
            return redirect()->route('auditor.report.edit', $assessment->auditReport);
        }

        $assessment->load(['user', 'cobitItems', 'jawabans.level.kategori.cobitItem']);

        // --- PRE-POPULATE TEMPLATE DATA ---
        $companyName = $assessment->user->company_name ?? 'Client Organization';
        $itemNames = $assessment->cobitItems->pluck('nama_item')->implode(', ');
        
        $templateData = [
            'report_title' => 'Internal Control Assessment: ' . ($assessment->name ?? 'IT Governance Review'),
            'company_name' => $companyName,
            'company_address' => $assessment->user->department ?? 'Main Headquarter',
            'sign_off_authority' => '',
            'base_background' => "",
            'base_scope' => "",
            'executive_summary' => "",
        ];

        // Group Focal Points by CobitItem
        $prefilledStrategic = $assessment->cobitItems->map(function($item) {
            return [
                'objective_name' => $item->nama_item,
                'detailed_objectives_text' => $item->nama_item,
                'justification' => "",
            ];
        });

        // --- PRE-POPULATE IT PROCESS FOCAL POINTS WITH RATINGS ---
    $assessment->load(['items.cobitItem.kategoris.levels.quisioners', 'jawabans']);
    
    $prefilledITProcess = $assessment->items->map(function($item) {
        return [
            'process_name' => $item->cobitItem->nama_item,
            'rating' => $item->calculateMaturityLevel(),
            'justification_text' => "",
            'indicators_text' => "",
        ];
    })->values();

    return view('auditor.reports.create', compact('assessment', 'templateData', 'prefilledITProcess'));
    }

    /**
     * Store new audit report
     */
    public function store(Request $request, Assessment $assessment)
    {
        // Verify auditor is assigned
        if ($assessment->assigned_auditor_id !== Auth::id()) {
            return redirect()->route('auditor.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke assessment ini.');
        }

        // Validate request
        $validated = $request->validate([
            // Basic fields (Exec Summary Page 2)
            'executive_summary' => 'required|string',
            'background' => 'required|string',
            'scope' => 'required|string',
            
            // Cover Page (Page 1)
            'report_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'sign_off_authority' => 'required|string|max:255',
            'audit_director' => 'required|string|max:255',
            'audit_director_phone' => 'nullable|string|max:50',
            'audit_manager' => 'required|string|max:255',
            'audit_manager_phone' => 'nullable|string|max:50',
            'lead_auditor_name' => 'required|string|max:255',
            'lead_auditor_phone' => 'nullable|string|max:50',

            // Officer Response (Page 2)
            'officer_name' => 'required|string|max:255',
            'officer_title' => 'required|string|max:255',
            'officer_response' => 'required|string',
            'officer_response_date' => 'required|date',

            // IT Process Focal Points (Page 3)
            'it_process_focal_points' => 'nullable|array',
            'it_process_focal_points.*.process_name' => 'required_with:it_process_focal_points|string|max:255',
            'it_process_focal_points.*.rating' => 'required_with:it_process_focal_points|integer|min:0|max:5',
            'it_process_focal_points.*.justification_text' => 'nullable|string',
            'it_process_focal_points.*.indicators_text' => 'nullable|string',
        ]);

        $distributionList = array_values(array_filter(array_map('trim', explode("\n", $request->distribution_list_text ?? ''))));


        $itProcessFocalPoints = [];
        if ($request->filled('it_process_focal_points')) {
            foreach ($request->it_process_focal_points as $focal) {
                if (!empty($focal['process_name'])) {
                    $focal['justification_points'] = array_values(array_filter(array_map('trim', explode("\n", $focal['justification_text'] ?? ''))));
                    $focal['indicators'] = array_values(array_filter(array_map('trim', explode("\n", $focal['indicators_text'] ?? ''))));
                    $itProcessFocalPoints[] = $focal;
                }
            }
        }

        $report = AuditReport::create([
            'assessment_id' => $assessment->id,
            'auditor_id' => Auth::id(),
            'executive_summary' => $validated['executive_summary'],
            'background' => $validated['background'],
            'scope' => $validated['scope'],
            'status' => AuditReport::STATUS_DRAFT,
            
            // Cover Page Info
            'report_title' => $validated['report_title'],
            'company_name' => $validated['company_name'],
            'company_address' => $validated['company_address'],
            'sign_off_authority' => $validated['sign_off_authority'],
            
            // Audit Contacts
            'audit_director' => $validated['audit_director'],
            'audit_director_phone' => $validated['audit_director_phone'] ?? null,
            'audit_manager' => $validated['audit_manager'],
            'audit_manager_phone' => $validated['audit_manager_phone'] ?? null,
            'lead_auditor_name' => $validated['lead_auditor_name'],
            'lead_auditor_phone' => $validated['lead_auditor_phone'] ?? null,
            
            // Officer Response
            'officer_name' => $validated['officer_name'],
            'officer_title' => $validated['officer_title'],
            'officer_response' => $validated['officer_response'],
            'officer_response_date' => $validated['officer_response_date'],
            
            // IT Process Focal Points
            'it_process_focal_points' => $itProcessFocalPoints,
            'maturity_rating_actual' => count($itProcessFocalPoints) > 0 ? array_sum(array_column($itProcessFocalPoints, 'rating')) / count($itProcessFocalPoints) : 0,
            'maturity_rating_target' => 4.0,
        ]);

        return redirect()->route('auditor.report.show', $report)
            ->with('success', 'Laporan audit berhasil dibuat sebagai draft.');
    }

    /**
     * Show audit report
     */
    public function show(AuditReport $report)
    {
        // Verify access (auditor who created OR assigned)
        if ($report->auditor_id !== Auth::id() && $report->assessment->assigned_auditor_id !== Auth::id()) {
            return redirect()->route('auditor.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke laporan ini.');
        }

        $report->load(['assessment.user', 'assessment.cobitItems', 'auditor']);

        return view('auditor.reports.show', compact('report'));
    }

    /**
     * Show for user (client) - only final reports
     */
    public function showForUser(Assessment $assessment)
    {
        // Verify user owns this assessment
        if ($assessment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $report = $assessment->auditReport;

        if (!$report) {
            return back()->with('error', 'Laporan audit belum tersedia.');
        }

        if ($report->status !== AuditReport::STATUS_FINAL) {
            return back()->with('error', 'Laporan audit belum final.');
        }

        $report->load(['assessment.user', 'assessment.cobitItems', 'auditor']);

        return view('user.assessments.report', compact('report'));
    }

    /**
     * Edit audit report
     */
    public function edit(AuditReport $report)
    {
        // Verify auditor owns this report
        if ($report->auditor_id !== Auth::id()) {
            return redirect()->route('auditor.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke laporan ini.');
        }

        if (!$report->canBeEdited()) {
            return back()->with('error', 'Laporan yang sudah final tidak bisa diedit.');
        }

        $report->load(['assessment.user', 'assessment.cobitItems.kategoris.levels.quisioners', 'assessment.jawabans']);

        // Check for missing COBIT items (items in assessment but not in focal points)
        $focalPoints = $report->it_process_focal_points ?? [];
        $existingProcesses = array_column($focalPoints, 'process_name');
        
        foreach ($report->assessment->items as $item) {
            $processName = $item->cobitItem->nama_item;
            
            // If this item is not in focal points yet, add it
            if (!in_array($processName, $existingProcesses)) {
                $focalPoints[] = [
                    'process_name' => $processName,
                    'rating' => $item->calculateMaturityLevel(),
                    'justification_text' => "",
                    'indicators_text' => "",
                    'is_new_addition' => true // Flag to highlight in UI maybe
                ];
            }
        }
        
        // Re-assign back to report object for the view (not saving to DB yet)
        $report->it_process_focal_points = $focalPoints;

        // --- PRE-POPULATE TEMPLATE DATA (For Reference/Missing Fields) ---
        $templateData = [
            'base_background' => "This assessment was conducted as part of the annual IT Governance review for " . ($report->assessment->user->company_name ?? 'the organization') . ". The focus is on aligning IT objectives with business goals using the COBIT 2019 framework.",
            'base_scope' => "The scope includes the evaluation of selected COBIT Management and Governance objectives. Key areas: " . $report->assessment->cobitItems->pluck('nama_item')->implode(', '),
            'base_methodology' => "The assessment followed the COBIT 2019 design guide and implementation methodology. Evidence was gathered through personnel interviews, document review, and system configuration walkthroughs.",
        ];

        return view('auditor.reports.edit', compact('report', 'templateData'));
    }

    /**
     * Update audit report
     */
    public function update(Request $request, AuditReport $report)
    {
        // Verify auditor owns this report
        if ($report->auditor_id !== Auth::id()) {
            return redirect()->route('auditor.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke laporan ini.');
        }

        if (!$report->canBeEdited()) {
            return back()->with('error', 'Laporan yang sudah final tidak bisa diedit.');
        }

        $validated = $request->validate([
            // Basic fields
            'executive_summary' => 'required|string',
            'background' => 'required|string',
            'scope' => 'required|string',
            'methodology' => 'nullable|string',
            'findings' => 'nullable|array',
            'findings.*.title' => 'required_with:findings|string|max:255',
            'findings.*.description' => 'required_with:findings|string',
            'findings.*.severity' => 'required_with:findings|in:low,medium,high,critical',
            'conclusion' => 'nullable|string',
            'overall_score' => 'nullable|integer|min:0|max:100',
            'capability_level' => 'nullable|integer|min:0|max:5',
                        // Joint Risk Assessment fields
            'report_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'sign_off_authority' => 'required|string|max:255',
            'audit_director' => 'required|string|max:255',
            'audit_director_phone' => 'nullable|string|max:50',
            'audit_manager' => 'required|string|max:255',
            'audit_manager_phone' => 'nullable|string|max:50',
            'lead_auditor_name' => 'required|string|max:255',
            'lead_auditor_phone' => 'nullable|string|max:50',
            'maturity_rating_actual' => 'nullable|string|max:50',
            'maturity_rating_target' => 'nullable|string|max:50',
            'issues_priority_a' => 'nullable|integer|min:0',
            'issues_priority_b' => 'nullable|integer|min:0',
            'issues_priority_c' => 'nullable|integer|min:0',
            'observations_optimized' => 'nullable|integer|min:0',
            'observations_managed' => 'nullable|integer|min:0',
            'observations_defined' => 'nullable|integer|min:0',
            'observations_repeatable' => 'nullable|integer|min:0',
            'observations_initial' => 'nullable|integer|min:0',
            'prior_audit_name' => 'nullable|string|max:255',
            'prior_audit_date' => 'nullable|date',
            'officer_name' => 'required|string|max:255',
            'officer_title' => 'required|string|max:255',
            'officer_response' => 'required|string',
            'officer_response_date' => 'required|date',
            'reportable_issues' => 'nullable|array',
            'reportable_issues.*.title' => 'required|string|max:255',
            'reportable_issues.*.priority' => 'required|string',
            'reportable_issues.*.condition' => 'required|string',
            'reportable_issues.*.criteria' => 'required|string',
            'reportable_issues.*.cause' => 'required|string',
            'reportable_issues.*.consequence' => 'required|string',
            'reportable_issues.*.recommendation' => 'required|string',
            'reportable_issues.*.cobit_objective' => 'required|string',
            'reportable_issues.*.due_date' => 'required|string',
            'reportable_issues.*.corrective_action' => 'required|string',
            'reportable_issues.*.response_from' => 'required|string',
            'strategic_focal_points' => 'nullable|array',
            'it_process_focal_points' => 'nullable|array',
            'control_focal_points' => 'nullable|array',
            'distribution_list_text' => 'nullable|string',
            'workflow_description' => 'nullable|string',
        ]);

        $distributionList = array_values(array_filter(array_map('trim', explode("\n", $request->distribution_list_text ?? ''))));

        $itProcessFocalPoints = [];
        if ($request->filled('it_process_focal_points')) {
            foreach ($request->it_process_focal_points as $focal) {
                if (!empty($focal['process_name'])) {
                    $focal['justification_points'] = array_values(array_filter(array_map('trim', explode("\n", $focal['justification_text'] ?? ''))));
                    $focal['indicators'] = array_values(array_filter(array_map('trim', explode("\n", $focal['indicators_text'] ?? ''))));
                    $itProcessFocalPoints[] = $focal;
                }
            }
        }

        $report->update([
            'executive_summary' => $validated['executive_summary'],
            'background' => $validated['background'],
            'scope' => $validated['scope'],
            
            // Cover Page Info
            'report_title' => $validated['report_title'],
            'company_name' => $validated['company_name'],
            'company_address' => $validated['company_address'],
            'sign_off_authority' => $validated['sign_off_authority'],
            
            // Audit Contacts
            'audit_director' => $validated['audit_director'],
            'audit_director_phone' => $validated['audit_director_phone'] ?? null,
            'audit_manager' => $validated['audit_manager'],
            'audit_manager_phone' => $validated['audit_manager_phone'] ?? null,
            'lead_auditor_name' => $validated['lead_auditor_name'],
            'lead_auditor_phone' => $validated['lead_auditor_phone'] ?? null,
            
            // Officer Response
            'officer_name' => $validated['officer_name'],
            'officer_title' => $validated['officer_title'],
            'officer_response' => $validated['officer_response'],
            'officer_response_date' => $validated['officer_response_date'],
            
            // IT Process Focal Points
            'it_process_focal_points' => $itProcessFocalPoints,
            'maturity_rating_actual' => count($itProcessFocalPoints) > 0 ? array_sum(array_column($itProcessFocalPoints, 'rating')) / count($itProcessFocalPoints) : 0,
            'maturity_rating_target' => 4.0,
        ]);

        return redirect()->route('auditor.report.show', $report)
            ->with('success', 'Laporan audit berhasil diperbarui.');
    }

    /**
     * Finalize audit report
     */
    public function finalize(AuditReport $report)
    {
        // Verify auditor owns this report
        if ($report->auditor_id !== Auth::id()) {
            return redirect()->route('auditor.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke laporan ini.');
        }

        if ($report->isFinal()) {
            return back()->with('error', 'Laporan sudah berstatus final.');
        }

        $report->update([
            'status' => AuditReport::STATUS_FINAL,
            'finalized_at' => now(),
        ]);

        return back()->with('success', 'Laporan audit berhasil ditetapkan sebagai final. User sekarang dapat melihat laporan ini.');
    }

    /**
     * Export audit report to PDF
     */
    public function exportPdf(AuditReport $report)
    {
        // Allow access for auditor OR user (if final)
        $isAuditor = $report->auditor_id === Auth::id() || $report->assessment->assigned_auditor_id === Auth::id();
        $isUser = $report->assessment->user_id === Auth::id() && $report->isFinal();

        if (!$isAuditor && !$isUser) {
            abort(403, 'Unauthorized access');
        }

        $report->load(['assessment.user', 'assessment.cobitItems', 'auditor']);

        $pdf = Pdf::loadView('auditor.reports.pdf', compact('report'));
        
        $filename = 'Laporan_Audit_' . $report->id . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Export audit report to Excel
     */
    public function exportExcel(AuditReport $report)
    {
        // Allow access for auditor OR user (if final)
        $isAuditor = $report->auditor_id === Auth::id() || $report->assessment->assigned_auditor_id === Auth::id();
        $isUser = $report->assessment->user_id === Auth::id() && $report->isFinal();

        if (!$isAuditor && !$isUser) {
            abort(403, 'Unauthorized access');
        }

        $report->load(['assessment.user', 'assessment.cobitItems', 'auditor']);

        $filename = 'Laporan_Audit_' . str_replace(' ', '_', $report->assessment->name ?? 'Assessment') . '_' . now()->format('Ymd') . '.xlsx';

        return Excel::download(new AuditReportExport($report), $filename);
    }
}

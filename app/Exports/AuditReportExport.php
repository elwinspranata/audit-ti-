<?php

namespace App\Exports;

use App\Models\AuditReport;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class AuditReportExport implements FromArray, WithStyles, WithTitle, WithColumnWidths
{
    protected $report;
    protected $rowPositions = [];

    public function __construct(AuditReport $report)
    {
        $this->report = $report;
    }

    public function title(): string
    {
        return 'Audit Report';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 40,
            'C' => 15,
            'D' => 40,
            'E' => 15,
        ];
    }

    public function array(): array
    {
        $report = $this->report;
        $issues = collect($report->reportable_issues ?? []);
        $prioA = $issues->where('priority', 'A')->count();
        $prioB = $issues->where('priority', 'B')->count();
        $prioC = $issues->where('priority', 'C')->count();

        // Calculate distribution from focal points (same as PDF)
        $stratFocal = collect($report->strategic_focal_points ?? []);
        $itFocal = collect($report->it_process_focal_points ?? []);
        $ctrlFocal = collect($report->control_focal_points ?? []);
        $allRatings = $stratFocal->pluck('capability_level')
            ->concat($itFocal->pluck('rating'))
            ->concat($ctrlFocal->pluck('rating'))
            ->filter()
            ->map(fn($v) => (int)$v);
        
        $distribution = [
            5 => $allRatings->filter(fn($v) => $v == 5)->count(),
            4 => $allRatings->filter(fn($v) => $v == 4)->count(),
            3 => $allRatings->filter(fn($v) => $v == 3)->count(),
            2 => $allRatings->filter(fn($v) => $v == 2)->count(),
            1 => $allRatings->filter(fn($v) => $v == 1)->count(),
        ];

        $rows = [];
        
        // === COVER / HEADER (Rows 1-4) ===
        $rows[] = ['COBIT 2019 COMPLIANCE', '', '', '', ''];
        $rows[] = [$report->report_title ?? 'Audit Report', '', '', '', ''];
        $rows[] = ['INTERNAL CONTROL ASSESSMENT REPORT', '', '', '', ''];
        $rows[] = [$report->company_name . ' | ' . ($report->finalized_at ? $report->finalized_at->format('d F Y') : now()->format('d F Y')), '', '', '', ''];
        $rows[] = ['', '', '', '', '']; // Spacer

        // === 1. INTERNAL AUDIT CONTACTS ===
        $this->rowPositions['sec1'] = count($rows) + 1;
        $rows[] = ['1. INTERNAL AUDIT CONTACTS', '', '', '', ''];
        $rows[] = ['Assessment Role', 'Representative Name', '', 'Contact Details', ''];
        $rows[] = ['Audit Director', $report->audit_director, '', $report->audit_director_phone ?? 'N/A', ''];
        $rows[] = ['Audit Manager', $report->audit_manager, '', $report->audit_manager_phone ?? 'N/A', ''];
        $rows[] = ['Lead Auditor', $report->lead_auditor_name, '', $report->lead_auditor_phone ?? 'N/A', ''];
        $rows[] = ['', '', '', '', '']; // Spacer

        // === 2. EXECUTIVE SUMMARY ===
        $this->rowPositions['sec2'] = count($rows) + 1;
        $rows[] = ['2. EXECUTIVE SUMMARY', '', '', '', ''];
        $rows[] = ['Overall Summary', $report->executive_summary, '', '', ''];
        $rows[] = ['Background', $report->background, '', '', ''];
        $rows[] = ['Scope', $report->scope, '', '', ''];
        $rows[] = ['', '', '', '', '']; // Spacer

        // === 3. MATURITY ASSESSMENT STATUS ===
        $this->rowPositions['sec3'] = count($rows) + 1;
        $rows[] = ['3. MATURITY ASSESSMENT STATUS', '', '', '', ''];
        $rows[] = ['Actual Maturity', number_format((float)$report->maturity_rating_actual, 1), '', 'Target Capability', number_format((float)$report->maturity_rating_target, 1)];
        $rows[] = ['', '', '', '', '']; // Sub-spacer

        // 3.1 Evaluation Distribution
        $this->rowPositions['dist'] = count($rows) + 1;
        $rows[] = ['3.1 EVALUATION DISTRIBUTION', '', '', '', ''];
        $rows[] = ['Level 5', 'Level 4', 'Level 3', 'Level 2', 'Level 1'];
        $rows[] = [$distribution[5], $distribution[4], $distribution[3], $distribution[2], $distribution[1]];
        $rows[] = ['', '', '', '', '']; // Sub-spacer

        // 3.2 Risk Summary
        $this->rowPositions['risk'] = count($rows) + 1;
        $rows[] = ['3.2 RISK SUMMARY', '', '', '', ''];
        $rows[] = ['Priority A (High)', $prioA, '', 'Priority B (Medium)', $prioB];
        $rows[] = ['Priority C (Low)', $prioC, '', '', ''];
        $rows[] = ['', '', '', '', '']; // Spacer

        // === 4. DETAILED AUDIT FINDINGS (5Cs) ===
        $this->rowPositions['sec4'] = count($rows) + 1;
        $rows[] = ['4. DETAILED AUDIT FINDINGS (5Cs)', '', '', '', ''];
        
        $this->rowPositions['findings_start'] = count($rows) + 1;
        if ($issues->isEmpty()) {
            $rows[] = ['No reportable issues were identified during this assessment cycle.', '', '', '', ''];
        } else {
            foreach ($issues as $index => $issue) {
                $rows[] = ['F.0' . ($index + 1) . ': ' . strtoupper($issue['title'] ?? 'Finding'), '', '', 'Priority ' . ($issue['priority'] ?? 'C'), ''];
                $rows[] = ['1. Condition', $issue['condition'] ?? '-', '', '', ''];
                $rows[] = ['2. Criteria', 'Ref: ' . ($issue['cobit_objective'] ?? 'N/A') . ' - ' . ($issue['criteria'] ?? '-'), '', '', ''];
                $rows[] = ['3. Cause', $issue['cause'] ?? '-', '', '', ''];
                $rows[] = ['4. Consequence', $issue['consequence'] ?? '-', '', '', ''];
                $rows[] = ['5. Recommendation', $issue['recommendation'] ?? '-', '', '', ''];
                if (!empty($issue['corrective_action'])) {
                    $rows[] = ['Management Action', 'Officer: ' . ($issue['response_from'] ?? '-') . ' | Target: ' . ($issue['due_date'] ?? '-'), '', '', ''];
                    $rows[] = ['', $issue['corrective_action'], '', '', ''];
                }
                $rows[] = ['', '', '', '', '']; // Spacer between findings
            }
        }
        $this->rowPositions['findings_end'] = count($rows);
        $rows[] = ['', '', '', '', '']; // Spacer

        // === 5. FOCAL POINT ANALYSIS ===
        $this->rowPositions['sec5'] = count($rows) + 1;
        $rows[] = ['5. FOCAL POINT ANALYSIS', '', '', '', ''];

        // 5.1 Strategic Objectives
        if (count($report->strategic_focal_points ?? []) > 0) {
            $rows[] = ['5.1 STRATEGIC OBJECTIVES', '', '', '', ''];
            $rows[] = ['Objective Domain', 'Level', '', 'Justification', ''];
            foreach ($report->strategic_focal_points as $focal) {
                $indicators = is_array($focal['indicators'] ?? null) ? implode('; ', $focal['indicators']) : '';
                $rows[] = [
                    $focal['objective_name'] ?? '-',
                    $focal['capability_level'] ?? '0',
                    '',
                    ($focal['justification'] ?? '-') . ($indicators ? ' | Indicators: ' . $indicators : ''),
                    ''
                ];
            }
            $rows[] = ['', '', '', '', ''];
        }

        // 5.2 IT Process Focal Points
        if (count($report->it_process_focal_points ?? []) > 0) {
            $rows[] = ['5.2 IT PROCESS FOCAL POINTS', '', '', '', ''];
            $rows[] = ['IT Process', 'Rating', '', 'Justification', 'Indicators'];
            foreach ($report->it_process_focal_points as $focal) {
                $justification = is_array($focal['justification_points'] ?? null) ? implode('; ', $focal['justification_points']) : ($focal['justification_text'] ?? '-');
                $indicators = is_array($focal['indicators'] ?? null) ? implode('; ', $focal['indicators']) : ($focal['indicators_text'] ?? '-');
                $rows[] = [
                    $focal['process_name'] ?? '-',
                    $focal['rating'] ?? '-',
                    '',
                    $justification,
                    $indicators
                ];
            }
            $rows[] = ['', '', '', '', ''];
        }

        // 5.3 Control Focal Points
        if (count($report->control_focal_points ?? []) > 0) {
            $rows[] = ['5.3 CONTROL FOCAL POINTS', '', '', '', ''];
            $rows[] = ['Control Objective', 'Rating', '', 'Evidence & Indicators', ''];
            foreach ($report->control_focal_points as $focal) {
                $justification = is_array($focal['justification_points'] ?? null) ? implode('; ', $focal['justification_points']) : '';
                $indicators = is_array($focal['indicators'] ?? null) ? implode('; ', $focal['indicators']) : '';
                $rows[] = [
                    $focal['control_name'] ?? '-',
                    $focal['rating'] ?? '0',
                    '',
                    ($justification ?: '-') . ($indicators ? ' | ' . $indicators : ''),
                    ''
                ];
            }
            $rows[] = ['', '', '', '', ''];
        }

        // === 6. RESPONSIBLE OFFICER RESPONSE ===
        $this->rowPositions['sec6'] = count($rows) + 1;
        $rows[] = ['6. RESPONSIBLE OFFICER OVERALL RESPONSE', '', '', '', ''];
        $rows[] = ['Officer Name', $report->officer_name, '', 'Title', $report->officer_title];
        $rows[] = ['Response Date', $report->officer_response_date ? $report->officer_response_date->format('d F Y') : now()->format('d F Y'), '', '', ''];
        $rows[] = ['Response', $report->officer_response, '', '', ''];
        $rows[] = ['', '', '', '', '']; // Spacer

        // === 7. COBIT CAPABILITY DEFINITIONS ===
        $this->rowPositions['defs'] = count($rows) + 1;
        $rows[] = ['COBIT CAPABILITY RATING DEFINITIONS', '', '', '', ''];
        $rows[] = ['0 - Incomplete', 'Proses tidak dijalankan atau dijalankan secara tidak konsisten sehingga tujuan proses tidak tercapai.', '', '', ''];
        $rows[] = ['1 - Performed', 'Proses telah dilaksanakan dan menghasilkan output dasar sesuai tujuan proses.', '', '', ''];
        $rows[] = ['2 - Managed', 'Proses telah direncanakan, dipantau, dan dikendalikan dengan dokumentasi dasar.', '', '', ''];
        $rows[] = ['3 - Established', 'Proses telah didefinisikan secara formal dan terdokumentasi dalam kebijakan standar.', '', '', ''];
        $rows[] = ['4 - Predictable', 'Proses dijalankan secara terukur dan terkendali menggunakan indikator kinerja.', '', '', ''];
        $rows[] = ['5 - Optimizing', 'Proses secara berkelanjutan ditingkatkan melalui analisis kinerja dan inovasi.', '', '', ''];
        $rows[] = ['', '', '', '', '']; // Spacer

        // === SIGNATURE SECTION ===
        $this->rowPositions['sig'] = count($rows) + 1;
        $rows[] = ['Prepared by:', '', 'Reviewed by:', '', 'Acknowledged by:'];
        $rows[] = ['', '', '', '', ''];
        $rows[] = [$report->lead_auditor_name, '', $report->audit_manager, '', $report->officer_name];
        $rows[] = ['Lead Auditor', '', 'Audit Manager', '', $report->officer_title];
        $rows[] = ['', '', '', '', ''];
        $rows[] = ['*** END OF REPORT ***', '', '', '', ''];

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        // --- GLOBAL STYLES ---
        $sheet->getStyle('A1:E' . $lastRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:E' . $lastRow)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle('A1:E' . $lastRow)->getFont()->setName('Calibri')->setSize(10);

        // --- MAIN HEADER (Rows 1-4) ---
        foreach (range(1, 4) as $row) {
            $sheet->mergeCells("A$row:E$row");
            $sheet->getRowDimension($row)->setRowHeight($row == 2 ? 30 : 20);
            $sheet->getStyle("A$row")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => ($row == 2 ? 16 : 11)],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0C1C3A']],
            ]);
        }

        // --- SECTION HEADERS ---
        $sectionKeys = ['sec1', 'sec2', 'sec3', 'dist', 'risk', 'sec4', 'sec5', 'sec6', 'defs'];
        foreach ($sectionKeys as $key) {
            if (isset($this->rowPositions[$key])) {
                $row = $this->rowPositions[$key];
                $sheet->mergeCells("A$row:E$row");
                $sheet->getRowDimension($row)->setRowHeight(22);
                $sheet->getStyle("A$row")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0C1C3A']],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
                ]);
            }
        }

        // --- SECTION 1 (Contacts) ---
        $s1 = $this->rowPositions['sec1'];
        $sheet->getStyle("A".($s1+1).":D".($s1+1))->getFont()->setBold(true);
        $sheet->getStyle("A".($s1+1).":D".($s1+1))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F3F4F6');

        // --- SECTION 2 (Summary) - Merge cells ---
        $s2 = $this->rowPositions['sec2'];
        for ($i = 1; $i <= 3; $i++) {
            $sheet->mergeCells("B".($s2+$i).":E".($s2+$i));
            $sheet->getStyle("A".($s2+$i))->getFont()->setBold(true);
        }

        // --- SECTION 3 (Maturity) ---
        $s3 = $this->rowPositions['sec3'];
        $sheet->getStyle("A".($s3+1).":E".($s3+1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A".($s3+1).":E".($s3+1))->getFont()->setBold(true)->setSize(14);

        // Distribution header
        if (isset($this->rowPositions['dist'])) {
            $sd = $this->rowPositions['dist'];
            $sheet->getStyle("A".($sd+1).":E".($sd+1))->getFont()->setBold(true);
            $sheet->getStyle("A".($sd+1).":E".($sd+1))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F3F4F6');
            $sheet->getStyle("A".($sd+2).":E".($sd+2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A".($sd+2).":E".($sd+2))->getFont()->setBold(true)->setSize(16);
        }

        // Risk summary styling
        if (isset($this->rowPositions['risk'])) {
            $sr = $this->rowPositions['risk'];
            $sheet->getStyle("A".($sr+1))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FEE2E2');
            $sheet->getStyle("B".($sr+1))->getFont()->setColor(new Color('B91C1C'))->setBold(true);
            $sheet->getStyle("D".($sr+1))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFEDD5');
            $sheet->getStyle("E".($sr+1))->getFont()->setColor(new Color('EA580C'))->setBold(true);
            $sheet->getStyle("A".($sr+2))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E0F2FE');
            $sheet->getStyle("B".($sr+2))->getFont()->setColor(new Color('0369A1'))->setBold(true);
        }

        // --- DEFINITIONS ---
        if (isset($this->rowPositions['defs'])) {
            $sd = $this->rowPositions['defs'];
            for ($i = 1; $i <= 6; $i++) {
                $sheet->mergeCells("B".($sd+$i).":E".($sd+$i));
                $sheet->getStyle("A".($sd+$i))->getFont()->setBold(true);
            }
        }

        // --- SIGNATURE SECTION ---
        if (isset($this->rowPositions['sig'])) {
            $ss = $this->rowPositions['sig'];
            $sheet->getStyle("A$ss:E$ss")->getFont()->setBold(true);
            $sheet->getStyle("A$ss:E$ss")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A".($ss+2).":E".($ss+2))->getFont()->setBold(true);
            $sheet->getStyle("A".($ss+2).":E".($ss+2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A".($ss+3).":E".($ss+3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            
            // End of report
            $sheet->mergeCells("A".($ss+5).":E".($ss+5));
            $sheet->getStyle("A".($ss+5))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A".($ss+5))->getFont()->setBold(true)->setSize(12);
        }

        // --- FINAL: Borders ---
        $sheet->getStyle("A6:E$lastRow")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        
        // Clean up spacer rows
        $data = $this->array();
        foreach ($data as $idx => $cells) {
            $r = $idx + 1;
            if (empty($cells[0]) && empty($cells[1]) && empty($cells[2]) && empty($cells[3]) && empty($cells[4])) {
                $sheet->getStyle("A$r:E$r")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_NONE);
                $sheet->getRowDimension($r)->setRowHeight(8);
            }
        }

        return [];
    }
}

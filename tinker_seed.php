$assessment = App\Models\Assessment::with(['user', 'cobitItems'])->find(4);
if ($assessment->auditReport) { $assessment->auditReport->delete(); }
$report = App\Models\AuditReport::create([
    'assessment_id' => $assessment->id, 
    'auditor_id' => $assessment->assigned_auditor_id, 
    'report_title' => 'JOINT RISK ASSESSMENT: ASSESSMENT DESEMBER 2025', 
    'company_name' => 'PT. TEKNOLOGI INDONESIA MAJU', 
    'company_address' => 'Gedung Cyber 2, Lt. 15, Jl. HR Rasuna Said, Jakarta', 
    'sign_off_authority' => 'Budi Santoso - Direktur TI',
    'audit_director' => 'Dr. Ir. Heru Prasetyo', 
    'audit_manager' => 'Sinta Nurmala, CISA', 
    'lead_auditor_name' => 'Andi Wijaya', 
    'executive_summary' => "Secara keseluruhan, tata kelola TI di PT. Teknologi Indonesia Maju sudah berjalan dengan baik namun memerlukan peningkatan pada aspek dokumentasi prosedur operasional. Tingkat kematangan rata-rata saat ini berada pada Level 3 (Established).", 
    'background' => 'Audit ini dilakukan untuk memastikan kepatuhan terhadap standar tata kelola TI perusahaan tahun 2025.', 
    'scope' => 'Ruang lingkup mencakup domain APO01, APO02, BAI03, dan DSS01.', 
    'officer_name' => 'Rahmat Hidayat', 
    'officer_title' => 'IT Manager', 
    'officer_response' => 'Kami menerima hasil temuan ini dan berkomitmen untuk menindaklanjutinya dalam 3 bulan ke depan.', 
    'officer_response_date' => now(), 
    'it_process_focal_points' => [
        [
            'process_name' => 'APO01 - Manage the I&T Management Framework', 
            'rating' => 3,
            'justification_text' => "- Prosedur sudah terdefinisi secara tertulis.\n- Implementasi konsisten di seluruh unit kerja.",
            'indicators_text' => "- Dokumen Framework TI\n- Absensi rapat koordinasi TI",
            'justification_points' => ["Prosedur sudah terdefinisi secara tertulis.", "Implementasi konsisten di seluruh unit kerja."],
            'indicators' => ["Dokumen Framework TI", "Absensi rapat koordinasi TI"]
        ],
        [
            'process_name' => 'DSS01 - Manage Operations', 
            'rating' => 2,
            'justification_text' => "- Aktivitas operasional berjalan lancar.\n- Pencatatan log sistem masih dilakukan secara manual.",
            'indicators_text' => "- Log harian operasional\n- Laporan uptime server",
            'justification_points' => ["Aktivitas operasional berjalan lancar.", "Pencatatan log sistem masih dilakukan secara manual."],
            'indicators' => ["Log harian operasional", "Laporan uptime server"]
        ]
    ], 
    'status' => 'draft'
]);
echo "URL: " . route('auditor.report.show', $report->id) . "\n";

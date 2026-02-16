<?php
use App\Models\AuditReport;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$report = AuditReport::find(2);

if (!$report) {
    echo "Report 2 not found.\n";
    exit(1);
}

$report->update([
    'report_title' => 'IT Governance & Security Assessment 2024',
    'company_name' => 'Global FinTech Solutions',
    'sign_off_authority' => 'Chief Risk Officer',
    'company_address' => 'Capital Tower, 25th Floor, Jakarta Central District',
    'audit_director' => 'Dr. Robert Wijaya, CIA',
    'audit_director_phone' => '+62 811 123 4567',
    'audit_manager' => 'Siti Aminah, CISA',
    'audit_manager_phone' => '+62 812 234 5678',
    'lead_auditor_name' => 'Budi Santoso, CRISC',
    'lead_auditor_phone' => '+62 813 345 6789',
    'executive_summary' => "Asesmen tata kelola TI pada Global FinTech Solutions menunjukkan tingkat kematangan rata-rata 3.2. Meskipun infrastruktur dasar sangat kuat, terdapat peluang peningkatan pada standarisasi manajemen perubahan dan dokumentasi kontrol keamanan siber.",
    'background' => "Asesmen ini dilakukan sebagai bagian dari audit tahunan siklus 2024 untuk memastikan kepatuhan terhadap standar industri finansial dan Kerangka Kerja COBIT 2019.",
    'scope' => "Ruang lingkup meliputi Domain APO (Align, Plan, and Organize), BAI (Build, Acquire, and Implement), dan DSS (Deliver, Service, and Support) pada unit operasional Jakarta.",
    'officer_name' => 'Irwan Pratama',
    'officer_title' => 'Head of IT Infrastructure',
    'officer_response_date' => '2024-05-15',
    'officer_response' => "Manajemen menyetujui hasil asesmen ini. Kami berkomitmen untuk memperkuat area yang teridentifikasi, terutama pada optimasi proses manajemen insiden dan integrasi sistem keamanan.",
    'maturity_rating_actual' => 3.2,
    'maturity_rating_target' => 4.0,
    'observations_optimized' => 1,
    'observations_managed' => 4,
    'observations_defined' => 8,
    'observations_repeatable' => 3,
    'observations_initial' => 1,
    'it_process_focal_points' => [
        [
            'process_name' => 'APO12 - Managed Risk',
            'rating' => 3,
            'justification_points' => [
                'Kebijakan manajemen risiko sudah ada',
                'Identifikasi risiko TI rutin dilakukan',
                'Respon risiko belum sepenuhnya terintegrasi antar departemen'
            ],
            'indicators' => [
                'Dokumen Risk Register',
                'Laporan Mitigasi Kuartalan'
            ]
        ],
        [
            'process_name' => 'DSS05 - Managed Security Services',
            'rating' => 4,
            'justification_points' => [
                'Firewall dan IDS/IPS beroperasi dengan baik',
                'Monitoring keamanan 24/7 melalui SOC',
                'Patch management sudah terotomatisasi'
            ],
            'indicators' => [
                'Daily Security Incident Report',
                'Vulnerability Assessment Results'
            ]
        ],
        [
            'process_name' => 'BAI06 - Managed IT Changes',
            'rating' => 2,
            'justification_points' => [
                'Prosedur perubahan belum sepenuhnya terdokumentasi',
                'Beberapa perubahan dilakukan tanpa melalui CAB (Change Advisory Board)',
                'Audit trail perubahan sulit dilacak'
            ],
            'indicators' => [
                'Log Perubahan Sistem',
                'Risalah Rapat CAB'
            ]
        ]
    ]
]);

echo "Report 2 has been populated successfully.\n";

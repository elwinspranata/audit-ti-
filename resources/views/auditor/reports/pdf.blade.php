<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $report->report_title }}</title>
    <style>
        /* 
           COBIT REPORT TEMPLATE - PRECISION ALIGNMENT
           Refactored for Clean Pagination and Professional Spacing
        */
        @page {
            margin: 60pt 40pt 50pt 40pt; 
            size: A4;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #000;
            line-height: 1.4;
            font-size: 10pt;
            background-color: #fff;
        }

        /* Fixed Header - Repeats on every page except cover */
        .page-header {
            position: fixed;
            top: -40pt;
            left: 0;
            right: 0;
            height: 30pt;
            border-bottom: 0.5pt solid #eee;
            z-index: 1000;
        }

        /* Fixed Footer - Repeats on every page */
        .page-footer {
            position: fixed;
            bottom: -30pt;
            left: 0;
            right: 0;
            height: 30pt;
            border-top: 1pt solid #ccc;
            padding-top: 8pt;
            z-index: 1000;
        }

        /* Cover Page Logic */
        .cover-page {
            text-align: center;
            margin-top: -20pt; /* Pull up slightly to fit A4 */
            position: relative;
            /* Height removed to prevent blank pages */
        }

        .cover-header-mask {
            position: absolute;
            top: -60pt;
            left: -40pt;
            right: -40pt;
            height: 60pt;
            background: #fff;
            z-index: 1500;
        }

        .header-table, .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            font-size: 9pt;
            font-weight: bold;
            color: #666;
            vertical-align: top;
        }

        .footer-table td {
            font-size: 8pt;
            color: #999;
        }

        .logo-container {
            height: 80pt;
            margin-bottom: 30pt;
        }

        .logo-img {
            max-height: 80pt;
            width: auto;
        }

        .border-bottom-thick {
            border-bottom: 2pt solid #000;
            padding-bottom: 5pt;
            width: 100%;
            margin-bottom: 20pt;
        }

        .cover-title {
            font-size: 22pt;
            font-weight: bold;
            margin: 0;
        }

        .assessment-name {
            font-size: 16pt;
            font-weight: bold;
            margin: 60pt 0;
        }

        .report-mgmt-title {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
        }

        .cover-footer-box {
            margin-top: 150pt;
            text-align: left;
            width: 100%;
            border-top: 0.5pt solid #eee; /* Light divider */
            padding-top: 10pt;
        }

        .confidential-box {
            margin-top: 20pt;
            text-align: left;
            font-size: 9pt;
            font-style: italic;
        }

        /* CONTENT STYLES */
        .black-bar {
            background-color: #000;
            color: #fff;
            padding: 6pt 0;
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            width: 100%;
            margin-top: 15pt;
            margin-bottom: 5pt;
        }

        .black-bar:first-child {
            margin-top: 0;
        }

        .bordered-box {
            border: 1pt solid #000;
            padding: 12pt;
            margin-bottom: 20pt;
        }

        .box-title {
            font-size: 11pt;
            font-weight: bold;
            font-style: italic;
            margin-bottom: 8pt;
        }

        .box-body {
            font-size: 10pt;
            line-height: 1.5;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10pt;
        }

        .data-table th, .data-table td {
            border: 0.5pt solid #000;
            padding: 6pt;
            vertical-align: top;
        }

        .bg-grey {
            background-color: #e0e0e0;
        }

        .th-cell {
            font-size: 10pt;
            font-weight: bold;
            font-style: italic;
            text-align: center;
        }

        .td-cell {
            font-size: 8pt;
        }

        .text-bold { font-weight: bold; }
        .text-italic { font-style: italic; }
        .text-right { text-align: right; }
        .td-center { text-align: center; }

        .spacer { height: 20pt; }

        ul { margin: 0; padding-left: 15pt; }
        li { margin-bottom: 2pt; }

    </style>
</head>
<body>

    <!-- FIXED HEADER (Repeats on content pages) -->
    <div class="page-header">
        <table class="header-table">
            <tr>
                <td style="text-align: left;">Joint Risk Assessment: {{ $report->assessment->name }}</td>
                <td style="text-align: right;">{{ $report->company_name }}</td>
            </tr>
        </table>
    </div>

    <!-- FIXED FOOTER -->
    <div class="page-footer">
        <table class="footer-table">
            <tr>
                <td class="text-italic">{{ $report->assessment->user->department ?? 'Internal Audit' }}</td>
                <td class="text-right text-italic">Confidential - {{ $report->company_name }}</td>
            </tr>
        </table>
    </div>

    <!-- PAGE 1: COVER -->
    <div class="cover-page">
        {{-- Mask header/footer for page 1 --}}
        <div style="position: absolute; top: -60pt; left: -40pt; right: -40pt; height: 100pt; background: #fff; z-index: 1500;"></div>
        <div style="position: absolute; bottom: -50pt; left: -40pt; right: -40pt; height: 100pt; background: #fff; z-index: 1500;"></div>
        
        <div style="position: relative; z-index: 1600;">
            <div class="logo-container">
            @php
                $logoPath = public_path('assets/icon/cobit.png');
                if (!file_exists($logoPath)) {
                    $logoPath = public_path('assets/cobit_logo.png');
                }
            @endphp

            @if(file_exists($logoPath))
                <img src="{{ $logoPath }}" class="logo-img">
            @else
                <div style="font-size: 24pt; font-weight: bold;">COBIT</div>
                <div style="font-size: 10pt; color: #666;">Assessment Report</div>
            @endif
        </div>

        <div class="border-bottom-thick" style="margin-top: 30pt;">
            <h1 class="cover-title">Joint Risk Assessment</h1>
        </div>

        <div class="assessment-name">
            {{ strtoupper($report->assessment->name ?? 'COBIT ASSESSMENT') }}
        </div>

        <div class="border-bottom-thick">
            <h1 class="report-mgmt-title">Report to Management</h1>
        </div>

        @if($report->sign_off_authority)
        <div style="margin-top: 10pt; font-size: 11pt; font-weight: bold; font-style: italic; color: #333;">
            Sign-off Authority: {{ $report->sign_off_authority }}
        </div>
        @endif

        <div class="cover-footer-box">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 60%; vertical-align: top;">
                        <div style="font-weight: bold; font-size: 10pt; margin-bottom: 8pt;">Internal Audit Contacts</div>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="width: 80pt; font-weight: bold; font-size: 9pt; padding: 1pt 0;">Audit Director</td>
                                <td style="padding-left: 8pt; font-size: 9pt;">{{ $report->audit_director }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; font-size: 9pt; padding: 1pt 0;">Audit Manager</td>
                                <td style="padding-left: 8pt; font-size: 9pt;">{{ $report->audit_manager }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; font-size: 9pt; padding: 1pt 0;">Lead Auditor</td>
                                <td style="padding-left: 8pt; font-size: 9pt;">{{ $report->lead_auditor_name }}</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 40%; vertical-align: top; text-align: right;">
                        <div style="font-weight: bold; font-size: 10pt; margin-bottom: 2pt;">{{ $report->company_name }}</div>
                        <div style="font-size: 9pt; margin-bottom: 2pt;">{{ $report->assessment->user->department ?? 'Internal Audit Department' }}</div>
                        <div style="font-size: 9pt;">{{ $report->company_address }}</div>
                    </td>
                </tr>
            </table>
        </div>

            <div class="confidential-box">
                Confidential<br>
                {{ $report->company_name }}
            </div>
        </div> {{-- end relative z-index div --}}
    </div> {{-- end cover-page div --}}

    <!-- PAGE 2: EXECUTIVE SUMMARY -->
    <div class="black-bar" style="page-break-before: always;">Executive Summary</div>
    <div class="bordered-box">
        <div class="box-title">Overall Summary of Assessment Results</div>
        <div class="box-body">
            {!! nl2br(e($report->executive_summary)) !!}
        </div>

        <div class="spacer"></div>

        <div class="box-title">Background & Scope</div>
        <div class="box-body">
            {!! nl2br(e($report->background)) !!}
            <br><br>
            {!! nl2br(e($report->scope)) !!}
        </div>
    </div>

    <div class="black-bar">Responsible Officer Overall Response</div>
    <div class="bordered-box">
        @if($report->officer_name)
            <div class="box-title" style="font-style: normal;">
                Response from {{ $report->officer_name }}, {{ $report->officer_title }} 
                @if($report->officer_response_date)
                    ({{ \Carbon\Carbon::parse($report->officer_response_date)->format('d/m/Y') }}):
                @endif
            </div>
        @endif
        <div class="box-body">
            @if($report->officer_response)
                {!! nl2br(e($report->officer_response)) !!}
            @else
                <span style="color: #666;">&lt;Insert Response Here&gt;</span>
            @endif
        </div>
    </div>

    @php
        $itFocal = collect($report->it_process_focal_points ?? []);
        $allRatings = $itFocal->pluck('rating')->filter()->map(fn($v) => (int)$v);
        $distribution = [
            5 => $allRatings->filter(fn($v) => $v == 5)->count(),
            4 => $allRatings->filter(fn($v) => $v == 4)->count(),
            3 => $allRatings->filter(fn($v) => $v == 3)->count(),
            2 => $allRatings->filter(fn($v) => $v == 2)->count(),
            1 => $allRatings->filter(fn($v) => $v == 1)->count(),
        ];
    @endphp

    <!-- PAGE 3: FOCAL POINTS -->
    <div class="black-bar" style="page-break-before: always;">Evaluation Distribution</div>
    <table class="data-table">
        <thead>
            <tr class="bg-grey">
                <th class="th-cell">Level 5</th>
                <th class="th-cell">Level 4</th>
                <th class="th-cell">Level 3</th>
                <th class="th-cell">Level 2</th>
                <th class="th-cell">Level 1</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-bold td-center" style="font-size: 10pt;">
                <td>{{ $distribution[5] }}</td>
                <td>{{ $distribution[4] }}</td>
                <td>{{ $distribution[3] }}</td>
                <td>{{ $distribution[2] }}</td>
                <td>{{ $distribution[1] }}</td>
            </tr>
        </tbody>
    </table>

    <div class="spacer"></div>

    <div class="black-bar" style="page-break-before: auto;">IT Process Focal Points</div>
    <table class="data-table">
        <thead>
            <tr class="bg-grey">
                <th class="th-cell" style="width: 25%;">IT Process</th>
                <th class="th-cell" style="width: 12%;">COBIT<br>Rating</th>
                <th class="th-cell" style="width: 38%;">Rating Justification</th>
                <th class="th-cell" style="width: 25%;">Indicators/Metrics</th>
            </tr>
        </thead>
        <tbody>
            @forelse($itFocal as $focal)
            <tr>
                <td class="td-cell text-bold">{{ $focal['process_name'] ?? '-' }}</td>
                <td class="td-cell td-center text-bold" style="font-size: 9pt;">{{ $focal['rating'] ?? '0' }}</td>
                <td class="td-cell">
                    @if(!empty($focal['justification_points']) && is_array($focal['justification_points']))
                        <ul>
                            @foreach($focal['justification_points'] as $point)
                                <li>{{ $point }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $focal['justification_text'] ?? '-' }}
                    @endif
                </td>
                <td class="td-cell">
                    @if(!empty($focal['indicators']) && is_array($focal['indicators']))
                        <ul>
                            @foreach($focal['indicators'] as $ind)
                                <li>{{ $ind }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $focal['indicators_text'] ?? '-' }}
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="td-center">No focal points analyzed.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="spacer"></div>

    <div style="page-break-inside: avoid;">
        <div class="black-bar">COBIT Capability Rating & Issue Priority Definitions</div>
        <div style="text-align: center; font-weight: bold; margin: 10pt 0;">Legend For Generic COBIT Management Guidelines Capability Ratings</div>
        
        <table class="data-table">
            <tbody>
                <tr class="bg-grey">
                    <th class="th-cell" style="width: 20%;">COBIT Capability Ratings</th>
                    <th class="th-cell" style="width: 80%;">Definition</th>
                </tr>
                <tr><td class="td-cell text-bold">0 - Incomplete</td><td class="td-cell" style="font-size: 7.5pt;">Proses tidak dijalankan atau dijalankan secara tidak konsisten sehingga tujuan proses tidak tercapai. Tidak terdapat bukti pelaksanaan proses yang memadai, dan aktivitas yang dilakukan bersifat sporadis tanpa struktur yang jelas. Organisasi belum menunjukkan pendekatan pengelolaan proses yang dapat diandalkan.</td></tr>
                <tr><td class="td-cell text-bold">1 - Performed</td><td class="td-cell" style="font-size: 7.5pt;">Proses telah dilaksanakan dan menghasilkan output dasar sesuai tujuan proses. Terdapat bukti bahwa aktivitas proses dilakukan, namun pelaksanaannya masih bersifat individual dan belum terkelola secara formal. Dokumentasi, pengendalian, dan konsistensi antar pelaksana belum tersedia secara memadai.</td></tr>
                <tr><td class="td-cell text-bold">2 - Managed</td><td class="td-cell" style="font-size: 7.5pt;">Proses telah direncanakan, dipantau, dan dikendalikan. Organisasi telah menetapkan tanggung jawab, mengelola sumber daya, serta menyediakan dokumentasi dasar. Meskipun demikian, penerapan proses masih terbatas pada unit atau kondisi tertentu dan belum sepenuhnya terstandarisasi di seluruh organisasi.</td></tr>
                <tr><td class="td-cell text-bold">3 - Established</td><td class="td-cell" style="font-size: 7.5pt;">Proses telah didefinisikan secara formal dan terdokumentasi dalam kebijakan atau prosedur standar. Proses diterapkan secara konsisten di seluruh organisasi dan dipahami oleh pihak-pihak terkait. Pendekatan pengelolaan proses sudah terstruktur dan selaras dengan praktik yang ditetapkan.</td></tr>
                <tr><td class="td-cell text-bold">4 - Predictable</td><td class="td-cell" style="font-size: 7.5pt;">Proses dijalankan secara terukur dan terkendali menggunakan indikator kinerja yang telah ditetapkan. Data kinerja digunakan untuk memantau, mengevaluasi, dan mengendalikan proses sehingga hasilnya dapat diprediksi. Variasi kinerja dapat diidentifikasi dan dikelola secara sistematis.</td></tr>
                <tr><td class="td-cell text-bold">5 - Optimizing</td><td class="td-cell" style="font-size: 7.5pt;">Proses secara berkelanjutan ditingkatkan melalui analisis kinerja, pembelajaran organisasi, dan penerapan inovasi. Organisasi secara proaktif mengidentifikasi peluang perbaikan dan mengoptimalkan proses untuk meningkatkan efektivitas, efisiensi, dan nilai bisnis. Pendekatan pengelolaan proses telah berorientasi pada perbaikan berkelanjutan.</td></tr>
            </tbody>
        </table>
    </div>

</body>
</html>

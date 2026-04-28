{{-- resources/views/admin/progress/pdf_template.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Progress Kuesioner</title>
    <style>
        @page {
            margin: 25px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
        }
        .header, .footer {
            width: 100%;
            text-align: center;
            position: fixed;
        }
        .header {
            top: 0px;
        }
        .footer {
            bottom: 0px;
            font-size: 9px;
            color: #777;
        }
        .pagenum:before {
            content: "Halaman " counter(page);
        }
        .main {
            margin-top: 50px;
            margin-bottom: 40px;
        }
        .report-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .report-subtitle {
            text-align: center;
            font-size: 14px;
            margin-bottom: 25px;
            color: #555;
        }
        .user-info {
            margin-bottom: 20px;
            border: 1px solid #eee;
            padding: 10px;
            border-radius: 5px;
        }
        .user-info p {
            margin: 0;
            padding: 3px 0;
        }
        .progress-summary {
            margin-bottom: 20px;
            text-align: right;
            font-size: 12px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th, .data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }
        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
            color: #fff;
        }
        .status-answered {
            background-color: #28a745; /* Green */
        }
        .status-pending {
            background-color: #6c757d; /* Gray */
        }
    </style>
</head>
<body>
    <div class="header">
        <p style="font-size:14px; font-weight:bold; margin:0;">LAPORAN PROGRESS KUESIONER</p>
    </div>

    <div class="footer">
        Dicetak pada {{ date('d F Y, H:i') }} | <span class="pagenum"></span>
    </div>

    <div class="main">
        <div class="user-info">
            <p><strong>Nama User:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>

        <div class="progress-summary">
            <strong>Progress Penyelesaian: {{ round($progress) }}%</strong>
            ({{ $userAnswers->count() }} / {{ $allQuestions->count() }} Pertanyaan)
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <th>Item Pertanyaan / Kuesioner</th>
                    <th style="width: 15%; text-align: center;">Jawaban</th>
                    <th style="width: 20%; text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allQuestions as $question)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $question->pertanyaan ?? 'Nama Pertanyaan Kosong' }}</td> {{-- Ganti 'pertanyaan' jika nama kolomnya berbeda --}}
                    <td style="text-align: center;">
                        @if(isset($userAnswers[$question->id]))
                            <strong>{{ $userAnswers[$question->id] }}</strong>
                        @else
                            -
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if(isset($userAnswers[$question->id]))
                            <span class="status-badge status-answered">Sudah Dijawab</span>
                        @else
                            <span class="status-badge status-pending">Belum Dijawab</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data pertanyaan yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>

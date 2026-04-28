<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Assessment Berubah</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            margin: 10px 0;
        }
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        .status-verified {
            background-color: #cce5ff;
            color: #004085;
        }
        .status-default {
            background-color: #e2e3e5;
            color: #383d41;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            margin-top: 20px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔔 Status Assessment Berubah</h1>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $assessment->user->name }}</strong>!</p>
            
            <p>Status assessment Anda telah berubah:</p>
            
            <div class="info-box">
                <p><strong>Nama Assessment:</strong> {{ $assessment->name ?? 'Assessment #' . $assessment->id }}</p>
                <p><strong>Status Sebelumnya:</strong> 
                    @php
                        $prevLabel = match($previousStatus) {
                            'pending_submission' => 'Draft',
                            'pending_approval' => 'Menunggu Persetujuan',
                            'approved' => 'Disetujui',
                            'in_progress' => 'Sedang Dikerjakan',
                            'completed' => 'Selesai',
                            'verified' => 'Terverifikasi',
                            'rejected' => 'Ditolak',
                            default => 'Unknown',
                        };
                    @endphp
                    {{ $prevLabel }}
                </p>
                <p><strong>Status Baru:</strong> 
                    <span class="status-badge 
                        @if($assessment->status === 'approved') status-approved
                        @elseif($assessment->status === 'rejected') status-rejected
                        @elseif($assessment->status === 'verified') status-verified
                        @else status-default
                        @endif
                    ">
                        {{ $assessment->status_label }}
                    </span>
                </p>
            </div>

            @if($assessment->status === 'approved')
                <p>🎉 Selamat! Assessment Anda telah disetujui oleh admin. Anda sekarang dapat mulai mengisi kuesioner.</p>
            @elseif($assessment->status === 'rejected')
                <p>⚠️ Mohon maaf, assessment Anda ditolak.</p>
                @if($assessment->rejection_reason)
                    <p><strong>Alasan:</strong> {{ $assessment->rejection_reason }}</p>
                @endif
            @elseif($assessment->status === 'verified')
                <p>✅ Assessment Anda telah diverifikasi oleh auditor. Anda dapat melihat laporan capability level.</p>
            @endif

            @if($assessment->admin_notes)
                <div class="info-box">
                    <p><strong>Catatan Admin:</strong></p>
                    <p>{{ $assessment->admin_notes }}</p>
                </div>
            @endif

            <center>
                <a href="{{ url('/assessments/' . $assessment->id) }}" class="btn">Lihat Assessment</a>
            </center>
        </div>
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem Audit TI.</p>
            <p>&copy; {{ date('Y') }} Audit TI System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

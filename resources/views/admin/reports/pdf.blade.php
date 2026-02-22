<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Capability Level Report - {{ $user->name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #6366f1;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #6366f1;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0 0;
        }
        .user-info {
            background: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .user-info h2 {
            margin: 0 0 10px;
            color: #374151;
            font-size: 18px;
        }
        .user-info table {
            width: 100%;
        }
        .user-info td {
            padding: 3px 0;
        }
        .user-info td:first-child {
            font-weight: bold;
            width: 150px;
        }
        .summary-cards {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }
        .summary-card {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            padding: 15px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }
        .summary-card .value {
            font-size: 28px;
            font-weight: bold;
            color: #6366f1;
        }
        .summary-card .label {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table.data-table th,
        table.data-table td {
            border: 1px solid #e5e7eb;
            padding: 10px;
            text-align: left;
        }
        table.data-table th {
            background: #6366f1;
            color: white;
            font-weight: bold;
        }
        table.data-table tr:nth-child(even) {
            background: #f9fafb;
        }
        .level-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 11px;
        }
        .level-0 { background: #e5e7eb; color: #6b7280; }
        .level-1 { background: #fee2e2; color: #dc2626; }
        .level-2 { background: #ffedd5; color: #ea580c; }
        .level-3 { background: #fef9c3; color: #ca8a04; }
        .level-4 { background: #dbeafe; color: #2563eb; }
        .level-5 { background: #dcfce7; color: #16a34a; }
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #9ca3af;
            font-size: 10px;
        }
        .level-visual {
            display: inline-block;
        }
        .level-dot {
            display: inline-block;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            text-align: center;
            line-height: 16px;
            font-size: 9px;
            font-weight: bold;
            margin-right: 2px;
        }
        .level-dot.active {
            background: #6366f1;
            color: white;
        }
        .level-dot.inactive {
            background: #e5e7eb;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Capability Level Report</h1>
        <p>Laporan Hasil Assessment Proses TI</p>
    </div>
    
    <div class="user-info">
        <h2>Informasi User/Organisasi</h2>
        <table>
            <tr>
                <td>Nama</td>
                <td>: {{ $user->name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: {{ $user->email }}</td>
            </tr>
            <tr>
                <td>Perusahaan</td>
                <td>: {{ $user->company_name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal Registrasi</td>
                <td>: {{ $summaryStats['registrationDate'] }}</td>
            </tr>
            <tr>
                <td>Berakhir</td>
                <td>: {{ $summaryStats['subscriptionEnd'] }}</td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: {{ $tanggalCetak }}</td>
            </tr>
        </table>
    </div>
    
    <div class="summary-cards">
        <div class="summary-card">
            <div class="value">{{ $summaryStats['totalProses'] }}</div>
            <div class="label">Total Proses TI</div>
        </div>
        <div class="summary-card">
            <div class="value">{{ $summaryStats['completedProses'] }}</div>
            <div class="label">Proses dengan Progress</div>
        </div>
        <div class="summary-card">
            <div class="value">{{ $summaryStats['avgCapability'] }}</div>
            <div class="label">Rata-rata Capability</div>
        </div>
    </div>
    
    <h3>Detail Capability Level per Proses TI</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Proses TI</th>
                <th style="width: 120px; text-align: center;">Capability Level</th>
                <th style="width: 120px; text-align: center;">Visual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($capabilityData as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['nama_item'] }}</td>
                    <td style="text-align: center;">
                        <span class="level-badge level-{{ $item['capability_level'] }}">
                            Level {{ $item['capability_level'] }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <div class="level-visual">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="level-dot {{ $i <= $item['capability_level'] ? 'active' : 'inactive' }}">{{ $i }}</span>
                            @endfor
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh Sistem Audit TI</p>
        <p>{{ $tanggalCetak }}</p>
    </div>
</body>
</html>

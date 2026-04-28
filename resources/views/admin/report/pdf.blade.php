<!DOCTYPE html>
<html>
<head>
    <title>Capability Level Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .meta {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .level-badge {
            font-weight: bold;
            color: #000;
        }
    </style>
</head>
<body>
    <h1>Capability Level Report</h1>
    
    <div class="meta">
        <p><strong>User/Organisasi:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Tanggal Report:</strong> {{ date('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>COBIT Process</th>
                <th>Deskripsi</th>
                <th style="text-align: center;">Capability Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $data)
            <tr>
                <td>{{ $data['process'] }}</td>
                <td>{{ $data['description'] ?? '-' }}</td>
                <td style="text-align: center;">
                    <span class="level-badge">{{ $data['level'] }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

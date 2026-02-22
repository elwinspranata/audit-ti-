<!DOCTYPE html>
<html>
<head>
    <title>Capability Level Report</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4e73df; color: white; }
        h2, h4 { text-align: center; }
        .header { margin-bottom: 30px; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>Capability Level Report</h2>
        <h4>User: {{ $user->name }} ({{ $user->email }})</h4>
        <p>Date Generated: {{ date('Y-m-d H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Process (Cobit Item)</th>
                <th>Capability Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach($labels as $key => $label)
            <tr>
                <td>{{ $label }}</td>
                <td style="text-align: center;">{{ $data[$key] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

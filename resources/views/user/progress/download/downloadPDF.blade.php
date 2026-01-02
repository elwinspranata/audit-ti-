<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Progres Audit - {{ $user->name }}</title>
    {{-- Styling CSS disematkan langsung (inline) untuk kompatibilitas terbaik dengan domPDF --}}
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        h1,
        h2,
        h3 {
            margin: 0;
            padding: 0;
            font-weight: bold;
        }

        h1 {
            font-size: 22px;
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .user-info {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 5px;
        }

        .user-info p {
            margin: 4px 0;
        }

        .item-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
            /* Mencegah item terpotong antar halaman */
        }

        .item-header {
            background-color: #e9e9e9;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .item-header h2 {
            font-size: 16px;
            display: inline-block;
        }

        .item-header .percentage-badge {
            font-size: 12px;
            font-weight: bold;
            background-color: #333;
            color: #fff;
            padding: 4px 8px;
            border-radius: 10px;
            float: right;
        }

        .kategori-section {
            margin-top: 15px;
            padding-left: 15px;
        }

        .kategori-header h3 {
            font-size: 14px;
            border-left: 4px solid #555;
            padding-left: 10px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: #f2f2f2;
        }

        .progress-bar-container {
            background-color: #ddd;
            border-radius: 10px;
            width: 100%;
            height: 15px;
        }

        .progress-bar {
            background-color: #4CAF50;
            height: 15px;
            border-radius: 10px;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }

        .pagenum:before {
            content: counter(page);
        }
    </style>
</head>

<body>
    {{-- Footer dengan nomor halaman otomatis --}}
    <div class="footer">
        Laporan Progres Kuesioner | Halaman <span class="pagenum"></span>
    </div>

    <div class="container">
        <h1>Laporan Progres Audit</h1>

        {{-- Informasi Pengguna dan Tanggal Cetak --}}
        <div class="user-info">
            <p><strong>Nama Pengguna:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Tanggal Cetak:</strong> {{ $tanggalCetak }}</p>
        </div>

        {{-- Loop untuk setiap Cobit Item --}}
        @forelse ($progressData as $cobitItem)
            <div class="item-section">
                <div class="item-header">
                    @php
                        $itemPercentage =
                            $cobitItem['total_levels_in_item'] > 0
                                ? round(
                                    ($cobitItem['completed_levels_in_item'] / $cobitItem['total_levels_in_item']) * 100,
                                )
                                : 0;
                    @endphp
                    <span class="percentage-badge">{{ $itemPercentage }}%</span>
                    <h2>{{ $cobitItem['nama_item'] }}</h2>
                </div>

                {{-- Loop untuk setiap Kategori dalam Item --}}
                @forelse ($cobitItem['kategoris'] as $kategori)
                    <div class="kategori-section">
                        <div class="kategori-header">
                            <h3>{{ $kategori['nama_kategori'] }}</h3>
                        </div>

                        @if (empty($kategori['levels']))
                            <p><em>Tidak ada level dalam kategori ini.</em></p>
                        @else
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 35%;">Nama Level</th>
                                        <th style="width: 50%;">Progres</th>
                                        <th class="text-right" style="width: 15%;">Persen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Loop untuk setiap Level dalam Kategori --}}
                                    @foreach ($kategori['levels'] as $level)
                                        <tr>
                                            <td>{{ $level['nama_level'] }}</td>
                                            <td>
                                                <div class="progress-bar-container">
                                                    <div class="progress-bar"
                                                        style="width: {{ $level['percentage'] }}%"></div>
                                                </div>
                                            </td>
                                            <td class="text-right">{{ $level['percentage'] }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                @empty
                    <p style="padding-left: 15px; margin-top: 10px;"><em>Tidak ada kategori untuk item ini.</em></p>
                @endforelse
            </div>
        @empty
            <p style="text-align: center; margin-top: 50px;">Tidak ada data progres untuk ditampilkan.</p>
        @endforelse
    </div>
</body>

</html>

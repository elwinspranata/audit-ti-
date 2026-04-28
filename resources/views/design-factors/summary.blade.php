<x-app-layout>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="min-h-screen py-8 bg-gray-100">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Design Factor Canvas</h1>
                <p class="mt-2 text-gray-600">Tailored Governance System based on aggregated Design Factors (1-10)</p>
            </div>

            <!-- Navigation Tabs -->
            <div class="flex flex-wrap justify-center gap-2 mb-8 hide-on-print">
                @php
                    $mainTabs = [
                        'DF1' => 'DF1: Enterprise Strategy',
                        'DF2' => 'DF2: Enterprise Goals',
                        'DF3' => 'DF3: Risk Profile',
                        'DF4' => 'DF4: IT-Related Issues',
                    ];
                @endphp

                @foreach($mainTabs as $tabType => $tabLabel)
                    @php
                        $isAccessible = isset($progress[$tabType]) && $progress[$tabType]['accessible'];
                        $isCompleted  = isset($progress[$tabType]) && $progress[$tabType]['completed'];
                    @endphp
                    <a href="{{ $isAccessible ? route('design-factors.index', $tabType) : '#' }}"
                        class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2 bg-white text-gray-600 hover:bg-gray-200"
                        {{ !$isAccessible ? 'onclick="return false;"' : '' }}>
                        {{ $tabLabel }}
                        @if($isCompleted)<span class="text-lg">✅</span>@endif
                    </a>
                @endforeach

                {{-- Summary Tab (Active) --}}
                <a href="#"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2 bg-green-600 text-white shadow-lg">
                    Summary
                </a>

                {{-- DF5 Tab --}}
                @php
                    $df5Accessible = isset($progress['DF5']) && $progress['DF5']['accessible'];
                    $df5Completed  = isset($progress['DF5']) && $progress['DF5']['completed'];
                @endphp
                <a href="{{ $df5Accessible ? route('design-factors.index', 'DF5') : '#' }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
                    {{ $df5Accessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60' }}"
                    {{ !$df5Accessible ? 'onclick="return false;"' : '' }}>
                    DF5: Governance Obj.
                    @if($df5Completed)<span class="text-lg">✅</span>@endif
                </a>

                @php
                    $otherTabs = [
                        'DF6'  => 'DF6: Threat Landscape',
                        'DF7'  => 'DF7: Importance of Role of IT',
                        'DF8'  => 'DF8: Sourcing Model',
                        'DF9'  => 'DF9: IT Implementation',
                        'DF10' => 'DF10: Tech Adoption',
                    ];
                @endphp
                @foreach($otherTabs as $tabType => $tabLabel)
                    @php
                        $isAccessible = isset($progress[$tabType]) && $progress[$tabType]['accessible'];
                        $isCompleted  = isset($progress[$tabType]) && $progress[$tabType]['completed'];
                    @endphp
                    <a href="{{ $isAccessible ? route('design-factors.index', $tabType) : '#' }}"
                        class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
                        {{ $isAccessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60' }}"
                        {{ !$isAccessible ? 'onclick="return false;"' : '' }}>
                        {{ $tabLabel }}
                        @if($isCompleted)<span class="text-lg">✅</span>@endif
                    </a>
                @endforeach
            </div>

            <!-- ============================================================ -->
            <!-- MAIN SECTION: Initial Design Governance System (Phase 1)     -->
            <!-- ============================================================ -->
            <div class="mb-8 overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">

                <!-- Header -->
                <div class="p-6 border-b border-gray-200 bg-slate-50">
                    <h2 class="text-xl font-bold text-gray-800">Initial Design Governance System (Phase 1)</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Aggregated importance scores from Design Factors 1–4 &mdash;
                        <em>Initial Scope: Governance/Management Objectives Score</em>
                    </p>
                </div>

                @if(!empty($results))

                <!-- Formula Info Bar -->
                <div class="px-6 py-3 bg-blue-50 border-b border-blue-100 flex flex-wrap gap-6 text-sm text-blue-800">
                    <span>
                        <strong>Formula:</strong>
                        IFERROR(IF(F≥0, MROUND(TRUNC(100·F/denom), 5), MROUND(TRUNC(100·F/denom), −5)), 0)
                    </span>
                    <span><strong>F50 (MAX sum):</strong> {{ number_format($f50, 2) }}</span>
                    <span><strong>F51 (|MIN sum|):</strong> {{ number_format($f51, 2) }}</span>
                    <span><strong>Denominator MAX(F50,F51):</strong> {{ number_format($denominator, 2) }}</span>
                </div>

                <!-- Bar Chart -->
                <div class="p-6">
                    <div class="relative print-chart-container" style="height: 1100px;">
                        <canvas id="summaryCanvas"></canvas>
                    </div>
                </div>

                <!-- Data Table (collapsed by default) -->
                <div class="px-6 pb-6">
                    <details id="detailTablePhase1" class="group hide-on-print">
                        <summary class="cursor-pointer inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-gray-900 select-none">
                            <svg class="w-4 h-4 transition-transform group-open:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Tampilkan Tabel Detail (40 GMO)
                        </summary>

                        <div class="mt-4 overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-700 text-white">
                                    <tr>
                                        <th class="px-4 py-2 text-left font-semibold">Code</th>
                                        <th class="px-4 py-2 text-right font-semibold">DF1 RI</th>
                                        <th class="px-4 py-2 text-right font-semibold">DF2 RI</th>
                                        <th class="px-4 py-2 text-right font-semibold">DF3 RI</th>
                                        <th class="px-4 py-2 text-right font-semibold">DF4 RI</th>
                                        <th class="px-4 py-2 text-right font-semibold">F (Sum)</th>
                                        <th class="px-4 py-2 text-right font-semibold">Score (G)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @php
                                        $df1Map = collect($df1Data)->keyBy('code');
                                        $df2Map = collect($df2Data)->keyBy('code');
                                        $df3Map = collect($df3Data)->keyBy('code');
                                        $df4Map = collect($df4Data)->keyBy('code');
                                    @endphp
                                    @foreach($results as $code => $score)
                                        @php
                                            $ri1  = $df1Map[$code]['relative_importance'] ?? 0;
                                            $ri2  = $df2Map[$code]['relative_importance'] ?? 0;
                                            $ri3  = $df3Map[$code]['relative_importance'] ?? 0;
                                            $ri4  = $df4Map[$code]['relative_importance'] ?? 0;
                                            $rawF = $rawSums[$code] ?? ($ri1 + $ri2 + $ri3 + $ri4);
                                            $rowBg = $score > 0 ? 'bg-green-50' : ($score < 0 ? 'bg-red-50' : '');
                                        @endphp
                                        <tr class="{{ $rowBg }}">
                                            <td class="px-4 py-1.5 font-bold text-gray-700">{{ $code }}</td>
                                            <td class="px-4 py-1.5 text-right {{ $ri1 > 0 ? 'text-green-700' : ($ri1 < 0 ? 'text-red-600' : 'text-gray-500') }}">{{ $ri1 > 0 ? '+' : '' }}{{ $ri1 }}</td>
                                            <td class="px-4 py-1.5 text-right {{ $ri2 > 0 ? 'text-green-700' : ($ri2 < 0 ? 'text-red-600' : 'text-gray-500') }}">{{ $ri2 > 0 ? '+' : '' }}{{ $ri2 }}</td>
                                            <td class="px-4 py-1.5 text-right {{ $ri3 > 0 ? 'text-green-700' : ($ri3 < 0 ? 'text-red-600' : 'text-gray-500') }}">{{ $ri3 > 0 ? '+' : '' }}{{ $ri3 }}</td>
                                            <td class="px-4 py-1.5 text-right {{ $ri4 > 0 ? 'text-green-700' : ($ri4 < 0 ? 'text-red-600' : 'text-gray-500') }}">{{ $ri4 > 0 ? '+' : '' }}{{ $ri4 }}</td>
                                            <td class="px-4 py-1.5 text-right font-mono text-gray-700">{{ number_format($rawF, 2) }}</td>
                                            <td class="px-4 py-1.5 text-right font-extrabold {{ $score > 0 ? 'text-green-700' : ($score < 0 ? 'text-red-600' : 'text-gray-500') }}">
                                                {{ $score > 0 ? '+' : '' }}{{ $score }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </details>
                </div>

                @else
                <div class="p-12 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2a4 4 0 014-4h2m4 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="font-semibold">Belum ada data.</p>
                    <p class="text-sm mt-1">Silakan simpan DF1–DF4 terlebih dahulu untuk melihat summary.</p>
                </div>
                @endif
            </div>

            <!-- ============================================================ -->
            <!-- RADAR CHARTS SECTION  (DF1 – DF4)                           -->
            <!-- ============================================================ -->
            <div class="mb-8">
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-bold text-gray-800">Radar Charts</h2>
                    <p class="mt-2 text-sm text-gray-500">Resulting Governance/Management Objectives Importance per Design Factor</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach([
                        ['id'=>'df1RadarChart','key'=>'df1Data','title'=>'Design Factor 1','sub'=>'Enterprise Strategy',  'color'=>'147,51,234'],
                        ['id'=>'df2RadarChart','key'=>'df2Data','title'=>'Design Factor 2','sub'=>'Enterprise Goals',    'color'=>'16,185,129'],
                        ['id'=>'df3RadarChart','key'=>'df3Data','title'=>'Design Factor 3','sub'=>'Risk Profile',         'color'=>'245,158,11'],
                        ['id'=>'df4RadarChart','key'=>'df4Data','title'=>'Design Factor 4','sub'=>'IT-Related Issues',   'color'=>'239,68,68'],
                    ] as $r)
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="p-4 border-b border-gray-200 bg-slate-50">
                            <h3 class="text-lg font-bold text-gray-800">
                                {{ $r['title'] }}
                                <span class="text-sm font-normal italic text-gray-500">{{ $r['sub'] }}</span>
                            </h3>
                            <p class="text-xs text-gray-500 hide-on-print">Resulting GMO Importance</p>
                        </div>
                        <div class="p-6">
                            <div class="relative print-chart-container" style="height: 500px;">
                                <canvas id="{{ $r['id'] }}"></canvas>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- LOCK & CONTINUE BUTTONS                                       -->
            <!-- ============================================================ -->
            <div class="mt-8 mb-8 hide-on-print">
                <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                    <div class="text-center">
                        <h3 class="mb-4 text-xl font-bold text-gray-800">Finalisasi Summary</h3>
                        <p class="mb-6 text-sm text-gray-600">
                            @if($isLocked)
                                DF1-DF4 telah dikunci. Anda dapat melanjutkan ke DF5.
                            @else
                                Kunci DF1-DF4 untuk melanjutkan ke DF5. Setelah dikunci, data tidak dapat diubah lagi.
                            @endif
                        </p>

                        <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                            @if(!$isLocked)
                                <form id="lockForm" action="{{ route('design-factors.lock-summary') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="button" onclick="confirmLock()"
                                        class="px-8 py-3 text-white transition-all bg-red-600 rounded-lg shadow-md hover:bg-red-700 hover:shadow-lg">
                                        <i class="mr-2 fas fa-lock"></i>Simpan dan Kunci DF1-DF4
                                    </button>
                                </form>
                                <button disabled
                                    class="px-8 py-3 text-gray-400 transition-all bg-gray-300 rounded-lg shadow-md cursor-not-allowed opacity-60">
                                    <i class="mr-2 fas fa-arrow-right"></i>Lanjut ke DF5
                                </button>
                            @else
                                <button disabled
                                    class="px-8 py-3 text-gray-400 transition-all bg-gray-300 rounded-lg shadow-md cursor-not-allowed opacity-60">
                                    <i class="mr-2 fas fa-lock"></i>DF1-DF4 Sudah Dikunci
                                </button>
                                <a href="{{ route('design-factors.index', 'DF5') }}"
                                    class="inline-block px-8 py-3 text-white transition-all bg-green-600 rounded-lg shadow-md hover:bg-green-700 hover:shadow-lg">
                                    <i class="mr-2 fas fa-arrow-right"></i>Lanjut ke DF5
                                </a>
                            @endif
                            <button type="button" id="btnDownloadSummary" onclick="downloadSummary()"
                                class="px-8 py-3 text-white transition-all bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg">
                                <i class="mr-2 fas fa-download"></i>Download Summary
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /max-w-7xl -->
    </div><!-- /min-h-screen -->

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // ----------------------------------------------------------------
        // 1. SUMMARY BAR CHART
        //    Values = Initial Scope Score (column G of Excel canvas)
        //    Formula: IFERROR(IF(F>=0, MROUND(TRUNC(100*F/denom),5),
        //                        MROUND(TRUNC(100*F/denom),-5)), 0)
        // ----------------------------------------------------------------
        const results  = @json($results);   // { code: score, ... }
        const rawSums  = @json($rawSums);   // { code: rawSum, ... }
        const f50      = @json($f50);
        const f51      = @json($f51);
        const denom    = @json($denominator);

        const gmoLabels = Object.keys(results);
        const scores    = Object.values(results);

        const summaryCanvas = document.getElementById('summaryCanvas');
        if (summaryCanvas && gmoLabels.length > 0) {
            const ctx = summaryCanvas.getContext('2d');

            // Colors: positive = teal, negative = pink/red (like Excel)
            const bgColors     = scores.map(v => v >= 0 ? 'rgba(75,192,192,0.65)'  : 'rgba(255,99,132,0.65)');
            const borderColors = scores.map(v => v >= 0 ? 'rgba(20,184,166,1)'     : 'rgba(239,68,68,1)');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: gmoLabels,
                    datasets: [{
                        label: 'Initial Scope Score',
                        data: scores,
                        backgroundColor: bgColors,
                        borderColor: borderColors,
                        borderWidth: 1,
                        borderSkipped: false,
                    }]
                },
                options: {
                    animation: false, // Fix prevent chart bars from disappearing on window.print
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',    // horizontal bars
                    scales: {
                        x: {
                            min: -100,
                            max: 100,
                            grid: { color: '#e5e7eb' },
                            ticks: { stepSize: 25, font: { size: 11 } },
                            title: {
                                display: true,
                                text: 'Initial Scope Score (G)',
                                font: { size: 12, weight: 'bold' }
                            }
                        },
                        y: {
                            grid: { display: false },
                            ticks: { autoSkip: false, font: { size: 10, weight: '600' } }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                title: ctx => ctx[0].label,
                                label: ctx => {
                                    const code   = ctx.label;
                                    const score  = ctx.raw;
                                    const rawF   = rawSums[code] !== undefined ? rawSums[code].toFixed(2) : '-';
                                    return [
                                        ` Score (G): ${score > 0 ? '+' : ''}${score}`,
                                        ` Raw Sum (F): ${rawF}`,
                                        ` F50: ${f50}  |  F51: ${f51}  |  Denom: ${denom}`,
                                    ];
                                }
                            }
                        }
                    }
                }
            });
        } else if (summaryCanvas) {
            summaryCanvas.parentElement.innerHTML =
                '<div class="flex items-center justify-center h-full text-gray-400">' +
                '<p>Belum ada data. Silakan simpan DF1–DF4 terlebih dahulu.</p></div>';
        }

        // ----------------------------------------------------------------
        // 2. RADAR CHARTS (DF1–DF4)
        // ----------------------------------------------------------------
        const radarSets = [
            { id: 'df1RadarChart', data: @json($df1Data), title: 'DF1: Enterprise Strategy',  bg: 'rgba(147,51,234,0.2)',  border: 'rgba(147,51,234,1)'  },
            { id: 'df2RadarChart', data: @json($df2Data), title: 'DF2: Enterprise Goals',     bg: 'rgba(16,185,129,0.2)', border: 'rgba(16,185,129,1)' },
            { id: 'df3RadarChart', data: @json($df3Data), title: 'DF3: Risk Profile',          bg: 'rgba(245,158,11,0.2)', border: 'rgba(245,158,11,1)' },
            { id: 'df4RadarChart', data: @json($df4Data), title: 'DF4: IT-Related Issues',    bg: 'rgba(239,68,68,0.2)',  border: 'rgba(239,68,68,1)'  },
        ];

        radarSets.forEach(function (set) {
            const canvas = document.getElementById(set.id);
            if (!canvas) return;

            if (!set.data || set.data.length === 0) {
                canvas.parentElement.innerHTML =
                    '<div class="flex items-center justify-center h-full text-gray-400"><p>Data tidak tersedia.</p></div>';
                return;
            }

            const ctx    = canvas.getContext('2d');
            const labels = set.data.map(item => item.code);
            // Shift by +100 so radar range 0–200 maps to -100…+100
            const values = set.data.map(item => (parseFloat(item.relative_importance) || 0) + 100);

            new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: set.title,
                        data: values,
                        backgroundColor: set.bg,
                        borderColor: set.border,
                        borderWidth: 2,
                        pointBackgroundColor: set.border,
                        pointBorderColor: '#fff',
                        pointRadius: 2,
                        pointHoverRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            min: 0, max: 200,
                            ticks: {
                                stepSize: 50,
                                font: { size: 9 },
                                backdropColor: 'transparent',
                                callback: v => v - 100
                            },
                            grid:        { color: 'rgba(200,200,200,0.3)' },
                            pointLabels: { font: { size: 8 }, color: '#374151' }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => {
                                    const actual = ctx.raw - 100;
                                    return `${ctx.label}: ${actual > 0 ? '+' : ''}${actual}`;
                                }
                            }
                        }
                    }
                }
            });
        });

    }); // DOMContentLoaded

    // ----------------------------------------------------------------
    // Download Summary: buka window bersih, chart jadi gambar PNG (2x)
    // ----------------------------------------------------------------
    window.downloadSummary = function () {
        const btn = document.getElementById('btnDownloadSummary');
        if (btn) { btn.disabled = true; btn.innerHTML = '<i class="mr-2 fas fa-spinner fa-spin"></i>Menyiapkan...'; }

        // Helper: capture canvas at 2x resolution → gambar tajam
        function captureCanvas(canvas) {
            if (!canvas) return '';
            const scale = 2;
            const offscreen = document.createElement('canvas');
            offscreen.width  = canvas.width  * scale;
            offscreen.height = canvas.height * scale;
            const ctx = offscreen.getContext('2d');
            ctx.scale(scale, scale);
            ctx.drawImage(canvas, 0, 0);
            return offscreen.toDataURL('image/png');
        }

        const canvasSummary = document.getElementById('summaryCanvas');
        const canvasDf1     = document.getElementById('df1RadarChart');
        const canvasDf2     = document.getElementById('df2RadarChart');
        const canvasDf3     = document.getElementById('df3RadarChart');
        const canvasDf4     = document.getElementById('df4RadarChart');

        if (!canvasSummary) {
            alert('Chart belum siap. Tunggu sebentar lalu coba lagi.');
            if (btn) { btn.disabled = false; btn.innerHTML = '<i class="mr-2 fas fa-download"></i>Download Summary'; }
            return;
        }

        // Ambil dimensi asli bar chart untuk aspect ratio yang benar
        const summaryW = canvasSummary.width;
        const summaryH = canvasSummary.height;

        const imgSummary = captureCanvas(canvasSummary);
        const imgDf1     = captureCanvas(canvasDf1);
        const imgDf2     = captureCanvas(canvasDf2);
        const imgDf3     = captureCanvas(canvasDf3);
        const imgDf4     = captureCanvas(canvasDf4);

        const f50Val   = @json($f50);
        const f51Val   = @json($f51);
        const denomVal = @json($denominator);

        // Hitung max lebar chart agar tidak overflow: A4 portrait content ≈ 180mm
        // Jika chart lebih tinggi dari lebar, batasi max-height 220mm
        const aspectRatio = summaryW / summaryH;
        // Jika aspect ratio < 1.2, chart relatif tinggi → pakai max-height
        const chartStyle = aspectRatio < 1.5
            ? 'width:100%;height:auto;max-height:220mm;object-fit:contain;object-position:left;display:block;'
            : 'width:100%;height:auto;display:block;';

        const radarCards = [
            { img: imgDf1, title: 'Design Factor 1', sub: 'Enterprise Strategy' },
            { img: imgDf2, title: 'Design Factor 2', sub: 'Enterprise Goals' },
            { img: imgDf3, title: 'Design Factor 3', sub: 'Risk Profile' },
            { img: imgDf4, title: 'Design Factor 4', sub: 'IT-Related Issues' },
        ];

        const radarCardsHTML = radarCards.map(c => `
            <div style="border:1px solid #e5e7eb;border-radius:6px;overflow:hidden;break-inside:avoid;">
                <div style="padding:8px 12px;background:#f8fafc;border-bottom:1px solid #e5e7eb;">
                    <strong style="font-size:13px;color:#1f2937;">${c.title}</strong>
                    <span style="font-size:11px;color:#6b7280;font-style:italic;"> ${c.sub}</span>
                </div>
                <img src="${c.img}" alt="${c.title}" style="width:100%;height:auto;max-height:130mm;object-fit:contain;display:block;">
            </div>`).join('');

        const printHTML = `<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Design Factor Canvas – Initial Scope Summary</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #1f2937;
            background: #fff;
        }
        /* Screen: tampilkan seperti halaman biasa sebelum print */
        @media screen {
            body { background: #f3f4f6; padding: 20px; }
            .wrapper { max-width: 780px; margin: 0 auto; background: white; padding: 24px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
        }
        @media print {
            @page { size: A4 portrait; margin: 15mm; }
            body { background: white; }
            .wrapper { padding: 0; }
        }
        h1 { font-size: 20px; font-weight: 700; }
        h2 { font-size: 15px; font-weight: 700; }
        .page-header { text-align: center; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 2px solid #e5e7eb; }
        .page-header p { font-size: 12px; color: #6b7280; margin-top: 4px; }
        .section { border: 1px solid #e5e7eb; border-radius: 6px; margin-bottom: 16px; overflow: hidden; break-inside: avoid; }
        .section-header { padding: 10px 16px; background: #f8fafc; border-bottom: 1px solid #e5e7eb; }
        .section-header p { font-size: 11px; color: #6b7280; margin-top: 2px; }
        .formula-bar { padding: 8px 16px; background: #eff6ff; border-bottom: 1px solid #dbeafe;
            display: flex; flex-wrap: wrap; gap: 12px; font-size: 11px; color: #1e40af; }
        .chart-wrap { padding: 10px 16px; }
        .radar-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; padding: 12px 16px; }
        .radar-section { break-before: auto; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="page-header">
            <h1>Design Factor Canvas</h1>
            <p>Tailored Governance System based on aggregated Design Factors (1–4)</p>
        </div>

        <div class="section">
            <div class="section-header">
                <h2>Initial Design Governance System (Phase 1)</h2>
                <p>Aggregated importance scores from Design Factors 1–4 &mdash; <em>Initial Scope: Governance/Management Objectives Score</em></p>
            </div>
            <div class="formula-bar">
                <span><strong>Formula:</strong> IFERROR(IF(F&ge;0, MROUND(TRUNC(100&middot;F/denom),5), MROUND(TRUNC(100&middot;F/denom),&minus;5)), 0)</span>
                <span><strong>F50 (MAX sum):</strong> ${Number(f50Val).toFixed(2)}</span>
                <span><strong>F51 (|MIN sum|):</strong> ${Number(f51Val).toFixed(2)}</span>
                <span><strong>Denominator MAX(F50,F51):</strong> ${Number(denomVal).toFixed(2)}</span>
            </div>
            <div class="chart-wrap">
                <img src="${imgSummary}" alt="Initial Scope Bar Chart" style="${chartStyle}">
            </div>
        </div>

        <div class="section radar-section">
            <div class="section-header">
                <h2>Radar Charts</h2>
                <p>Resulting Governance/Management Objectives Importance per Design Factor</p>
            </div>
            <div class="radar-grid">${radarCardsHTML}</div>
        </div>
    </div>

    <script>
        // Tunggu semua gambar selesai load baru print
        window.addEventListener('load', function() {
            const imgs = document.querySelectorAll('img');
            let loaded = 0;
            function tryPrint() {
                loaded++;
                if (loaded >= imgs.length) {
                    setTimeout(function() { window.print(); }, 200);
                }
            }
            if (imgs.length === 0) {
                setTimeout(function() { window.print(); }, 200);
            } else {
                imgs.forEach(function(img) {
                    if (img.complete) { tryPrint(); }
                    else { img.addEventListener('load', tryPrint); img.addEventListener('error', tryPrint); }
                });
            }
        });
    <\/script>
</body>
</html>`;

        const pw = window.open('', '_blank', 'width=900,height=1100');
        if (!pw) {
            alert('Pop-up diblokir browser. Izinkan pop-up untuk situs ini lalu coba lagi.');
            if (btn) { btn.disabled = false; btn.innerHTML = '<i class="mr-2 fas fa-download"></i>Download Summary'; }
            return;
        }
        pw.document.write(printHTML);
        pw.document.close();

        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="mr-2 fas fa-download"></i>Download Summary';
        }
    };

    // ----------------------------------------------------------------
    // Confirmation dialog for locking DF1-DF4
    // ----------------------------------------------------------------
    window.confirmLock = function () {
        Swal.fire({
            title: 'Kunci DF1-DF4?',
            html: `<p class="text-gray-700">Anda akan mengunci <strong>DF1, DF2, DF3, dan DF4</strong> secara permanen.</p>
                   <p class="mt-2 text-red-600"><strong>Peringatan:</strong> Setelah dikunci, data tidak dapat diubah lagi!</p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor:  '#6b7280',
            confirmButtonText:  'Ya, Kunci Sekarang!',
            cancelButtonText:   'Batal',
            reverseButtons: true
        }).then(result => {
            if (result.isConfirmed) {
                document.getElementById('lockForm').submit();
            }
        });
    };
    </script>
    @endpush
</x-app-layout>
<x-app-layout>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="min-h-screen py-8 bg-gray-100">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Design Factor Canvas</h1>
                <p class="mt-2 text-gray-600">Tailored Governance System based on aggregated Design Factors (1&ndash;10)</p>
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
                        @if($isCompleted)<span class="text-lg">&#9989;</span>@endif
                    </a>
                @endforeach

                {{-- Summary DF1-DF4 Tab --}}
                @php
                    $summaryAccessible = isset($progress['Summary']) && $progress['Summary']['accessible'];
                @endphp
                <a href="{{ $summaryAccessible ? route('design-factors.summary') : '#' }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
                    {{ $summaryAccessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60' }}"
                    {{ !$summaryAccessible ? 'onclick="return false;"' : '' }}>
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
                    @if($df5Completed)<span class="text-lg">&#9989;</span>@endif
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
                        @if($isCompleted)<span class="text-lg">&#9989;</span>@endif
                    </a>
                @endforeach

                {{-- Summary DF5-DF10 Tab (Active) --}}
                <a href="#"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2 bg-blue-600 text-white shadow-lg">
                    &#128202; Summary
                </a>
            </div>

            <!-- ============================================================ -->
            <!-- MAIN SECTION: Final Design Governance System (Phase 2)       -->
            <!-- ============================================================ -->
            <div class="mb-8 overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">

                <!-- Header -->
                <div class="p-6 border-b border-gray-200 bg-slate-50">
                    <h2 class="text-xl font-bold text-gray-800">Final Design Governance System (Phase 1 + 2)</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Aggregated importance scores from Design Factors 1&ndash;10 &mdash;
                        <em>Refined Scope: Governance/Management Objectives Score</em>
                    </p>
                </div>

                @if(!empty($results))

                <!-- Formula Info Bar -->
                <div class="px-6 py-3 bg-blue-50 border-b border-blue-100 flex flex-wrap gap-6 text-sm text-blue-800">
                    <span>
                        <strong>Formula:</strong>
                        IFERROR(IF(P&gt;0, MROUND(TRUNC(100&middot;P/denom), 5), MROUND(TRUNC(100&middot;P/denom), &minus;5)), 0)
                    </span>
                    <span><strong>P50 (MAX sum):</strong> {{ number_format($p50Refined, 2) }}</span>
                    <span><strong>P51 (|MIN sum|):</strong> {{ number_format($p51Refined, 2) }}</span>
                    <span><strong>Denominator MAX(P50,P51):</strong> {{ number_format($denomRefined, 2) }}</span>
                </div>

                <!-- Bar Chart -->
                <div class="p-6">
                    <div class="relative print-chart-container" style="height: 1100px;">
                        <canvas id="summaryCanvas"></canvas>
                    </div>
                </div>

                <!-- Data Table (collapsed by default) expandable -->
                <div class="px-6 pb-6">
                    <details id="detailTablePhase2" class="group hide-on-print">
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
                                        <th class="px-4 py-2 text-right font-semibold">DF1&ndash;DF4<br><span class="font-normal text-xs">(Initial RI)</span></th>
                                        <th class="px-4 py-2 text-right font-semibold">DF5 RI</th>
                                        <th class="px-4 py-2 text-right font-semibold">DF6 RI</th>
                                        <th class="px-4 py-2 text-right font-semibold">DF7 RI</th>
                                        <th class="px-4 py-2 text-right font-semibold">DF8 RI</th>
                                        <th class="px-4 py-2 text-right font-semibold">DF9 RI</th>
                                        <th class="px-4 py-2 text-right font-semibold">DF10 RI</th>
                                        <th class="px-4 py-2 text-right font-semibold">P (Sum)</th>
                                        <th class="px-4 py-2 text-right font-semibold">Score (Q)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @php
                                        // Build per-DF item maps
                                        $dfRiMaps = [];
                                        foreach (['DF5','DF6','DF7','DF8','DF9','DF10'] as $dfKey) {
                                            $varName = strtolower(str_replace('DF', 'df', $dfKey)) . 'Data';
                                            $dfRiMaps[$dfKey] = collect($$varName ?? [])->keyBy('code');
                                        }

                                        // Initial scope raw sums (DF1-DF4 sum of RI = rawSumsDF10 - DF5..DF10 contributions)
                                        // We'll derive DF1-DF4 sum from totalRaw - sum(DF5..DF10 RI)
                                    @endphp
                                    @foreach($results as $code => $score)
                                        @php
                                            $ri5  = (float) ($dfRiMaps['DF5'][$code]['relative_importance']  ?? 0);
                                            $ri6  = (float) ($dfRiMaps['DF6'][$code]['relative_importance']  ?? 0);
                                            $ri7  = (float) ($dfRiMaps['DF7'][$code]['relative_importance']  ?? 0);
                                            $ri8  = (float) ($dfRiMaps['DF8'][$code]['relative_importance']  ?? 0);
                                            $ri9  = (float) ($dfRiMaps['DF9'][$code]['relative_importance']  ?? 0);
                                            $ri10 = (float) ($dfRiMaps['DF10'][$code]['relative_importance'] ?? 0);
                                            $rawP = (float) ($rawSumsDF10[$code] ?? 0);
                                            $ri14 = $rawP - $ri5 - $ri6 - $ri7 - $ri8 - $ri9 - $ri10; // DF1-4 sum
                                            $rowBg = $score > 0 ? 'bg-green-50' : ($score < 0 ? 'bg-red-50' : '');

                                            $fmt  = fn($v) => ($v > 0 ? '+' : '') . number_format($v, 0);
                                            $fmtF = fn($v) => ($v > 0 ? '+' : '') . number_format($v, 2);
                                        @endphp
                                        <tr class="{{ $rowBg }}">
                                            <td class="px-4 py-1.5 font-bold text-gray-700">{{ $code }}</td>
                                            <td class="px-4 py-1.5 text-right {{ $ri14 > 0 ? 'text-green-700' : ($ri14 < 0 ? 'text-red-600' : 'text-gray-500') }}">
                                                {{ $fmtF($ri14) }}
                                            </td>
                                            <td class="px-4 py-1.5 text-right {{ $ri5 > 0 ? 'text-green-700' : ($ri5 < 0 ? 'text-red-600' : 'text-gray-500') }}">{{ $fmtF($ri5) }}</td>
                                            <td class="px-4 py-1.5 text-right {{ $ri6 > 0 ? 'text-green-700' : ($ri6 < 0 ? 'text-red-600' : 'text-gray-500') }}">{{ $fmtF($ri6) }}</td>
                                            <td class="px-4 py-1.5 text-right {{ $ri7 > 0 ? 'text-green-700' : ($ri7 < 0 ? 'text-red-600' : 'text-gray-500') }}">{{ $fmtF($ri7) }}</td>
                                            <td class="px-4 py-1.5 text-right {{ $ri8 > 0 ? 'text-green-700' : ($ri8 < 0 ? 'text-red-600' : 'text-gray-500') }}">{{ $fmtF($ri8) }}</td>
                                            <td class="px-4 py-1.5 text-right {{ $ri9 > 0 ? 'text-green-700' : ($ri9 < 0 ? 'text-red-600' : 'text-gray-500') }}">{{ $fmtF($ri9) }}</td>
                                            <td class="px-4 py-1.5 text-right {{ $ri10 > 0 ? 'text-green-700' : ($ri10 < 0 ? 'text-red-600' : 'text-gray-500') }}">{{ $fmtF($ri10) }}</td>
                                            <td class="px-4 py-1.5 text-right font-mono text-gray-700">{{ number_format($rawP, 2) }}</td>
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
                    <p class="text-sm mt-1">Silakan simpan DF1&ndash;DF10 terlebih dahulu untuk melihat summary.</p>
                </div>
                @endif
            </div>

            <!-- ============================================================ -->
            <!-- RADAR CHARTS SECTION (DF5 &ndash; DF10)                            -->
            <!-- ============================================================ -->
            <div class="mb-8">
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-bold text-gray-800">Radar Charts Design Factors 5&ndash;10</h2>
                    <p class="mt-2 text-sm text-gray-500">Resulting Governance/Management Objectives Importance per Design Factor</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach([
                        ['id'=>'df5RadarChart', 'key'=>'df5Data',  'title'=>'Design Factor 5',  'sub'=>'Threat Landscape',        'color'=>'59,130,246'],
                        ['id'=>'df6RadarChart', 'key'=>'df6Data',  'title'=>'Design Factor 6',  'sub'=>'Compliance Requirements', 'color'=>'14,165,233'],
                        ['id'=>'df7RadarChart', 'key'=>'df7Data',  'title'=>'Design Factor 7',  'sub'=>'Role of IT',              'color'=>'6,182,212'],
                        ['id'=>'df8RadarChart', 'key'=>'df8Data',  'title'=>'Design Factor 8',  'sub'=>'Sourcing Model',          'color'=>'20,184,166'],
                        ['id'=>'df9RadarChart', 'key'=>'df9Data',  'title'=>'Design Factor 9',  'sub'=>'IT Implementation',       'color'=>'16,185,129'],
                        ['id'=>'df10RadarChart','key'=>'df10Data', 'title'=>'Design Factor 10', 'sub'=>'Technology Adoption',     'color'=>'34,197,94'],
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
            <!-- LOCK & DOWNLOAD BUTTONS                                      -->
            <!-- ============================================================ -->
            <div class="mt-8 mb-8 hide-on-print">
                <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                    <div class="text-center">
                        <h3 class="mb-4 text-xl font-bold text-gray-800">Finalisasi Summary DF5-DF10</h3>
                        <p class="mb-6 text-sm text-gray-600">
                            @if($isLocked)
                                DF5-DF10 telah dikunci. Penilaian Canvas Anda telah selesai.
                            @else
                                Kunci DF5-DF10 untuk menyelesaikan penilaian. Setelah dikunci, data tidak dapat diubah lagi.
                            @endif
                        </p>

                        <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                            @if(!$isLocked)
                                <form id="lockForm" action="{{ route('design-factors.lock-summary-df510') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="button" onclick="confirmLock()"
                                        class="px-8 py-3 text-white transition-all bg-red-600 rounded-lg shadow-md hover:bg-red-700 hover:shadow-lg">
                                        <i class="mr-2 fas fa-lock"></i>Simpan dan Kunci DF5-DF10
                                    </button>
                                </form>
                            @else
                                <button disabled
                                    class="px-8 py-3 text-gray-400 transition-all bg-gray-300 rounded-lg shadow-md cursor-not-allowed opacity-60">
                                    <i class="mr-2 fas fa-lock"></i>DF5-DF10 Sudah Dikunci
                                </button>
                                <a href="{{ route('user.assessments.index') }}"
                                    class="inline-block px-8 py-3 text-white transition-all bg-green-600 rounded-lg shadow-md hover:bg-green-700 hover:shadow-lg">
                                    <i class="mr-2 fas fa-check"></i>Selesai Penilaian
                                </a>
                            @endif
                            <button type="button" id="btnDownloadSummaryFinal" onclick="downloadSummaryFinal()"
                                class="px-8 py-3 text-white transition-all bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg">
                                <i class="mr-2 fas fa-download"></i>Download Summary Final
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
        // 1. SUMMARY BAR CHART â€” Refined Scope Score (column Q of Excel)
        //    Urutan: sesuai urutan GMO kode (EDM01â€¦MEA04), bukan descending sort
        //    Colors: positive = teal, negative = pink/red (like summary DF4)
        // ----------------------------------------------------------------
        const results    = @json($results);      // { code: score, ... }
        const rawSumsP   = @json($rawSumsDF10);  // { code: rawSum, ... }
        const p50        = @json($p50Refined);
        const p51        = @json($p51Refined);
        const denom      = @json($denomRefined);

        const gmoLabels  = Object.keys(results);   // preserve GMO order
        const scores     = Object.values(results);

        const summaryCanvas = document.getElementById('summaryCanvas');
        if (summaryCanvas && gmoLabels.length > 0) {
            const ctx = summaryCanvas.getContext('2d');

            // Colors: positive = teal, negative = pink/red
            const bgColors     = scores.map(v => v >= 0 ? 'rgba(75,192,192,0.65)'  : 'rgba(255,99,132,0.65)');
            const borderColors = scores.map(v => v >= 0 ? 'rgba(20,184,166,1)'      : 'rgba(239,68,68,1)');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: gmoLabels,
                    datasets: [{
                        label: 'Refined Scope Score',
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
                                text: 'Refined Scope Score (Q)',
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
                                    const code  = ctx.label;
                                    const score = ctx.raw;
                                    const rawP  = rawSumsP[code] !== undefined ? rawSumsP[code].toFixed(2) : '-';
                                    return [
                                        ` Score (Q): ${score > 0 ? '+' : ''}${score}`,
                                        ` Raw Sum (P): ${rawP}`,
                                        ` P50: ${p50.toFixed(2)}  |  P51: ${p51.toFixed(2)}  |  Denom: ${denom.toFixed(2)}`,
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
                '<p>Belum ada data. Silakan simpan DF1&ndash;DF10 terlebih dahulu.</p></div>';
        }

        // ----------------------------------------------------------------
        // 2. RADAR CHARTS (DF5&ndash;DF10)
        // ----------------------------------------------------------------
        const radarSets = [
            { id: 'df5RadarChart',  data: @json($df5Data),  title: 'DF5: Threat Landscape',        bg: 'rgba(59,130,246,0.2)',   border: 'rgba(59,130,246,1)'  },
            { id: 'df6RadarChart',  data: @json($df6Data),  title: 'DF6: Compliance Requirements',  bg: 'rgba(14,165,233,0.2)',   border: 'rgba(14,165,233,1)'  },
            { id: 'df7RadarChart',  data: @json($df7Data),  title: 'DF7: Role of IT',               bg: 'rgba(6,182,212,0.2)',    border: 'rgba(6,182,212,1)'   },
            { id: 'df8RadarChart',  data: @json($df8Data),  title: 'DF8: Sourcing Model',           bg: 'rgba(20,184,166,0.2)',   border: 'rgba(20,184,166,1)'  },
            { id: 'df9RadarChart',  data: @json($df9Data),  title: 'DF9: IT Implementation',        bg: 'rgba(16,185,129,0.2)',   border: 'rgba(16,185,129,1)'  },
            { id: 'df10RadarChart', data: @json($df10Data), title: 'DF10: Technology Adoption',     bg: 'rgba(34,197,94,0.2)',    border: 'rgba(34,197,94,1)'   },
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
            // Shift by +100 so radar range 0&ndash;200 maps to -100â€¦+100
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
    // Download Summary Final: buka window bersih, chart jadi gambar PNG (2x)
    // ----------------------------------------------------------------
    window.downloadSummaryFinal = function () {
        const btn = document.getElementById('btnDownloadSummaryFinal');
        if (btn) { btn.disabled = true; btn.innerHTML = '<i class="mr-2 fas fa-spinner fa-spin"></i>Menyiapkan...'; }

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

        const canvasSummary  = document.getElementById('summaryCanvas');
        const canvasDf5  = document.getElementById('df5RadarChart');
        const canvasDf6  = document.getElementById('df6RadarChart');
        const canvasDf7  = document.getElementById('df7RadarChart');
        const canvasDf8  = document.getElementById('df8RadarChart');
        const canvasDf9  = document.getElementById('df9RadarChart');
        const canvasDf10 = document.getElementById('df10RadarChart');

        if (!canvasSummary) {
            alert('Chart belum siap. Tunggu sebentar lalu coba lagi.');
            if (btn) { btn.disabled = false; btn.innerHTML = '<i class=\"mr-2 fas fa-download\"></i>Download Summary Final'; }
            return;
        }

        const summaryW = canvasSummary.width;
        const summaryH = canvasSummary.height;

        const imgSummary = captureCanvas(canvasSummary);
        const imgDf5  = captureCanvas(canvasDf5);
        const imgDf6  = captureCanvas(canvasDf6);
        const imgDf7  = captureCanvas(canvasDf7);
        const imgDf8  = captureCanvas(canvasDf8);
        const imgDf9  = captureCanvas(canvasDf9);
        const imgDf10 = captureCanvas(canvasDf10);

        const p50Val   = @json($p50Refined);
        const p51Val   = @json($p51Refined);
        const denomVal = @json($denomRefined);

        const aspectRatio = summaryW / summaryH;
        const chartStyle = aspectRatio < 1.5
            ? 'width:100%;height:auto;max-height:220mm;object-fit:contain;object-position:left;display:block;'
            : 'width:100%;height:auto;display:block;';

        const radarCards = [
            { img: imgDf5,  title: 'Design Factor 5',  sub: 'Threat Landscape' },
            { img: imgDf6,  title: 'Design Factor 6',  sub: 'Compliance Requirements' },
            { img: imgDf7,  title: 'Design Factor 7',  sub: 'Role of IT' },
            { img: imgDf8,  title: 'Design Factor 8',  sub: 'Sourcing Model' },
            { img: imgDf9,  title: 'Design Factor 9',  sub: 'IT Implementation' },
            { img: imgDf10, title: 'Design Factor 10', sub: 'Technology Adoption' },
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
    <title>Design Factor Canvas &ndash; Final Scope Summary</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; color: #1f2937; }
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
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="page-header">
            <h1>Design Factor Canvas</h1>
            <p>Tailored Governance System based on aggregated Design Factors (1&ndash;10)</p>
        </div>

        <div class="section">
            <div class="section-header">
                <h2>Final Design Governance System (Phase 1 + 2)</h2>
                <p>Aggregated importance scores from Design Factors 1&ndash;10 &mdash; <em>Refined Scope: Governance/Management Objectives Score</em></p>
            </div>
            <div class="formula-bar">
                <span><strong>Formula:</strong> IFERROR(IF(P&gt;0, MROUND(TRUNC(100&middot;P/denom),5), MROUND(TRUNC(100&middot;P/denom),&minus;5)), 0)</span>
                <span><strong>P50 (MAX sum):</strong> ${Number(p50Val).toFixed(2)}</span>
                <span><strong>P51 (|MIN sum|):</strong> ${Number(p51Val).toFixed(2)}</span>
                <span><strong>Denominator MAX(P50,P51):</strong> ${Number(denomVal).toFixed(2)}</span>
            </div>
            <div class="chart-wrap">
                <img src="${imgSummary}" alt="Refined Scope Bar Chart" style="${chartStyle}">
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <h2>Radar Charts Design Factors 5&ndash;10</h2>
                <p>Resulting Governance/Management Objectives Importance per Design Factor</p>
            </div>
            <div class="radar-grid">${radarCardsHTML}</div>
        </div>
    </div>

    <script>
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
            if (btn) { btn.disabled = false; btn.innerHTML = '<i class="mr-2 fas fa-download"></i>Download Summary Final'; }
            return;
        }
        pw.document.write(printHTML);
        pw.document.close();

        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="mr-2 fas fa-download"></i>Download Summary Final';
        }
    };

    // ----------------------------------------------------------------
    // Confirmation dialog for locking DF5-DF10
    // ----------------------------------------------------------------
    window.confirmLock = function () {
        Swal.fire({
            title: 'Kunci DF5-DF10?',
            html: `<p class="text-gray-700">Anda akan mengunci <strong>DF5 sampai DF10</strong> secara permanen.</p>
                   <p class="mt-2 text-red-600"><strong>Peringatan:</strong> Setelah dikunci, data penilaian tidak dapat diubah lagi!</p>`,
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

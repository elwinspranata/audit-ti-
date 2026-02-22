<!-- DF6 Input Table -->
<div class="mb-6 overflow-hidden light-card rounded-xl">
    <div class="p-4 border-b border-gray-200 bg-slate-50">
        <h2 class="text-xl font-bold text-green-600">
            {{ $factorInfo['title'] }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">{{ $factorInfo['description'] }}</p>
    </div>
    <div class="p-4 bg-white">
        <div id="smartMessageBoxMain" class="mb-4 p-3 rounded-lg border hidden">
            <div class="flex items-center">
                <div id="smartMessageIconMain" class="mr-3"></div>
                <div id="smartMessageContentMain" class="text-sm font-medium"></div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-9 xl:col-span-10 overflow-x-auto">
                <table class="strategic-table">
                    <thead>
                        <tr>
                            <th>Value</th>
                            <th>Importance (100%)</th>
                            <th>Baseline</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Threat Landscape (High)</td>
                            <td class="importance-cell text-center">
                                <input type="number" name="importance_high" id="importance_high"
                                    value="{{ $df6->importance_high ?? 33.33 }}" min="0" max="100"
                                    step="0.01"
                                    class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df6-input">
                                <span class="ml-1">%</span>
                            </td>
                            <td class="baseline-col text-center font-bold">0%</td>
                        </tr>
                        <tr>
                            <td>Threat Landscape (Normal)</td>
                            <td class="importance-cell text-center">
                                <input type="number" name="importance_normal" id="importance_normal"
                                    value="{{ $df6->importance_normal ?? 33.33 }}" min="0" max="100"
                                    step="0.01"
                                    class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df6-input">
                                <span class="ml-1">%</span>
                            </td>
                            <td class="baseline-col text-center font-bold">100%</td>
                        </tr>
                        <tr>
                            <td>Threat Landscape (Low)</td>
                            <td class="importance-cell text-center">
                                <input type="number" name="importance_low" id="importance_low"
                                    value="{{ $df6->importance_low ?? 33.34 }}" min="0" max="100"
                                    step="0.01"
                                    class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df6-input">
                                <span class="ml-1">%</span>
                            </td>
                            <td class="baseline-col text-center font-bold">0%</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-100 font-bold">
                            <td class="text-right pr-4">Total Importance:</td>
                            <td class="text-center">
                                <span id="totalPercentageDisplay" class="text-lg">100%</span>
                                <span id="validationMessage" class="ml-2"></span>
                            </td>
                            <td class="text-center">100%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- DF6 Total Display and Legend -->
            <div class="w-full lg:col-span-3 xl:col-span-2">
                <div class="border border-gray-400 overflow-hidden shadow-sm">
                    <div class="bg-white p-3 border-b border-gray-400">
                        <p class="text-sm font-bold text-gray-800">Total Importance</p>
                        <p class="text-2xl font-bold" id="df6TotalDisplay">100%</p>
                        <p class="text-xs text-gray-500 mt-1" id="df6Warning"></p>
                    </div>
                    <div class="bg-green-50 p-3">
                        <p class="text-xs font-medium text-green-700">Total harus = 100%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section 2: DF6 Results Table -->
<div class="mb-6 overflow-hidden light-card rounded-xl shadow-sm">
    <div class="p-4 border-b border-gray-200 bg-slate-50">
        <h2 class="text-xl font-bold text-green-600">Governance/Management Objectives Results</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="clean-table" id="df6ResultsTable">
            <thead>
                <tr>
                    <th>Objective</th>
                    <th>Score</th>
                    <th>Baseline Score</th>
                    <th>Relative Importance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                    <tr>
                        <td>
                            <span
                                class="px-3 py-1 text-sm font-black rounded
                                @if(str_starts_with($result['code'], 'EDM')) badge-edm
                                @elseif(str_starts_with($result['code'], 'APO')) badge-apo
                                @elseif(str_starts_with($result['code'], 'BAI')) badge-bai
                                @elseif(str_starts_with($result['code'], 'DSS')) badge-dss
                                @elseif(str_starts_with($result['code'], 'MEA')) badge-mea
                                @endif">
                                {{ $result['code'] }}
                            </span>
                            <span class="ml-2">{{ $result['name'] }}</span>
                        </td>
                        <td class="font-bold text-gray-700">{{ number_format($result['score'], 2) }}
                        </td>
                        <td class="font-bold text-gray-700">
                            {{ number_format($result['baseline_score'], 2) }}
                        </td>
                        <td>
                            <span
                                class="relative-importance font-black text-lg
                                @if($result['relative_importance'] > 0) value-positive
                                @elseif($result['relative_importance'] < 0) value-negative
                                @else value-neutral
                                @endif">
                                {{ $result['relative_importance'] > 0 ? '+' : '' }}{{ (int) $result['relative_importance'] }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Section 3: DF6 Charts -->
<div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
        <h2 class="text-lg font-bold text-gray-800 mb-2">DF6 Output</h2>
        <div class="relative" style="height: 700px;">
            <canvas id="df6BarChart"></canvas>
        </div>
    </div>
    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
        <h2 class="text-lg font-bold text-gray-800 mb-2">DF6 Radar</h2>
        <div class="relative" style="height: 700px;">
            <canvas id="df6RadarChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const highInput = document.getElementById('importance_high');
    const normalInput = document.getElementById('importance_normal');
    const lowInput = document.getElementById('importance_low');
    const totalPercentageDisplay = document.getElementById('totalPercentageDisplay');
    const validationMessage = document.getElementById('validationMessage');
    const saveBtnMain = document.getElementById('saveBtnMain');

    window.factorCalculate = function(context) {
        if (typeof window.updateTotal === 'function') window.updateTotal();
    };

    window.factorInitCharts = function(Chart, factorType, chartLabels, chartData) {
        const barCanvas = document.getElementById('df6BarChart');
        const radarCanvas = document.getElementById('df6RadarChart');
        if (!barCanvas || !radarCanvas) return null;
        const barCtx = barCanvas.getContext('2d');
        const radarCtx = radarCanvas.getContext('2d');
        const results = @json($results ?? []);
        const labels = results.map(r => r.code);
        const data = results.map(r => r.relative_importance);
        const df6BarChart = new Chart(barCtx, {
            type: 'bar',
            data: { labels: labels, datasets: [{ label: 'Relative Importance', data: data, backgroundColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)'), borderColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)'), borderWidth: 1 }] },
            options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
                scales: { x: { min: -100, max: 100, grid: { color: '#e5e7eb' }, ticks: { stepSize: 25 } }, y: { grid: { display: false }, ticks: { font: { weight: 'bold' } } } } }
        });
        const df6RadarChart = new Chart(radarCtx, {
            type: 'radar',
            data: { labels: labels, datasets: [{ label: 'Relative Importance', data: data.map(v => v + 100), backgroundColor: 'rgba(229, 180, 229, 0.3)', borderColor: 'rgba(229, 180, 229, 1)', borderWidth: 2, pointBackgroundColor: 'rgba(229, 180, 229, 1)', pointRadius: 2 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
                scales: { r: { min: 0, max: 200, ticks: { stepSize: 50, callback: v => v - 100, backdropColor: 'transparent' }, pointLabels: { font: { size: 10, weight: 'bold' } } } } }
        });
        window.df6BarChart = df6BarChart;
        window.df6RadarChart = df6RadarChart;
        return { barChart: df6BarChart, radarChart: df6RadarChart };
    };

    window.updateSmartMessage = function(high, normal, low, total, lastTarget) {
        const smartBox = document.getElementById('smartMessageBoxMain');
        const smartContent = document.getElementById('smartMessageContentMain');
        if (!smartBox) return;
        smartBox.classList.remove('hidden');
        if (Math.abs(total - 100) < 0.01) {
            smartBox.className = 'mb-4 p-3 rounded-lg border bg-green-50 border-green-200 text-green-800';
            smartContent.innerText = 'Total sudah tepat 100%. Data siap disimpan.';
        } else {
            smartBox.className = 'mb-4 p-3 rounded-lg border bg-blue-50 border-blue-200 text-blue-800';
            let diff = 100 - total;
            smartContent.innerText = `Saran: Tambahkan ${diff.toFixed(2)}% pada salah satu bidang agar total menjadi 100%.`;
        }
    }

    window.updateTotal = function(lastTarget = '') {
        const high = parseFloat(highInput?.value) || 0;
        const normal = parseFloat(normalInput?.value) || 0;
        const low = parseFloat(lowInput?.value) || 0;
        const total = high + normal + low;
        if (totalPercentageDisplay) totalPercentageDisplay.textContent = total.toFixed(2) + '%';
        if (document.getElementById('df6TotalDisplay')) document.getElementById('df6TotalDisplay').textContent = total.toFixed(2) + '%';
        window.updateSmartMessage(high, normal, low, total, lastTarget);
        if (Math.abs(total - 100) < 0.01) {
            if (validationMessage) validationMessage.innerHTML = '<span class="text-green-600 font-bold">✓ Valid</span>';
            if (saveBtnMain) { saveBtnMain.disabled = false; saveBtnMain.classList.remove('opacity-50', 'cursor-not-allowed'); }
        } else {
            if (validationMessage) validationMessage.innerHTML = '<span class="text-red-600 font-bold">✗ Harus 100%</span>';
            if (saveBtnMain) { saveBtnMain.disabled = true; saveBtnMain.classList.add('opacity-50', 'cursor-not-allowed'); }
        }
    }

    window.autoCalculate = function() {
        const high = parseFloat(highInput?.value) || 0;
        const normal = parseFloat(normalInput?.value) || 0;
        const low = parseFloat(lowInput?.value) || 0;
        fetch('{{ route('design-factors.df6.calculate') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ importance_high: high, importance_normal: normal, importance_low: low })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateResultsTable(data.results);
                updateCharts(data.results);
            }
        });
    }

    function updateResultsTable(results) {
        const tbody = document.querySelector('#df6ResultsTable tbody');
        if (!tbody) return;
        tbody.innerHTML = '';
        results.forEach(result => {
             const badgeClass = result.code.startsWith('EDM') ? 'badge-edm' : (result.code.startsWith('APO') ? 'badge-apo' : (result.code.startsWith('BAI') ? 'badge-bai' : (result.code.startsWith('DSS') ? 'badge-dss' : 'badge-mea')));
            const valClass = result.relative_importance > 0 ? 'value-positive' : (result.relative_importance < 0 ? 'value-negative' : 'value-neutral');
            const sign = result.relative_importance > 0 ? '+' : '';
            tbody.innerHTML += `<tr><td><span class="px-3 py-1 text-sm font-black rounded ${badgeClass}">${result.code}</span><span class="ml-2">${result.name}</span></td><td class="font-bold text-gray-700">${(result.score).toFixed(2)}</td><td class="font-bold text-gray-700">${(result.baseline_score).toFixed(2)}</td><td><span class="font-black text-lg ${valClass}">${sign}${Math.round(result.relative_importance)}</span></td></tr>`;
        });
    }

    function updateCharts(results) {
        if (!window.df6BarChart || !window.df6RadarChart) return;
        const data = results.map(r => r.relative_importance);
        window.df6BarChart.data.datasets[0].data = data;
        window.df6BarChart.update('none');
        window.df6RadarChart.data.datasets[0].data = data.map(v => v + 100);
        window.df6RadarChart.update('none');
    }

    if (highInput) [highInput, normalInput, lowInput].forEach(inp => {
        inp.addEventListener('input', () => { window.updateTotal(inp.id); window.autoCalculate(); });
    });

    window.updateTotal();
</script>
@endpush

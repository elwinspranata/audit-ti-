<!-- DF8 Input Table -->
<div class="mb-6 overflow-hidden light-card rounded-xl">
    <div class="p-4 border-b border-gray-200 bg-slate-50">
        <h2 class="text-xl font-bold text-green-600">
            {{ $factorInfo['title'] }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">{{ $factorInfo['description'] }}</p>
    </div>
    <div class="p-4 bg-white">
        <div id="smartMessageBoxDF8" class="mb-4 p-3 rounded-lg border hidden">
            <div class="flex items-center">
                <div id="smartMessageIconDF8" class="mr-3"></div>
                <div id="smartMessageContentDF8" class="text-sm font-medium"></div>
            </div>
        </div>
        <div class="w-full overflow-x-auto">
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
                        <td>Outsourcing</td>
                        <td class="importance-cell text-center">
                            <input type="number" name="importance_outsourcing"
                                id="importance_outsourcing" data-key="outsourcing"
                                value="{{ $df8->importance_outsourcing ?? 33.00 }}" min="0" max="100"
                                step="0.01"
                                class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df8-input importance-input">
                            <span class="ml-1">%</span>
                        </td>
                        <td class="baseline-col text-center font-bold">33%</td>
                    </tr>
                    <tr>
                        <td>Cloud</td>
                        <td class="importance-cell text-center">
                            <input type="number" name="importance_cloud" id="importance_cloud"
                                data-key="cloud" value="{{ $df8->importance_cloud ?? 33.00 }}" min="0"
                                max="100" step="0.01"
                                class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df8-input importance-input">
                            <span class="ml-1">%</span>
                        </td>
                        <td class="baseline-col text-center font-bold">33%</td>
                    </tr>
                    <tr>
                        <td>Insourced</td>
                        <td class="importance-cell text-center">
                            <input type="number" name="importance_insourced" id="importance_insourced"
                                data-key="insourced" value="{{ $df8->importance_insourced ?? 34.00 }}"
                                min="0" max="100" step="0.01"
                                class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df8-input importance-input">
                            <span class="ml-1">%</span>
                        </td>
                        <td class="baseline-col text-center font-bold">34%</td>
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
    </div>
</div>

<!-- Section 2: DF8 Results Table -->
<div class="mb-6 overflow-hidden light-card rounded-xl shadow-sm">
    <div class="p-4 border-b border-gray-200 bg-slate-50">
        <h2 class="text-xl font-bold text-green-600">Governance/Management Objectives Results</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="clean-table" id="df8ResultsTable">
            <thead>
                <tr>
                    <th>Objective</th>
                    <th>Score</th>
                    <th>Baseline Score</th>
                    <th>Relative Importance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $index => $result)
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
                            <input type="hidden" name="items[{{ $index }}][code]"
                                value="{{ $result['code'] }}">
                            <input type="hidden" name="items[{{ $index }}][score]"
                                value="{{ $result['score'] }}" class="item-score-hidden">
                            <input type="hidden" name="items[{{ $index }}][baseline_score]"
                                value="{{ $result['baseline_score'] }}" class="item-baseline-hidden">

                            @if(isset($df8Mapping[$result['code']]))
                                <input type="hidden" class="item-outsourcing-value"
                                    value="{{ $df8Mapping[$result['code']][0] }}">
                                <input type="hidden" class="item-cloud-value"
                                    value="{{ $df8Mapping[$result['code']][1] }}">
                                <input type="hidden" class="item-insourced-value"
                                    value="{{ $df8Mapping[$result['code']][2] }}">
                            @endif
                            <span class="ml-2">{{ $result['name'] }}</span>
                        </td>
                        <td class="font-bold text-gray-700 item-score-display">
                            {{ number_format($result['score'], 1) }}
                        </td>
                        <td class="font-bold text-gray-700 item-baseline-display">
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

<!-- Section 3: DF8 Charts -->
<div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
        <h2 class="text-lg font-bold text-gray-800 mb-2">DF8 Output</h2>
        <div class="relative" style="height: 700px;">
            <canvas id="df8BarChart"></canvas>
        </div>
    </div>
    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
        <h2 class="text-lg font-bold text-gray-800 mb-2">DF8 Radar</h2>
        <div class="relative" style="height: 700px;">
            <canvas id="df8RadarChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const outsourcingInput = document.getElementById('importance_outsourcing');
    const cloudInput = document.getElementById('importance_cloud');
    const insourcedInput = document.getElementById('importance_insourced');
    const totalPercentageDisplay = document.getElementById('totalPercentageDisplay');
    const validationMessage = document.getElementById('validationMessage');
    const saveBtnMain = document.getElementById('saveBtnMain');

    window.factorCalculate = function(context) {
        if (typeof window.updateTotalDF8 === 'function') window.updateTotalDF8();
    };

    window.factorInitCharts = function(Chart, factorType, chartLabels, chartData) {
        const barCanvas = document.getElementById('df8BarChart');
        const radarCanvas = document.getElementById('df8RadarChart');
        if (!barCanvas || !radarCanvas) return null;
        const barCtx = barCanvas.getContext('2d');
        const radarCtx = radarCanvas.getContext('2d');
        const results = @json($results ?? []);
        const labels = results.map(r => r.code);
        const data = results.map(r => r.relative_importance);
        const df8BarChart = new Chart(barCtx, {
            type: 'bar',
            data: { labels: labels, datasets: [{ label: 'Relative Importance', data: data, backgroundColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)'), borderColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)'), borderWidth: 1 }] },
            options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
                scales: { x: { min: -100, max: 100, grid: { color: '#e5e7eb' }, ticks: { stepSize: 25 } }, y: { grid: { display: false }, ticks: { font: { weight: 'bold' } } } } }
        });
        const df8RadarChart = new Chart(radarCtx, {
            type: 'radar',
            data: { labels: labels, datasets: [{ label: 'Relative Importance', data: data.map(v => v + 100), backgroundColor: 'rgba(229, 180, 229, 0.3)', borderColor: 'rgba(229, 180, 229, 1)', borderWidth: 2, pointBackgroundColor: 'rgba(229, 180, 229, 1)', pointRadius: 2 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
                scales: { r: { min: 0, max: 200, ticks: { stepSize: 50, callback: v => v - 100, backdropColor: 'transparent' }, pointLabels: { font: { size: 10, weight: 'bold' } } } } }
        });
        window.df8BarChart = df8BarChart;
        window.df8RadarChart = df8RadarChart;
        return { barChart: df8BarChart, radarChart: df8RadarChart };
    };

    window.updateSmartMessage = function(out, cloud, ins, total, lastTarget) {
        const smartBox = document.getElementById('smartMessageBoxDF8');
        const smartContent = document.getElementById('smartMessageContentDF8');
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

    window.updateTotalDF8 = function() {
        const out = parseFloat(outsourcingInput?.value) || 0;
        const cloud = parseFloat(cloudInput?.value) || 0;
        const ins = parseFloat(insourcedInput?.value) || 0;
        const total = out + cloud + ins;
        if (totalPercentageDisplay) totalPercentageDisplay.textContent = total.toFixed(2) + '%';
        window.updateSmartMessage(out, cloud, ins, total);
        if (Math.abs(total - 100) < 0.01) {
            if (validationMessage) validationMessage.innerHTML = '<span class="text-green-600 font-bold">✓ Valid</span>';
            if (saveBtnMain) { saveBtnMain.disabled = false; saveBtnMain.classList.remove('opacity-50', 'cursor-not-allowed'); }
        } else {
            if (validationMessage) validationMessage.innerHTML = '<span class="text-red-600 font-bold">✗ Harus 100%</span>';
            if (saveBtnMain) { saveBtnMain.disabled = true; saveBtnMain.classList.add('opacity-50', 'cursor-not-allowed'); }
        }
    }

    window.autoCalculateDF8 = function() {
        const out = parseFloat(outsourcingInput?.value) || 0;
        const cloud = parseFloat(cloudInput?.value) || 0;
        const ins = parseFloat(insourcedInput?.value) || 0;
        fetch('{{ route('design-factors.df8.calculate') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ importance_outsourcing: out, importance_cloud: cloud, importance_insourced: ins })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateDF8ResultsTable(data.results);
                updateDF8Charts(data.results);
            }
        });
    }

    function updateDF8ResultsTable(results) {
        const tbody = document.querySelector('#df8ResultsTable tbody');
        if (!tbody) return;
        tbody.innerHTML = '';
        results.forEach(result => {
             const badgeClass = result.code.startsWith('EDM') ? 'badge-edm' : (result.code.startsWith('APO') ? 'badge-apo' : (result.code.startsWith('BAI') ? 'badge-bai' : (result.code.startsWith('DSS') ? 'badge-dss' : 'badge-mea')));
            const valClass = result.relative_importance > 0 ? 'value-positive' : (result.relative_importance < 0 ? 'value-negative' : 'value-neutral');
            const sign = result.relative_importance > 0 ? '+' : '';
            tbody.innerHTML += `<tr><td><span class="px-3 py-1 text-sm font-black rounded ${badgeClass}">${result.code}</span><span class="ml-2">${result.name}</span></td><td class="font-bold text-gray-700">${(result.score).toFixed(2)}</td><td class="font-bold text-gray-700">${(result.baseline_score).toFixed(2)}</td><td><span class="font-black text-lg ${valClass}">${sign}${Math.round(result.relative_importance)}</span></td></tr>`;
        });
    }

    function updateDF8Charts(results) {
        if (!window.df8BarChart || !window.df8RadarChart) return;
        const data = results.map(r => r.relative_importance);
        window.df8BarChart.data.datasets[0].data = data;
        window.df8BarChart.update('none');
        window.df8RadarChart.data.datasets[0].data = data.map(v => v + 100);
        window.df8RadarChart.update('none');
    }

    if (outsourcingInput) [outsourcingInput, cloudInput, insourcedInput].forEach(inp => {
        inp?.addEventListener('input', () => { window.updateTotalDF8(); window.autoCalculateDF8(); });
    });

    window.updateTotalDF8();
</script>
@endpush

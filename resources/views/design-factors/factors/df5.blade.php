<!-- DF5 Input Table -->
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
                        <td>Set of Governance and Management Objectives (High)</td>
                        <td class="importance-cell text-center">
                            <input type="number" name="importance_high" id="importance_high"
                                value="{{ $df5->importance_high ?? 50 }}" min="0" max="100" step="0.01"
                                class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df5-input"
                                {{ (isset($df5) && method_exists($df5, 'is_locked') && $df5->is_locked) ? 'disabled readonly' : '' }}>
                            <span class="ml-1">%</span>
                        </td>
                        <td class="baseline-col text-center font-bold">33%</td>
                    </tr>
                    <tr>
                        <td>Set of Governance and Management Objectives (Normal)</td>
                        <td class="importance-cell text-center">
                            <input type="number" name="importance_normal" id="importance_normal"
                                value="{{ $df5->importance_normal ?? 50 }}" min="0" max="100"
                                step="0.01"
                                class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df5-input"
                                {{ (isset($df5) && method_exists($df5, 'is_locked') && $df5->is_locked) ? 'disabled readonly' : '' }}>
                            <span class="ml-1">%</span>
                        </td>
                        <td class="baseline-col text-center font-bold">67%</td>
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

<!-- Section 2: DF5 Results Table -->
<div class="mb-6 overflow-hidden light-card rounded-xl shadow-sm">
    <div class="p-4 border-b border-gray-200 bg-slate-50">
        <h2 class="text-xl font-bold text-green-600">Governance/Management Objectives Results</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="clean-table" id="df5ResultsTable">
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
                        <td class="font-bold text-gray-700">{{ number_format($result['score'] / 100, 2) }}
                        </td>
                        <td class="font-bold text-gray-700">
                            {{ number_format($result['baseline_score'] / 100, 2) }}
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

<!-- Section 3: DF5 Charts -->
<div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
        <h2 class="text-lg font-bold text-gray-800 mb-2">DF5 Output</h2>
        <div class="relative" style="height: 700px;">
            <canvas id="df5BarChart"></canvas>
        </div>
    </div>
    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
        <h2 class="text-lg font-bold text-gray-800 mb-2">DF5 Radar</h2>
        <div class="relative" style="height: 700px;">
            <canvas id="df5RadarChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.factorCalculate = function(context) {
        // DF5 uses AJAX calculation, but we can call it here
        if (typeof window.updateTotalDF5 === 'function') window.updateTotalDF5();
    };

    window.factorInitCharts = function(Chart, factorType, chartLabels, chartData) {
        const barCanvas = document.getElementById('df5BarChart');
        const radarCanvas = document.getElementById('df5RadarChart');
        if (!barCanvas || !radarCanvas) return null;

        const barCtx = barCanvas.getContext('2d');
        const radarCtx = radarCanvas.getContext('2d');

        const results = @json($results ?? []);
        const labels = results.map(r => r.code);
        const data = results.map(r => r.relative_importance);

        const df5BarChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Relative Importance',
                    data: data,
                    backgroundColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)'),
                    borderColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)'),
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y', responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { min: -100, max: 100, grid: { color: '#e5e7eb' }, ticks: { stepSize: 25 } },
                    y: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
                }
            }
        });

        const df5RadarChart = new Chart(radarCtx, {
            type: 'radar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Relative Importance',
                    data: data.map(v => v + 100),
                    backgroundColor: 'rgba(229, 180, 229, 0.3)',
                    borderColor: 'rgba(229, 180, 229, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(229, 180, 229, 1)',
                    pointRadius: 2
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    r: {
                        min: 0, max: 200,
                        ticks: { stepSize: 50, callback: v => v - 100, backdropColor: 'transparent' },
                        pointLabels: { font: { size: 10, weight: 'bold' } }
                    }
                }
            }
        });

        window.df5BarChart = df5BarChart;
        window.df5RadarChart = df5RadarChart;
        return { barChart: df5BarChart, radarChart: df5RadarChart };
    };

    // Specific logic for DF5
    const highInput = document.getElementById('importance_high');
    const normalInput = document.getElementById('importance_normal');
    const totalPercentageDisplay = document.getElementById('totalPercentageDisplay');
    const validationMessage = document.getElementById('validationMessage');
    const saveBtnMain = document.getElementById('saveBtnMain');

    window.updateSmartMessage = function(high, normal, total, lastTarget) {
        const smartBox = document.getElementById('smartMessageBoxMain');
        const smartIcon = document.getElementById('smartMessageIconMain');
        const smartContent = document.getElementById('smartMessageContentMain');

        if (!smartBox) return;
        smartBox.classList.remove('hidden');

        if (Math.abs(total - 100) < 0.01) {
            smartBox.className = 'mb-4 p-3 rounded-lg border bg-green-50 border-green-200 text-green-800';
            smartIcon.innerHTML = '<svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
            smartContent.innerText = 'Total sudah tepat 100%. Data siap disimpan.';
        } else if (total > 100) {
            smartBox.className = 'mb-4 p-3 rounded-lg border bg-red-50 border-red-200 text-red-800';
            smartIcon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
            smartContent.innerText = `Total (${total.toFixed(2)}%) melebihi 100%! Mohon kurangi nilai agar pas 100%.`;
        } else {
            smartBox.className = 'mb-4 p-3 rounded-lg border bg-blue-50 border-blue-200 text-blue-800';
            smartIcon.innerHTML = '<svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>';
            let suggestion = lastTarget === 'high' ? `Saran: Isi 'Normal' dengan ${(100 - high).toFixed(2)}%` : `Saran: Isi 'High' dengan ${(100 - normal).toFixed(2)}%`;
            smartContent.innerText = suggestion;
        }
    }

    window.updateTotalDF5 = function(lastTarget = 'high') {
        const high = parseFloat(highInput.value) || 0;
        const normal = parseFloat(normalInput.value) || 0;
        const total = high + normal;
        if (totalPercentageDisplay) totalPercentageDisplay.textContent = total.toFixed(2) + '%';
        window.updateSmartMessage(high, normal, total, lastTarget);
        if (Math.abs(total - 100) < 0.01) {
            if (validationMessage) validationMessage.innerHTML = '<span class="text-green-600 font-bold">✓ Valid</span>';
            if (saveBtnMain) { saveBtnMain.disabled = false; saveBtnMain.classList.remove('opacity-50', 'cursor-not-allowed'); }
        } else {
            if (validationMessage) validationMessage.innerHTML = '<span class="text-red-600 font-bold">✗ Harus 100%</span>';
            if (saveBtnMain) { saveBtnMain.disabled = true; saveBtnMain.classList.add('opacity-50', 'cursor-not-allowed'); }
        }
    }

    window.autoCalculateDF5 = function() {
        const high = parseFloat(highInput.value) || 0;
        const normal = parseFloat(normalInput.value) || 0;
        fetch('{{ route('design-factors.df5.calculate') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ importance_high: high, importance_normal: normal })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateDF5ResultsTable(data.results);
                updateDF5Charts(data.results);
            }
        });
    }

    function updateDF5ResultsTable(results) {
        const tbody = document.querySelector('#df5ResultsTable tbody');
        if (!tbody) return;
        tbody.innerHTML = '';
        results.forEach(result => {
            const badgeClass = result.code.startsWith('EDM') ? 'badge-edm' : (result.code.startsWith('APO') ? 'badge-apo' : (result.code.startsWith('BAI') ? 'badge-bai' : (result.code.startsWith('DSS') ? 'badge-dss' : 'badge-mea')));
            const valClass = result.relative_importance > 0 ? 'value-positive' : (result.relative_importance < 0 ? 'value-negative' : 'value-neutral');
            const sign = result.relative_importance > 0 ? '+' : '';
            tbody.innerHTML += `<tr><td><span class="px-3 py-1 text-sm font-black rounded ${badgeClass}">${result.code}</span><span class="ml-2">${result.name}</span></td><td class="font-bold text-gray-700">${(result.score / 100).toFixed(2)}</td><td class="font-bold text-gray-700">${(result.baseline_score / 100).toFixed(2)}</td><td><span class="font-black text-lg ${valClass}">${sign}${Math.round(result.relative_importance)}</span></td></tr>`;
        });
    }

    function updateDF5Charts(results) {
        if (!window.df5BarChart || !window.df5RadarChart) return;
        const data = results.map(r => r.relative_importance);
        window.df5BarChart.data.datasets[0].data = data;
        window.df5BarChart.data.datasets[0].backgroundColor = data.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)');
        window.df5BarChart.data.datasets[0].borderColor = data.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)');
        window.df5BarChart.update('none');
        window.df5RadarChart.data.datasets[0].data = data.map(v => v + 100);
        window.df5RadarChart.update('none');
    }

    highInput.addEventListener('input', () => { window.updateTotalDF5('high'); window.autoCalculateDF5(); });
    normalInput.addEventListener('input', () => { window.updateTotalDF5('normal'); window.autoCalculateDF5(); });
    
    // Initial update
    window.updateTotalDF5();
</script>
@endpush

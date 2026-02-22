<!-- DF10 Input Table -->
<div class="mb-6 overflow-hidden light-card rounded-xl">
    <div class="p-4 border-b border-gray-200 bg-slate-50">
        <h2 class="text-xl font-bold text-green-600">
            {{ $factorInfo['title'] }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">{{ $factorInfo['description'] }}</p>
    </div>
    <div class="p-4 bg-white">
        <div id="df10SmartMessageBox"
            class="mb-4 p-3 rounded-lg border bg-blue-50 border-blue-200 text-blue-800 hidden">
            <div class="flex items-start gap-3">
                <div id="df10SmartIcon" class="mt-0.5">
                    <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p id="df10SmartContent" class="text-sm font-medium">
                        Total importance harus tepat 100%. Total saat ini: <span
                            id="df10TotalDisplay">100</span>%.
                    </p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-12 overflow-x-auto min-w-0">
                <table class="strategic-table">
                    <thead>
                        <tr>
                            <th style="min-width: 200px;">Value</th>
                            <th style="min-width: 200px;">Importance (100%)</th>
                            <th style="min-width: 100px;">Baseline</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($metadata as $key => $data)
                            <tr>
                                <td class="font-medium text-gray-700">{{ $data['name'] }}</td>
                                <td class="importance-cell">
                                    @php
                                        $inputId = '';
                                        if ($key === 'first_mover')
                                            $inputId = 'importance_first_mover';
                                        elseif ($key === 'follower')
                                            $inputId = 'importance_follower';
                                        elseif ($key === 'slow_adopter')
                                            $inputId = 'importance_slow_adopter';
                                    @endphp
                                    <input type="number" name="inputs[{{ $key }}][importance]"
                                        id="{{ $inputId }}"
                                        value="{{ data_get($designFactor->inputs, $key . '.importance', $key === 'first_mover' ? 75 : ($key === 'follower' ? 15 : 10)) }}"
                                        min="0" max="100" step="0.01"
                                        class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df10-input"
                                        data-key="{{ $key }}" {{ $designFactor->is_locked ? 'disabled readonly' : '' }}>
                                    <span class="ml-1">%</span>
                                </td>
                                <td class="baseline-col">
                                    {{ data_get($designFactor->inputs, $key . '.baseline', $key === 'first_mover' ? 33.33 : ($key === 'follower' ? 33.33 : 33.33)) }}
                                    <input type="hidden" name="inputs[{{ $key }}][baseline]"
                                        value="{{ data_get($designFactor->inputs, $key . '.baseline', 33.33) }}" class="baseline-input">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Section 2: DF10 Results -->
<div class="mb-6 overflow-hidden light-card rounded-xl shadow-sm">
    <div class="p-4 border-b border-gray-200 bg-slate-50">
        <h2 class="text-xl font-bold text-gray-800">Governance/Management Objectives Results</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="clean-table" id="df10ResultsTable">
            <thead>
                <tr>
                    <th>Governance / Management Objective</th>
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

                            @if(isset($df10Mapping[$result['code']]))
                                <input type="hidden" class="item-first-mover-value"
                                    value="{{ $df10Mapping[$result['code']][0] }}">
                                <input type="hidden" class="item-follower-value"
                                    value="{{ $df10Mapping[$result['code']][1] }}">
                                <input type="hidden" class="item-slow-adopter-value"
                                    value="{{ $df10Mapping[$result['code']][2] }}">
                            @endif

                            <span class="ml-2">{{ $result['name'] }}</span>
                        </td>
                        <td class="font-bold text-gray-700 item-score-display">
                            {{ number_format($result['score'], 2) }}
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

<!-- Section 3: DF10 Charts -->
<div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
        <h2 class="text-lg font-bold text-gray-800 mb-2">DF10 Output</h2>
        <div class="relative" style="height: 700px;">
            <canvas id="df10BarChart"></canvas>
        </div>
    </div>
    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
        <h2 class="text-lg font-bold text-gray-800 mb-2">DF10 Radar</h2>
        <div class="relative" style="height: 700px;">
            <canvas id="df10RadarChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const firstMoverInput = document.getElementById('importance_first_mover');
    const followerInput = document.getElementById('importance_follower');
    const slowAdopterInput = document.getElementById('importance_slow_adopter');
    const df10SmartMessageBox = document.getElementById('df10SmartMessageBox');
    const df10TotalDisplay = document.getElementById('df10TotalDisplay');
    const saveBtnMain = document.getElementById('saveBtnMain');

    window.factorCalculate = function(context) {
        if (typeof window.updateTotalDF10 === 'function') window.updateTotalDF10();
    };

    window.factorInitCharts = function(Chart, factorType, chartLabels, chartData) {
        const barCanvas = document.getElementById('df10BarChart');
        const radarCanvas = document.getElementById('df10RadarChart');
        if (!barCanvas || !radarCanvas) return null;
        const barCtx = barCanvas.getContext('2d');
        const radarCtx = radarCanvas.getContext('2d');
        const results = @json($results ?? []);
        const labels = results.map(r => r.code);
        const data = results.map(r => r.relative_importance);
        const df10BarChart = new Chart(barCtx, {
            type: 'bar',
            data: { labels: labels, datasets: [{ label: 'Relative Importance', data: data, backgroundColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)'), borderColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)'), borderWidth: 1 }] },
            options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
                scales: { x: { min: -100, max: 100, grid: { color: '#e5e7eb' }, ticks: { stepSize: 25 } }, y: { grid: { display: false }, ticks: { font: { weight: 'bold' } } } } }
        });
        const df10RadarChart = new Chart(radarCtx, {
            type: 'radar',
            data: { labels: labels, datasets: [{ label: 'Relative Importance', data: data.map(v => v + 100), backgroundColor: 'rgba(229, 180, 229, 0.3)', borderColor: 'rgba(229, 180, 229, 1)', borderWidth: 2, pointBackgroundColor: 'rgba(229, 180, 229, 1)', pointRadius: 2 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
                scales: { r: { min: 0, max: 200, ticks: { stepSize: 50, callback: v => v - 100, backdropColor: 'transparent' }, pointLabels: { font: { size: 10, weight: 'bold' } } } } }
        });
        window.df10BarChart = df10BarChart;
        window.df10RadarChart = df10RadarChart;
        return { barChart: df10BarChart, radarChart: df10RadarChart };
    };

    window.updateTotalDF10 = function() {
        const first = parseFloat(firstMoverInput?.value) || 0;
        const follower = parseFloat(followerInput?.value) || 0;
        const slow = parseFloat(slowAdopterInput?.value) || 0;
        const total = first + follower + slow;
        if (df10TotalDisplay) df10TotalDisplay.textContent = total.toFixed(2);
        if (df10SmartMessageBox) df10SmartMessageBox.classList.toggle('hidden', false);
        
        if (Math.abs(total - 100) < 0.01) {
            if (saveBtnMain) { saveBtnMain.disabled = false; saveBtnMain.classList.remove('opacity-50', 'cursor-not-allowed'); }
        } else {
            if (saveBtnMain) { saveBtnMain.disabled = true; saveBtnMain.classList.add('opacity-50', 'cursor-not-allowed'); }
        }
    }

    window.autoCalculateDF10 = function() {
        const first = parseFloat(firstMoverInput?.value) || 0;
        const follower = parseFloat(followerInput?.value) || 0;
        const slow = parseFloat(slowAdopterInput?.value) || 0;
        fetch('{{ route('design-factors.df10.calculate') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ 
                factor_type: 'DF10', 
                inputs: { 
                    first_mover: {importance: first, baseline: 33.33}, 
                    follower: {importance: follower, baseline: 33.33}, 
                    slow_adopter: {importance: slow, baseline: 33.33} 
                } 
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateDF10ResultsTable(data.results);
                updateDF10Charts(data.results);
            }
        });
    }

    function updateDF10ResultsTable(results) {
        const tbody = document.querySelector('#df10ResultsTable tbody');
        if (!tbody) return;
        tbody.innerHTML = '';
        results.forEach(result => {
             const badgeClass = result.code.startsWith('EDM') ? 'badge-edm' : (result.code.startsWith('APO') ? 'badge-apo' : (result.code.startsWith('BAI') ? 'badge-bai' : (result.code.startsWith('DSS') ? 'badge-dss' : 'badge-mea')));
            const valClass = result.relative_importance > 0 ? 'value-positive' : (result.relative_importance < 0 ? 'value-negative' : 'value-neutral');
            const sign = result.relative_importance > 0 ? '+' : '';
            tbody.innerHTML += `<tr><td><span class="px-3 py-1 text-sm font-black rounded ${badgeClass}">${result.code}</span><span class="ml-2">${result.name}</span></td><td class="font-bold text-gray-700">${(result.score).toFixed(2)}</td><td class="font-bold text-gray-700">${(result.baseline_score).toFixed(2)}</td><td><span class="font-black text-lg ${valClass}">${sign}${Math.round(result.relative_importance)}</span></td></tr>`;
        });
    }

    function updateDF10Charts(results) {
        if (!window.df10BarChart || !window.df10RadarChart) return;
        const data = results.map(r => r.relative_importance);
        window.df10BarChart.data.datasets[0].data = data;
        window.df10BarChart.update('none');
        window.df10RadarChart.data.datasets[0].data = data.map(v => v + 100);
        window.df10RadarChart.update('none');
    }

    if (firstMoverInput) [firstMoverInput, followerInput, slowAdopterInput].forEach(inp => {
        inp?.addEventListener('input', () => { window.updateTotalDF10(); window.autoCalculateDF10(); });
    });

    window.updateTotalDF10();
</script>
@endpush

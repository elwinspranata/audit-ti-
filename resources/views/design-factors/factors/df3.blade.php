<!-- DF3 Input Table (Heatmap) -->
<div class="mb-6 overflow-hidden light-card rounded-xl">
    <div class="p-4 border-b border-gray-200 bg-slate-50">
        <h2 class="text-xl font-bold text-green-600">
            {{ $factorInfo['title'] }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">{{ $factorInfo['description'] }}</p>
    </div>
    <div class="p-4 bg-white">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-9 xl:col-span-10 overflow-x-auto min-w-0">
                <table class="clean-table border-collapse w-full">
                    <thead>
                        <tr>
                            <th rowspan="2" class="w-12 text-center">No.</th>
                            <th rowspan="2" class="text-center">Risk Scenario</th>
                            <th colspan="2" class="text-center">Rating</th>
                            <th rowspan="2" class="w-24 text-center">Risk Score</th>
                            <th rowspan="2" class="w-24 text-center">Baseline</th>
                        </tr>
                        <tr>
                            <th class="w-24 text-center">Impact</th>
                            <th class="w-24 text-center">Likelihood</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($metadata as $index => $risk)
                            <tr>
                                <td class="text-center font-bold">{{ $loop->iteration }}</td>
                                <td class="text-left font-medium">{{ $risk['name'] }}</td>

                                {{-- Impact Input --}}
                                @php
                                    $impact = data_get($designFactor->inputs, $index . '.impact', 3);
                                @endphp
                                <td class="p-0 border-r border-[#1e2f13] bg-val-{{ $impact }} impact-cell">
                                    <input type="number" name="inputs[{{ $index }}][impact]"
                                        value="{{ $impact }}" min="1" max="5"
                                        class="heat-input impact-input"
                                        data-index="{{ $index }}" {{ $designFactor->is_locked ? 'disabled readonly' : '' }}>
                                </td>

                                {{-- Likelihood Input --}}
                                @php
                                    $likelihood = data_get($designFactor->inputs, $index . '.likelihood', 3);
                                @endphp
                                <td class="p-0 border-r border-[#1e2f13] bg-val-{{ $likelihood }} likelihood-cell">
                                    <input type="number" name="inputs[{{ $index }}][likelihood]"
                                        value="{{ $likelihood }}" min="1" max="5"
                                        class="heat-input likelihood-input"
                                        data-index="{{ $index }}" {{ $designFactor->is_locked ? 'disabled readonly' : '' }}>
                                </td>

                                {{-- Result Score --}}
                                @php
                                    $score = $impact * $likelihood;
                                @endphp
                                <td class="font-bold bg-white score-display bg-val-{{ ceil($score / 5) }}">
                                    {{ $score }}
                                </td>

                                {{-- Baseline --}}
                                <td class="df3-baseline bg-gray-600">9</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Legend container -->
            <div class="w-full lg:col-span-3 xl:col-span-2">
                <div class="border border-gray-400 overflow-hidden shadow-sm">
                    <div class="bg-white p-2 border-b border-gray-400 flex items-center gap-3">
                        <div class="w-4 h-4 rounded-full"
                            style="background-color: #c00000; border: 1px solid #000;"></div>
                        <span class="text-xs font-bold text-gray-800">Very High Risk</span>
                    </div>
                    <div class="bg-white p-2 border-b border-gray-400 flex items-center gap-3">
                        <div class="w-4 h-4 rounded-full"
                            style="background-color: #edbd70; border: 1px solid #000;"></div>
                        <span class="text-xs font-bold text-gray-800">High Risk</span>
                    </div>
                    <div class="bg-white p-2 border-b border-gray-400 flex items-center gap-3">
                        <div class="w-4 h-4 rounded-full"
                            style="background-color: #72a488; border: 1px solid #000;"></div>
                        <span class="text-xs font-bold text-gray-800">Normal Risk</span>
                    </div>
                    <div class="bg-white p-2 flex items-center gap-3">
                        <div class="w-4 h-4 rounded-full"
                            style="background-color: #4b4b4b; border: 1px solid #000;"></div>
                        <span class="text-xs font-bold text-gray-800">Low Risk</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section 3: Governance Outcomes -->
<div class="mb-6 overflow-hidden light-card rounded-xl shadow-sm">
    <div class="p-4 border-b border-gray-200 bg-slate-50">
        <h2 class="text-xl font-bold text-green-600">Tailored Governance System</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="clean-table">
            <thead>
                <tr>
                    <th>Objective Code</th>
                    <th>Mapping Score</th>
                    <th>Mapping Baseline</th>
                    <th>Relative Importance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($designFactor->items as $index => $item)
                    <tr>
                        <td>
                            <span
                                class="px-3 py-1 text-sm font-black rounded
                                @if(str_starts_with($item->code, 'EDM')) badge-edm
                                @elseif(str_starts_with($item->code, 'APO')) badge-apo
                                @elseif(str_starts_with($item->code, 'BAI')) badge-bai
                                @elseif(str_starts_with($item->code, 'DSS')) badge-dss
                                @elseif(str_starts_with($item->code, 'MEA')) badge-mea
                                @endif">
                                {{ $item->code }}
                            </span>
                            <input type="hidden" name="items[{{ $index }}][code]" value="{{ $item->code }}">
                            <input type="hidden" name="items[{{ $index }}][score]"
                                value="{{ $item->score }}" class="item-score-hidden">
                            <input type="hidden" name="items[{{ $index }}][baseline_score]"
                                value="{{ $item->baseline_score }}" class="item-baseline-hidden">
                        </td>
                        <td class="font-bold text-gray-700 item-score-display">{{ $item->score }}
                        </td>
                        <td class="font-bold text-gray-700 item-baseline-display">
                            {{ $item->baseline_score }}
                        </td>
                        <td>
                            <span
                                class="relative-importance font-black text-lg
                                @if($item->relative_importance > 0) value-positive
                                @elseif($item->relative_importance < 0) value-negative
                                @else value-neutral
                                @endif"
                                data-index="{{ $index }}">
                                {{ $item->relative_importance > 0 ? '+' : '' }}{{ (int) $item->relative_importance }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Section 4: Charts -->
<div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
        <h2 class="text-lg font-bold text-gray-800 mb-2">{{ $type }} Output</h2>
        <div class="relative" style="height: 700px;">
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
        <h2 class="text-lg font-bold text-gray-800 mb-2">{{ $type }} Radar</h2>
        <div class="relative" style="height: 700px;">
            <canvas id="radarChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.factorCalculate = function(context) {
        const { factorType, cobitMappings, df3Inputs, itemScores, itemBaselines, itemScoreHiddens, itemScoreDisplays, itemBaselineHiddens, itemBaselineDisplays, setChartData } = context;
        
        const grouped = {};
        df3Inputs.forEach(input => {
            const index = input.dataset.index;
            if (!grouped[index]) grouped[index] = { impact: 3, likelihood: 3 };
            if (input.classList.contains('impact-input')) grouped[index].impact = parseFloat(input.value) || 3;
            if (input.classList.contains('likelihood-input')) grouped[index].likelihood = parseFloat(input.value) || 3;
            
            const val = parseInt(input.value) || 0;
            const parentTd = input.closest('td');
            if (parentTd) {
                parentTd.className = `p-0 border-r border-[#1e2f13] bg-val-${val} ${input.classList.contains('impact-input') ? 'impact-cell' : 'likelihood-cell'}`;
            }
        });

        const mapping = cobitMappings.DF3;
        const keys = Object.keys(grouped).sort((a, b) => a - b);
        
        let i = 0;
        for (const code in mapping) {
            let score = 0, baseline = 0;
            mapping[code].forEach((w, idx) => {
                let key = keys[idx];
                let r = (grouped[key]?.impact || 3) * (grouped[key]?.likelihood || 3);
                score += w * r;
                baseline += w * 9;
            });
            itemScores[i] = score;
            itemBaselines[i] = baseline;
            if (itemScoreHiddens[i]) itemScoreHiddens[i].value = score.toFixed(2);
            if (itemScoreDisplays[i]) itemScoreDisplays[i].textContent = score.toFixed(2);
            if (itemBaselineHiddens[i]) itemBaselineHiddens[i].value = baseline.toFixed(2);
            if (itemBaselineDisplays[i]) itemBaselineDisplays[i].textContent = baseline.toFixed(2);
            i++;
        }

        let totalVal = 0, count = 0;
        for (const k in grouped) {
            const rScore = grouped[k].impact * grouped[k].likelihood;
            totalVal += rScore;
            count++;
            
            const scoreTd = document.querySelectorAll('.score-display')[k];
            if (scoreTd) {
                scoreTd.textContent = rScore;
                scoreTd.className = `font-bold bg-white score-display bg-val-${Math.ceil(rScore / 5)}`;
            }
        }
        const totalBase = count * 9;
        const avgImp = totalVal / (count || 1);
        const avgBase = totalBase / (count || 1);
        const factor = avgBase / (avgImp || 1);

        const newChartData = [];
        itemScores.forEach((score, index) => {
            const base = itemBaselines[index] || 1;
            const raw = (factor * 100 * score) / base;
            const relImp = Math.round(raw / 5) * 5 - 100;
            newChartData.push(relImp);
            const relDisplay = document.querySelectorAll('.relative-importance')[index];
            if (relDisplay) {
                relDisplay.textContent = (relImp > 0 ? '+' : '') + relImp;
                relDisplay.className = 'relative-importance font-black text-lg ' + 
                    (relImp > 0 ? 'value-positive' : (relImp < 0 ? 'value-negative' : 'value-neutral'));
            }
        });
        setChartData(newChartData);
        window.updateCharts();
        window.updateRiskDisplays();
    };

    window.factorInitCharts = function(Chart, factorType, chartLabels, chartData) {
        const barCanvas = document.getElementById('barChart');
        const radarCanvas = document.getElementById('radarChart');
        if (!barCanvas || !radarCanvas) return null;
        const barCtx = barCanvas.getContext('2d');
        const radarCtx = radarCanvas.getContext('2d');
        const barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Relative Importance',
                    data: chartData,
                    backgroundColor: chartData.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)'),
                    borderColor: chartData.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)'),
                    borderWidth: 1
                }]
            },
            options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
                scales: { x: { min: -100, max: 100, grid: { color: '#e5e7eb' }, ticks: { stepSize: 25 } }, y: { grid: { display: false }, ticks: { font: { weight: 'bold' } } } }
            }
        });
        const radarChart = new Chart(radarCtx, {
            type: 'radar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Relative Importance',
                    data: chartData.map(v => v + 100),
                    backgroundColor: 'rgba(229, 180, 229, 0.3)',
                    borderColor: 'rgba(229, 180, 229, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(229, 180, 229, 1)',
                    pointRadius: 2
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
                scales: { r: { min: 0, max: 200, ticks: { stepSize: 50, callback: v => v - 100, backdropColor: 'transparent' }, pointLabels: { font: { size: 10, weight: 'bold' } } } }
            }
        });
        return { barChart, radarChart };
    };
</script>
@endpush

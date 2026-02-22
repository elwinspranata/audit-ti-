<!-- DF1 Input Table -->
<div class="mb-6 overflow-hidden light-card rounded-xl">
    <div class="p-4 border-b border-gray-200 bg-slate-50">
        <h2 class="text-xl font-bold text-green-600">
            {{ $factorInfo['title'] }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">{{ $factorInfo['description'] }}</p>
    </div>
    <div class="p-4 bg-white">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-12 overflow-x-auto min-w-0">
                <table class="strategic-table">
                    <thead>
                        <tr>
                            <th style="min-width: 350px;">Value</th>
                            <th style="min-width: 150px;">Importance (1-5)</th>
                            <th style="min-width: 100px;">Baseline</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($metadata as $key => $data)
                            <tr>
                                <td class="font-medium text-gray-700">{{ $data['name'] }}</td>
                                <td class="importance-cell">
                                    <input type="number" name="inputs[{{ $key }}][importance]"
                                        value="{{ data_get($designFactor->inputs, $key . '.importance', 3) }}"
                                        min="1" max="5"
                                        class="w-16 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 importance-input"
                                        data-key="{{ $key }}" {{ $designFactor->is_locked ? 'disabled readonly' : '' }}>
                                </td>
                                <td class="baseline-col">
                                    {{ data_get($designFactor->inputs, $key . '.baseline', 3) }}
                                    <input type="hidden" name="inputs[{{ $key }}][baseline]"
                                        value="{{ data_get($designFactor->inputs, $key . '.baseline', 3) }}" class="baseline-input">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                            
                            @php
                                $df1Mappings = [
                                    'EDM01' => [1, 1, 1.5, 1.5], 'EDM02' => [1, 2, 2.5, 2.5], 'EDM03' => [1, 1, 1.5, 1.5], 'EDM04' => [1, 1.5, 2.5, 2.5], 'EDM05' => [1.5, 1.5, 1.5, 1.5],
                                    'APO01' => [1, 1, 1, 1], 'APO02' => [3, 4, 1.5, 1], 'APO03' => [2, 3, 1.5, 1.5], 'APO04' => [1, 4, 1, 1], 'APO05' => [3, 4, 2, 2],
                                    'APO06' => [1, 1.5, 2.5, 2.5], 'APO07' => [1, 1.5, 1, 1.5], 'APO08' => [2, 2, 1.5, 1.5], 'APO09' => [1, 2, 2, 2.5], 'APO10' => [1, 1.5, 2, 2.5],
                                    'APO11' => [1.5, 1.5, 2, 2], 'APO12' => [1.5, 1.5, 1.5, 1.5], 'APO13' => [1, 1.5, 1.5, 1.5], 'APO14' => [1.5, 1.5, 0.5, 0.5], 'BAI01' => [2.5, 3, 1.5, 2],
                                    'BAI02' => [1, 1.5, 1, 1], 'BAI03' => [1, 1.5, 1, 1], 'BAI04' => [1, 2, 1.5, 1.5], 'BAI05' => [2, 3, 2, 1.5], 'BAI06' => [1.5, 1.5, 2, 1.5],
                                    'BAI07' => [1.5, 2, 1, 1.5], 'BAI08' => [2, 3, 1, 1.75], 'BAI09' => [1, 1, 1, 1], 'BAI10' => [1, 1, 1, 1], 'BAI11' => [2.5, 3, 2, 2.2],
                                    'DSS01' => [1, 1.5, 1, 1.5], 'DSS02' => [1, 2, 2, 2], 'DSS03' => [1, 2, 1.5, 1.5], 'DSS04' => [1, 2, 2, 2], 'DSS05' => [1, 1.5, 1, 1.2],
                                    'DSS06' => [1, 1.5, 1, 1], 'MEA01' => [1, 1, 1, 1], 'MEA02' => [1, 1, 1, 1], 'MEA03' => [1, 1, 1, 1], 'MEA04' => [1, 1, 1, 1],
                                ];
                                $m = $df1Mappings[$item->code] ?? [0,0,0,0];
                            @endphp
                            <input type="hidden" class="item-growth-value" value="{{ $m[0] }}">
                            <input type="hidden" class="item-innov-value" value="{{ $m[1] }}">
                            <input type="hidden" class="item-cost-value" value="{{ $m[2] }}">
                            <input type="hidden" class="item-stab-value" value="{{ $m[3] }}">
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
        const { factorType, cobitMappings, itemScores, itemBaselines, itemScoreHiddens, itemScoreDisplays, itemBaselineHiddens, itemBaselineDisplays, setChartData } = context;
        
        const growthVal = parseFloat(document.querySelector('input[name="inputs[growth][importance]"]')?.value) || 3;
        const innovVal = parseFloat(document.querySelector('input[name="inputs[innovation][importance]"]')?.value) || 3;
        const costVal = parseFloat(document.querySelector('input[name="inputs[cost][importance]"]')?.value) || 3;
        const stabVal = parseFloat(document.querySelector('input[name="inputs[stability][importance]"]')?.value) || 3;

        const mapping = cobitMappings.DF1;
        let i = 0;
        for (const code in mapping) {
            const mapRow = mapping[code];
            const newScore = (mapRow[0] * growthVal) + (mapRow[1] * innovVal) + (mapRow[2] * costVal) + (mapRow[3] * stabVal);
            const newBase = (mapRow[0] + mapRow[1] + mapRow[2] + mapRow[3]) * 3;
            itemScores[i] = newScore;
            itemBaselines[i] = newBase;
            if (itemScoreHiddens[i]) itemScoreHiddens[i].value = newScore.toFixed(2);
            if (itemScoreDisplays[i]) itemScoreDisplays[i].textContent = newScore.toFixed(2);
            if (itemBaselineHiddens[i]) itemBaselineHiddens[i].value = newBase.toFixed(2);
            if (itemBaselineDisplays[i]) itemBaselineDisplays[i].textContent = newBase.toFixed(2);
            i++;
        }

        const totalVal = (growthVal + innovVal + costVal + stabVal) / 4;
        const totalBase = 3;
        const factor = totalBase / (totalVal || 1);

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
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { min: -100, max: 100, grid: { color: '#e5e7eb' }, ticks: { stepSize: 25 } },
                    y: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
                }
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
            options: {
                responsive: true,
                maintainAspectRatio: false,
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

        return { barChart, radarChart };
    };
</script>
@endpush

<!-- DF4 Input Table (Icons) -->
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
                            <th class="w-12 text-center">No.</th>
                            <th class="text-center">IT-Related Issue Description</th>
                            <th class="text-center">Issue Importance</th>
                            <th class="w-24 text-center">Baseline</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($metadata as $key => $data)
                            @php
                                $importance = data_get($designFactor->inputs, $key . '.importance', 2);
                            @endphp
                            <tr>
                                <td class="text-center font-bold">{{ $loop->iteration }}</td>
                                <td class="text-left font-medium">{{ $data['name'] }}</td>
                                <td class="df4-importance-cell">
                                    <div class="flex items-center justify-center gap-4">
                                        <label class="flex flex-col items-center cursor-pointer">
                                            <input type="radio" name="inputs[{{ $key }}][importance]"
                                                value="3" class="importance-icon-radio red"
                                                {{ $importance == 3 ? 'checked' : '' }}
                                                {{ $designFactor->is_locked ? 'disabled' : '' }}>
                                            <span class="text-xs mt-1">H</span>
                                        </label>
                                        <label class="flex flex-col items-center cursor-pointer">
                                            <input type="radio" name="inputs[{{ $key }}][importance]"
                                                value="2" class="importance-icon-radio yellow"
                                                {{ $importance == 2 ? 'checked' : '' }}
                                                {{ $designFactor->is_locked ? 'disabled' : '' }}>
                                            <span class="text-xs mt-1">M</span>
                                        </label>
                                        <label class="flex flex-col items-center cursor-pointer">
                                            <input type="radio" name="inputs[{{ $key }}][importance]"
                                                value="1" class="importance-icon-radio green"
                                                {{ $importance == 1 ? 'checked' : '' }}
                                                {{ $designFactor->is_locked ? 'disabled' : '' }}>
                                            <span class="text-xs mt-1">L</span>
                                        </label>
                                        <label class="flex flex-col items-center cursor-pointer">
                                            <input type="radio" name="inputs[{{ $key }}][importance]"
                                                value="0"
                                                class="importance-icon-radio border-gray-400 bg-gray-100"
                                                {{ $importance == 0 ? 'checked' : '' }}
                                                {{ $designFactor->is_locked ? 'disabled' : '' }}>
                                            <span class="text-xs mt-1">N/A</span>
                                        </label>
                                    </div>
                                </td>
                                <td class="bg-gray-100 font-bold">2</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Legend container for DF4 -->
            <div class="w-full lg:col-span-3 xl:col-span-2">
                <div class="border border-gray-400 overflow-hidden shadow-sm">
                    <div class="bg-white p-3 border-b border-gray-400 flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full"
                            style="background-color: #70ad47; border: 2px solid #000;"></div>
                        <span class="text-sm font-bold text-gray-800">No Issue</span>
                    </div>
                    <div class="bg-white p-3 border-b border-gray-400 flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full"
                            style="background-color: #ffc000; border: 2px solid #000;"></div>
                        <span class="text-sm font-bold text-gray-800">Issue</span>
                    </div>
                    <div class="bg-white p-3 flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full"
                            style="background-color: #c00000; border: 2px solid #000;"></div>
                        <span class="text-sm font-bold text-gray-800">Serious Issue</span>
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
                            @php
                                $df4Baselines = [
                                    'EDM01' => 70, 'EDM02' => 70, 'EDM03' => 47, 'EDM04' => 67, 'EDM05' => 41,
                                    'APO01' => 56, 'APO02' => 50, 'APO03' => 66, 'APO04' => 32, 'APO05' => 68,
                                    'APO06' => 62, 'APO07' => 47, 'APO08' => 70, 'APO09' => 43, 'APO10' => 39,
                                    'APO11' => 43, 'APO12' => 52, 'APO13' => 33, 'APO14' => 60, 'BAI01' => 35,
                                    'BAI02' => 51, 'BAI03' => 41, 'BAI04' => 23, 'BAI05' => 28, 'BAI06' => 42,
                                    'BAI07' => 38, 'BAI08' => 31, 'BAI09' => 23, 'BAI10' => 25, 'BAI11' => 45,
                                    'DSS01' => 27, 'DSS02' => 33, 'DSS03' => 32, 'DSS04' => 21, 'DSS05' => 29,
                                    'DSS06' => 29, 'MEA01' => 61, 'MEA02' => 48, 'MEA03' => 29, 'MEA04' => 58,
                                ];
                            @endphp
                            {{ number_format($df4Baselines[$item->code] ?? $item->baseline_score, 2) }}
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
        
        const mapping = cobitMappings.DF4;
        const inputs = {};
        document.querySelectorAll('.importance-icon-radio:checked').forEach(inp => {
            const name = inp.name;
            const keyMatch = name.match(/inputs\[(.*?)\]/);
            if (keyMatch) inputs[keyMatch[1]] = parseFloat(inp.value) || 0;
        });

        const issueKeys = Object.keys(inputs).sort();
        const gmoCodes = Object.keys(cobitMappings.DF1);
        
        gmoCodes.forEach((code, gIdx) => {
            let score = 0, baseline = 0;
            const mapRow = mapping[code] || [];
            issueKeys.forEach((key, idx) => {
                let w = mapRow[idx] || 0;
                score += w * (inputs[key] || 0);
                baseline += w * 2;
            });
            itemScores[gIdx] = score;
            itemBaselines[gIdx] = baseline;
            if (itemScoreHiddens[gIdx]) itemScoreHiddens[gIdx].value = score.toFixed(2);
            if (itemScoreDisplays[gIdx]) itemScoreDisplays[gIdx].textContent = score.toFixed(2);
            if (itemBaselineHiddens[gIdx]) itemBaselineHiddens[gIdx].value = baseline.toFixed(2);
            if (itemBaselineDisplays[gIdx]) itemBaselineDisplays[gIdx].textContent = baseline.toFixed(2);
        });

        let totalImp = 0;
        for(let k in inputs) totalImp += inputs[k];
        const totalVal = totalImp;
        const count = issueKeys.length;
        const totalBase = count * 2;
        
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

    document.querySelectorAll('.importance-icon-radio').forEach(radio => {
        radio.addEventListener('change', () => window.calculate());
    });
</script>
@endpush

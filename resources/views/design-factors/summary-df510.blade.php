<x-app-layout>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="min-h-screen py-8 bg-gray-100">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Design Factor Canvas</h1>
                <p class="mt-2 text-gray-600">Summary of Design Factors 5-10</p>
            </div>

            <!-- Navigation Tabs -->
            <div class="flex flex-wrap justify-center gap-2 mb-8">
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
                        $isCompleted = isset($progress[$tabType]) && $progress[$tabType]['completed'];
                    @endphp
                    <a href="{{ $isAccessible ? route('design-factors.index', $tabType) : '#' }}" class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
                                                                                bg-white text-gray-600 hover:bg-gray-200"
                        {{ !$isAccessible ? 'onclick="return false;"' : '' }}>
                        {{ $tabLabel }}
                        @if($isCompleted)
                            <span class="text-lg">✅</span>
                        @endif
                    </a>
                @endforeach

                {{-- Summary Tab (DF1-DF4) --}}
                @php
                    $summaryAccessible = isset($progress['Summary']) && $progress['Summary']['accessible'];
                @endphp
                <a href="{{ $summaryAccessible ? route('design-factors.summary') : '#' }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
                    {{ $summaryAccessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60' }}" {{ !$summaryAccessible ? 'onclick="return false;"' : '' }}>
                    Summary
                </a>

                {{-- DF5 Tab --}}
                @php
                    $df5Accessible = isset($progress['DF5']) && $progress['DF5']['accessible'];
                    $df5Completed = isset($progress['DF5']) && $progress['DF5']['completed'];
                @endphp
                <a href="{{ $df5Accessible ? route('design-factors.index', 'DF5') : '#' }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
                    {{ $df5Accessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60' }}" {{ !$df5Accessible ? 'onclick="return false;"' : '' }}>
                    DF5: Governance Obj.
                    @if($df5Completed)
                        <span class="text-lg">✅</span>
                    @endif
                </a>

                @php
                    $otherTabs = [
                        'DF6' => 'DF6: Threat Landscape',
                        'DF7' => 'DF7: Importance of Role of IT',
                        'DF8' => 'DF8: Sourcing Model',
                        'DF9' => 'DF9: IT Implementation',
                        'DF10' => 'DF10: Tech Adoption',
                    ];
                @endphp

                @foreach($otherTabs as $tabType => $tabLabel)
                    @php
                        $isAccessible = isset($progress[$tabType]) && $progress[$tabType]['accessible'];
                        $isCompleted = isset($progress[$tabType]) && $progress[$tabType]['completed'];
                    @endphp
                    <a href="{{ $isAccessible ? route('design-factors.index', $tabType) : '#' }}"
                        class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
                            {{ $isAccessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60' }}" {{ !$isAccessible ? 'onclick="return false;"' : '' }}>
                        {{ $tabLabel }}
                        @if($isCompleted)
                            <span class="text-lg">✅</span>
                        @endif
                    </a>
                @endforeach

                {{-- Summary DF5-DF10 Tab (Active) --}}
                <a href="#"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2 bg-blue-600 text-white shadow-lg">
                    📊 Summary
                </a>
            </div>

            <!-- Canvas Chart - Aggregated Bar Chart -->
            <div class="mb-8 overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                <div class="p-6 border-b border-gray-200 bg-slate-50">
                    <h2 class="text-xl font-bold text-gray-800">Final Aggregated Importance</h2>
                    <p class="text-sm text-gray-600">Sum of relative importance scores from all Design Factors.</p>
                </div>
                <div class="p-6">
                    <div class="relative" style="height: 600px;">
                        <canvas id="summaryCanvas"></canvas>
                    </div>
                </div>
            </div>

            <!-- DF5-DF10 Radar Charts Section -->
            <div class="mb-8">
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-bold text-gray-800">Design Factors 5-10 Radar Charts</h2>
                    <p class="mt-2 text-sm text-gray-600">Resulting Governance/Management Objectives Importance</p>
                </div>

                <!-- 3x2 Grid for DF5-DF10 Radar Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- DF5 Radar Chart -->
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="p-4 border-b border-gray-200 bg-blue-50">
                            <h3 class="text-lg font-bold text-gray-800">Design Factor 5 <span
                                    class="text-sm font-normal italic">Governance Objectives</span></h3>
                            <p class="text-xs text-gray-600">Resulting Governance/Management Objectives Importance</p>
                        </div>
                        <div class="p-6">
                            <div class="relative" style="height: 500px;">
                                <canvas id="df5RadarChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- DF6 Radar Chart -->
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="p-4 border-b border-gray-200 bg-blue-50">
                            <h3 class="text-lg font-bold text-gray-800">Design Factor 6 <span
                                    class="text-sm font-normal italic">Threat Landscape</span></h3>
                            <p class="text-xs text-gray-600">Resulting Governance/Management Objectives Importance</p>
                        </div>
                        <div class="p-6">
                            <div class="relative" style="height: 500px;">
                                <canvas id="df6RadarChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- DF7 Radar Chart -->
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="p-4 border-b border-gray-200 bg-blue-50">
                            <h3 class="text-lg font-bold text-gray-800">Design Factor 7 <span
                                    class="text-sm font-normal italic">Role of IT</span></h3>
                            <p class="text-xs text-gray-600">Resulting Governance/Management Objectives Importance</p>
                        </div>
                        <div class="p-6">
                            <div class="relative" style="height: 500px;">
                                <canvas id="df7RadarChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- DF8 Radar Chart -->
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="p-4 border-b border-gray-200 bg-blue-50">
                            <h3 class="text-lg font-bold text-gray-800">Design Factor 8 <span
                                    class="text-sm font-normal italic">Sourcing Model</span></h3>
                            <p class="text-xs text-gray-600">Resulting Governance/Management Objectives Importance</p>
                        </div>
                        <div class="p-6">
                            <div class="relative" style="height: 500px;">
                                <canvas id="df8RadarChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- DF9 Radar Chart -->
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="p-4 border-b border-gray-200 bg-blue-50">
                            <h3 class="text-lg font-bold text-gray-800">Design Factor 9 <span
                                    class="text-sm font-normal italic">IT Implementation</span></h3>
                            <p class="text-xs text-gray-600">Resulting Governance/Management Objectives Importance</p>
                        </div>
                        <div class="p-6">
                            <div class="relative" style="height: 500px;">
                                <canvas id="df9RadarChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- DF10 Radar Chart -->
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="p-4 border-b border-gray-200 bg-blue-50">
                            <h3 class="text-lg font-bold text-gray-800">Design Factor 10 <span
                                    class="text-sm font-normal italic">Technology Adoption</span></h3>
                            <p class="text-xs text-gray-600">Resulting Governance/Management Objectives Importance</p>
                        </div>
                        <div class="p-6">
                            <div class="relative" style="height: 500px;">
                                <canvas id="df10RadarChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Aggregated Bar Chart
                const ctx = document.getElementById('summaryCanvas').getContext('2d');
                const results = @json($results);
                const labels = Object.keys(results);
                const data = Object.values(results);

                // Determine bar colors based on value
                const backgroundColors = data.map(value => value >= 0 ? 'rgba(75, 192, 192, 0.6)' : 'rgba(255, 99, 132, 0.6)');
                const borderColors = data.map(value => value >= 0 ? 'rgba(75, 192, 192, 1)' : 'rgba(255, 99, 132, 1)');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Relative Importance Score',
                            data: data,
                            backgroundColor: backgroundColors,
                            borderColor: borderColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y',
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: { color: '#e5e7eb' }
                            },
                            y: {
                                grid: { display: false },
                                ticks: {
                                    font: { size: 11 }
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return context.dataset.label + ': ' + context.raw;
                                    }
                                }
                            }
                        }
                    }
                });

                // Helper function to create radar chart
                function createRadarChart(canvasId, data, title, color) {
                    const ctx = document.getElementById(canvasId).getContext('2d');
                    const labels = data.map(item => item.code);
                    const values = data.map(item => item.relative_importance + 100); // Shift by 100 to handle negatives

                    new Chart(ctx, {
                        type: 'radar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: title,
                                data: values,
                                backgroundColor: color.background,
                                borderColor: color.border,
                                borderWidth: 2,
                                pointBackgroundColor: color.border,
                                pointBorderColor: '#fff',
                                pointHoverBackgroundColor: '#fff',
                                pointHoverBorderColor: color.border,
                                pointRadius: 3,
                                pointHoverRadius: 5
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                r: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 200,
                                    ticks: {
                                        stepSize: 20,
                                        font: { size: 10 },
                                        callback: function (value) {
                                            return value - 100; // Show actual values (-100 to +100)
                                        }
                                    },
                                    grid: {
                                        color: 'rgba(200, 200, 200, 0.3)'
                                    },
                                    pointLabels: {
                                        font: { size: 9 },
                                        color: '#374151'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            const actualValue = context.raw - 100;
                                            return context.label + ': ' + (actualValue > 0 ? '+' : '') + actualValue;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // DF5-DF10 Radar Charts Data
                const df5Data = @json($df5Data);
                const df6Data = @json($df6Data);
                const df7Data = @json($df7Data);
                const df8Data = @json($df8Data);
                const df9Data = @json($df9Data);
                const df10Data = @json($df10Data);

                // Create DF5-DF10 radar charts with blue/teal/green color scheme
                if (df5Data.length > 0) {
                    createRadarChart('df5RadarChart', df5Data, 'DF5: Governance Objectives', {
                        background: 'rgba(59, 130, 246, 0.2)',
                        border: 'rgba(59, 130, 246, 1)'
                    });
                }

                if (df6Data.length > 0) {
                    createRadarChart('df6RadarChart', df6Data, 'DF6: Threat Landscape', {
                        background: 'rgba(14, 165, 233, 0.2)',
                        border: 'rgba(14, 165, 233, 1)'
                    });
                }

                if (df7Data.length > 0) {
                    createRadarChart('df7RadarChart', df7Data, 'DF7: Role of IT', {
                        background: 'rgba(6, 182, 212, 0.2)',
                        border: 'rgba(6, 182, 212, 1)'
                    });
                }

                if (df8Data.length > 0) {
                    createRadarChart('df8RadarChart', df8Data, 'DF8: Sourcing Model', {
                        background: 'rgba(20, 184, 166, 0.2)',
                        border: 'rgba(20, 184, 166, 1)'
                    });
                }

                if (df9Data.length > 0) {
                    createRadarChart('df9RadarChart', df9Data, 'DF9: IT Implementation', {
                        background: 'rgba(16, 185, 129, 0.2)',
                        border: 'rgba(16, 185, 129, 1)'
                    });
                }

                if (df10Data.length > 0) {
                    createRadarChart('df10RadarChart', df10Data, 'DF10: Technology Adoption', {
                        background: 'rgba(34, 197, 94, 0.2)',
                        border: 'rgba(34, 197, 94, 1)'
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
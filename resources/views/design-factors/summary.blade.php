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
                                                                        bg-white text-gray-600 hover:bg-gray-200" {{ !$isAccessible ? 'onclick="return false;"' : '' }}>
                        {{ $tabLabel }}
                        @if($isCompleted)
                            <span class="text-lg">✅</span>
                        @endif
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
            </div>

            <!-- Canvas Chart -->
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

            <!-- Radar Charts Section -->
            <div class="mb-8">
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-bold text-gray-800">Radar Charts</h2>
                    <p class="mt-2 text-sm text-gray-600">Resulting Governance/Management Objectives Importance</p>
                </div>

                <!-- 2x2 Grid for Radar Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- DF1 Radar Chart -->
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="p-4 border-b border-gray-200 bg-slate-50">
                            <h3 class="text-lg font-bold text-gray-800">Design Factor 1 <span
                                    class="text-sm font-normal italic">Enterprise Strategy</span></h3>
                            <p class="text-xs text-gray-600">Resulting Governance/Management Objectives Importance</p>
                        </div>
                        <div class="p-6">
                            <div class="relative" style="height: 500px;">
                                <canvas id="df1RadarChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- DF2 Radar Chart -->
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="p-4 border-b border-gray-200 bg-slate-50">
                            <h3 class="text-lg font-bold text-gray-800">Design Factor 2 <span
                                    class="text-sm font-normal italic">Enterprise Goals</span></h3>
                            <p class="text-xs text-gray-600">Resulting Governance/Management Objectives Importance</p>
                        </div>
                        <div class="p-6">
                            <div class="relative" style="height: 500px;">
                                <canvas id="df2RadarChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- DF3 Radar Chart -->
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="p-4 border-b border-gray-200 bg-slate-50">
                            <h3 class="text-lg font-bold text-gray-800">Design Factor 3 <span
                                    class="text-sm font-normal italic">Risk Profile</span></h3>
                            <p class="text-xs text-gray-600">Resulting Governance/Management Objectives Importance</p>
                        </div>
                        <div class="p-6">
                            <div class="relative" style="height: 500px;">
                                <canvas id="df3RadarChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- DF4 Radar Chart -->
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="p-4 border-b border-gray-200 bg-slate-50">
                            <h3 class="text-lg font-bold text-gray-800">Design Factor 4 <span
                                    class="text-sm font-normal italic">IT-Related Issues</span></h3>
                            <p class="text-xs text-gray-600">Resulting Governance/Management Objectives Importance</p>
                        </div>
                        <div class="p-6">
                            <div class="relative" style="height: 500px;">
                                <canvas id="df4RadarChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Lock and Continue Buttons -->
            <div class="mt-8 mb-8">
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
                                <!-- Lock Button -->
                                <form id="lockForm" action="{{ route('design-factors.lock-summary') }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="button" onclick="confirmLock()"
                                        class="px-8 py-3 text-white transition-all bg-red-600 rounded-lg shadow-md hover:bg-red-700 hover:shadow-lg">
                                        <i class="mr-2 fas fa-lock"></i>
                                        Simpan dan Kunci DF1-DF4
                                    </button>
                                </form>

                                <!-- Continue Button (Disabled) -->
                                <button disabled
                                    class="px-8 py-3 text-gray-400 transition-all bg-gray-300 rounded-lg shadow-md cursor-not-allowed opacity-60">
                                    <i class="mr-2 fas fa-arrow-right"></i>
                                    Lanjut ke DF5
                                </button>
                            @else
                                <!-- Lock Button (Already Locked) -->
                                <button disabled
                                    class="px-8 py-3 text-gray-400 transition-all bg-gray-300 rounded-lg shadow-md cursor-not-allowed opacity-60">
                                    <i class="mr-2 fas fa-lock"></i>
                                    DF1-DF4 Sudah Dikunci
                                </button>

                                <!-- Continue Button (Enabled) -->
                                <a href="{{ route('design-factors.index', 'DF5') }}"
                                    class="inline-block px-8 py-3 text-white transition-all bg-green-600 rounded-lg shadow-md hover:bg-green-700 hover:shadow-lg">
                                    <i class="mr-2 fas fa-arrow-right"></i>
                                    Lanjut ke DF5
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
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
                        indexAxis: 'y', // Horizontal bars for readability of 40 items
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

                // Create DF1-DF4 Radar Charts
                const df1Data = @json($df1Data);
                const df2Data = @json($df2Data);
                const df3Data = @json($df3Data);
                const df4Data = @json($df4Data);

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

                // Create all 4 radar charts with different colors
                if (df1Data.length > 0) {
                    createRadarChart('df1RadarChart', df1Data, 'DF1: Enterprise Strategy', {
                        background: 'rgba(147, 51, 234, 0.2)',
                        border: 'rgba(147, 51, 234, 1)'
                    });
                }

                if (df2Data.length > 0) {
                    createRadarChart('df2RadarChart', df2Data, 'DF2: Enterprise Goals', {
                        background: 'rgba(139, 92, 246, 0.2)',
                        border: 'rgba(139, 92, 246, 1)'
                    });
                }

                if (df3Data.length > 0) {
                    createRadarChart('df3RadarChart', df3Data, 'DF3: Risk Profile', {
                        background: 'rgba(168, 85, 247, 0.2)',
                        border: 'rgba(168, 85, 247, 1)'
                    });
                }

                if (df4Data.length > 0) {
                    createRadarChart('df4RadarChart', df4Data, 'DF4: IT-Related Issues', {
                        background: 'rgba(126, 34, 206, 0.2)',
                        border: 'rgba(126, 34, 206, 1)'
                    });
                }


            });

            // Confirmation dialog for locking DF1-DF4
            window.confirmLock = function () {
                Swal.fire({
                    title: 'Kunci DF1-DF4?',
                    html: `
                                            <p class="text-gray-700">Anda akan mengunci <strong>DF1, DF2, DF3, dan DF4</strong> secara permanen.</p>
                                            <p class="mt-2 text-red-600"><strong>Peringatan:</strong> Setelah dikunci, data tidak dapat diubah lagi!</p>
                                        `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Kunci Sekarang!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('lockForm').submit();
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
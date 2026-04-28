<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Capability Level Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Filter Section --}}
                    <div class="mb-6">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Filter Options</h6>
                        </div>
                        <div class="card-body">
                            <form id="filterForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select User / Organization</label>
                                            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="user_id" name="user_id">
                                                <option value="">-- Choose User --</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
                                            <input type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="start_date" name="start_date">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Date</label>
                                            <input type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="end_date" name="end_date">
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <div class="form-group w-100">
                                            <button type="button" class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800 w-full" onclick="loadChart()">
                                                <i class="fas fa-search"></i> Generate
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Chart Section --}}
                    <div class="card shadow mb-4" id="chartCard" style="display:none;">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Capability Level Chart</h6>
                            <div x-data="{ open: false }" class="relative inline-block text-left">
                                <div>
                                    <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-500 text-sm font-medium text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <i class="fas fa-download mr-2 mt-1"></i> Export
                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" style="display: none;">
                                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                        <a href="#" @click.prevent="open=false; exportData('csv')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Export CSV</a>
                                        <a href="#" @click.prevent="open=false; exportData('excel')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Export Excel</a>
                                        <a href="#" @click.prevent="open=false; exportData('pdf')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Export PDF (Print)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-bar" style="position: relative; height:40vh; width:80vw">
                                <canvas id="myBarChart"></canvas>
                            </div>
                            <hr>
                            <div class="text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle text-primary"></i> Cobit Items
                                </span>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var myBarChart;

        function loadChart() {
            var userId = document.getElementById('user_id').value;
            var startDate = document.getElementById('start_date').value;
            var endDate = document.getElementById('end_date').value;

            if (!userId) {
                alert('Please select a user');
                return;
            }

            // Show card
            document.getElementById('chartCard').style.display = 'block';

            fetch(`{{ route('report.data') }}?user_id=${userId}&start_date=${startDate}&end_date=${endDate}`)
                .then(response => response.json())
                .then(data => {
                    renderChart(data.labels, data.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load data');
                });
        }

        function renderChart(labels, data) {
            var ctx = document.getElementById("myBarChart");
            
            if (myBarChart) {
                myBarChart.destroy();
            }

            myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Capability Level",
                        backgroundColor: "#4e73df",
                        hoverBackgroundColor: "#2e59d9",
                        borderColor: "#4e73df",
                        data: data,
                        barPercentage: 0.5,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 20
                            },
                            maxBarThickness: 50,
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                max: 5,
                                stepSize: 1, // Fix step size to integers
                                maxTicksLimit: 6,
                                padding: 10,
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }],
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem, chart) {
                                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ': Level ' + tooltipItem.yLabel;
                            }
                        }
                    },
                }
            });
        }

        function exportData(type) {
            var userId = document.getElementById('user_id').value;
            var startDate = document.getElementById('start_date').value;
            var endDate = document.getElementById('end_date').value;

            if (!userId) {
                alert('Please select a user first');
                return;
            }

            var url = `{{ route('report.export') }}?type=${type}&user_id=${userId}&start_date=${startDate}&end_date=${endDate}`;
            window.open(url, '_blank');
        }
    </script>
    @endpush
</x-app-layout>

<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="p-3 shadow-lg rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-transparent bg-gradient-to-r from-purple-600 to-indigo-500 bg-clip-text">
                {{ __('Capability Level Report') }}
            </h2>
        </div>
    </x-slot>

    <style>
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.5s ease-out forwards; }
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
            
            {{-- Overall Statistics Cards --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 animate-fadeInUp">
                <div class="p-6 bg-white shadow-xl stat-card dark:bg-slate-800/70 rounded-2xl dark:border dark:border-purple-700/30">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $overallStats['totalUsers'] }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/50">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 bg-white shadow-xl stat-card dark:bg-slate-800/70 rounded-2xl dark:border dark:border-green-700/30">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Subscriptions</p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $overallStats['activeSubscriptions'] }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/50">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 bg-white shadow-xl stat-card dark:bg-slate-800/70 rounded-2xl dark:border dark:border-blue-700/30">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Proses TI</p>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $overallStats['totalProsesTI'] }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/50">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 bg-white shadow-xl stat-card dark:bg-slate-800/70 rounded-2xl dark:border dark:border-amber-700/30">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Draft Pending</p>
                            <p class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $overallStats['pendingDrafts'] }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-amber-100 dark:bg-amber-900/50">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Filter Section --}}
            <div class="p-6 bg-white shadow-xl dark:bg-slate-800/70 rounded-2xl dark:border dark:border-purple-700/30 animate-fadeInUp">
                <h3 class="mb-4 text-lg font-bold text-gray-800 dark:text-purple-300">Filter Report</h3>
                <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                    <div class="flex-1">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih User/Organisasi</label>
                        <select name="user_id" id="user_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->company_name ?? $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" 
                            class="w-full px-6 py-3 text-white transition-all transform rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 hover:scale-105 shadow-lg">
                            <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Tampilkan Report
                        </button>
                    </div>
                </form>
            </div>
            
            @if($selectedUser)
                {{-- User Summary --}}
                <div class="p-6 bg-gradient-to-r from-purple-600 to-indigo-600 shadow-xl rounded-2xl animate-fadeInUp">
                    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                        <div class="text-white">
                            <h3 class="text-2xl font-bold">{{ $selectedUser->name }}</h3>
                            <p class="opacity-90">{{ $selectedUser->company_name ?? $selectedUser->email }}</p>
                            <div class="flex flex-wrap gap-4 mt-3 text-sm">
                                <span class="px-3 py-1 bg-white/20 rounded-full">📅 Registrasi: {{ $summaryStats['registrationDate'] }}</span>
                                <span class="px-3 py-1 bg-white/20 rounded-full">⏰ Berakhir: {{ $summaryStats['subscriptionEnd'] }}</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('admin.reports.exportPdf', ['user_id' => $selectedUser->id]) }}" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-purple-600 bg-white rounded-lg hover:bg-gray-100 transition-all">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                PDF
                            </a>
                            <a href="{{ route('admin.reports.exportExcel', ['user_id' => $selectedUser->id]) }}" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-600 bg-white rounded-lg hover:bg-gray-100 transition-all">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Excel
                            </a>
                            <a href="{{ route('admin.reports.exportCsv', ['user_id' => $selectedUser->id]) }}" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-white rounded-lg hover:bg-gray-100 transition-all">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                CSV
                            </a>
                        </div>
                    </div>
                </div>
                
                {{-- Summary Stats Cards --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 animate-fadeInUp">
                    <div class="p-6 bg-white shadow-xl dark:bg-slate-800/70 rounded-2xl dark:border dark:border-blue-700/30 text-center">
                        <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $summaryStats['totalProses'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Proses TI</p>
                    </div>
                    <div class="p-6 bg-white shadow-xl dark:bg-slate-800/70 rounded-2xl dark:border dark:border-green-700/30 text-center">
                        <p class="text-4xl font-bold text-green-600 dark:text-green-400">{{ $summaryStats['completedProses'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Proses dengan Progress</p>
                    </div>
                    <div class="p-6 bg-white shadow-xl dark:bg-slate-800/70 rounded-2xl dark:border dark:border-purple-700/30 text-center">
                        <p class="text-4xl font-bold text-purple-600 dark:text-purple-400">{{ $summaryStats['avgCapability'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Rata-rata Capability Level</p>
                    </div>
                </div>
                
                {{-- Capability Level Chart --}}
                <div class="p-6 bg-white shadow-xl dark:bg-slate-800/70 rounded-2xl dark:border dark:border-purple-700/30 animate-fadeInUp">
                    <h3 class="mb-6 text-lg font-bold text-gray-800 dark:text-purple-300">📊 Grafik Capability Level per Proses TI</h3>
                    <div class="relative" style="height: 400px;">
                        <canvas id="capabilityChart"></canvas>
                    </div>
                </div>
                
                {{-- Detailed Table --}}
                <div class="p-6 bg-white shadow-xl dark:bg-slate-800/70 rounded-2xl dark:border dark:border-purple-700/30 animate-fadeInUp">
                    <h3 class="mb-6 text-lg font-bold text-gray-800 dark:text-purple-300">📋 Detail Capability Level</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                            <thead class="bg-gray-50 dark:bg-slate-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Proses TI</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Capability Level</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Visual</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                                @foreach($capabilityData as $index => $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $item['nama_item'] }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold
                                                @if($item['capability_level'] == 0) bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300
                                                @elseif($item['capability_level'] == 1) bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-300
                                                @elseif($item['capability_level'] == 2) bg-orange-100 text-orange-600 dark:bg-orange-900/50 dark:text-orange-300
                                                @elseif($item['capability_level'] == 3) bg-yellow-100 text-yellow-600 dark:bg-yellow-900/50 dark:text-yellow-300
                                                @elseif($item['capability_level'] == 4) bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-300
                                                @else bg-green-100 text-green-600 dark:bg-green-900/50 dark:text-green-300
                                                @endif">
                                                Level {{ $item['capability_level'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center space-x-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold
                                                        @if($i <= $item['capability_level']) bg-gradient-to-r from-purple-500 to-indigo-500 text-white
                                                        @else bg-gray-200 dark:bg-slate-600 text-gray-400 dark:text-gray-500
                                                        @endif">
                                                        {{ $i }}
                                                    </div>
                                                @endfor
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{-- Chart.js Script --}}
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('capabilityChart').getContext('2d');
                        
                        const labels = @json(collect($capabilityData)->pluck('nama_item'));
                        const data = @json(collect($capabilityData)->pluck('capability_level'));
                        
                        // Generate gradient colors
                        const colors = data.map(level => {
                            if (level === 0) return 'rgba(156, 163, 175, 0.8)';
                            if (level === 1) return 'rgba(239, 68, 68, 0.8)';
                            if (level === 2) return 'rgba(249, 115, 22, 0.8)';
                            if (level === 3) return 'rgba(234, 179, 8, 0.8)';
                            if (level === 4) return 'rgba(59, 130, 246, 0.8)';
                            return 'rgba(34, 197, 94, 0.8)';
                        });
                        
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Capability Level',
                                    data: data,
                                    backgroundColor: colors,
                                    borderColor: colors.map(c => c.replace('0.8', '1')),
                                    borderWidth: 2,
                                    borderRadius: 8,
                                    barThickness: 40,
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return 'Capability Level: ' + context.raw;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        max: 5,
                                        ticks: {
                                            stepSize: 1,
                                            callback: function(value) {
                                                return 'Level ' + value;
                                            }
                                        },
                                        grid: {
                                            color: 'rgba(156, 163, 175, 0.2)'
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            maxRotation: 45,
                                            minRotation: 45
                                        }
                                    }
                                }
                            }
                        });
                    });
                </script>
            @else
                {{-- No User Selected --}}
                <div class="p-12 bg-white shadow-xl dark:bg-slate-800/70 rounded-2xl dark:border dark:border-purple-700/30 text-center animate-fadeInUp">
                    <div class="flex items-center justify-center w-20 h-20 mx-auto mb-6 bg-purple-100 dark:bg-purple-900/50 rounded-full">
                        <svg class="w-10 h-10 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Pilih User untuk Melihat Report</h3>
                    <p class="text-gray-500 dark:text-gray-400">Gunakan filter di atas untuk memilih user/organisasi dan melihat grafik capability level.</p>
                </div>
            @endif
            
        </div>
    </div>
</x-admin-layout>

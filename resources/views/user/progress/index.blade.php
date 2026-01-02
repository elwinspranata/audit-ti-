<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="text-3xl font-bold leading-tight tracking-wide text-gray-800 dark:text-white">
            {{ __('Progres Kuesioner Saya') }}
        </h2>
        <h2 class="text-2xl font-bold leading-tight tracking-tight text-gray-800 dark:text-white">
            {{ __('Progres Kuesioner Saya') }}
        </h2>
    </x-slot> --}}

    <style>
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.02);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200px 0;
            }

            100% {
                background-position: calc(200px + 100%) 0;
            }
        }

        @keyframes progressStripes {
            from {
                background-position: 20px 0;
            }

            to {
                background-position: 0 0;
            }
        }

        .animate-fadeInDown {
            animation: fadeInDown 0.5s ease-out forwards;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        .animate-slideInLeft {
            animation: slideInLeft 0.4s ease-out forwards;
        }

        .animate-pulse-subtle {
            animation: pulse 3s infinite;
        }

        .progress-bar-animated {
            position: relative;
            overflow: hidden;
        }

        .progress-bar-animated::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background-image: linear-gradient(-45deg,
                    rgba(255, 255, 255, 0.2) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(255, 255, 255, 0.2) 50%,
                    rgba(255, 255, 255, 0.2) 75%,
                    transparent 75%,
                    transparent);
            background-size: 20px 20px;
            animation: progressStripes 1s linear infinite;
            border-radius: inherit;
        }

        .progress-shimmer {
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.3),
                    transparent);
            background-size: 200px 100%;
            animation: shimmer 2s infinite;
        }

        .glass-effect {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dark .glass-effect {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .dark .card-hover:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        [x-cloak] {
            display: none !important;
        }

        .progress-circle {
            stroke-dasharray: 283;
            stroke-dashoffset: 283;
            transition: stroke-dashoffset 1s ease-in-out;
        }

        .tab-button {
            position: relative;
            overflow: hidden;
        }

        .tab-button::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: exclude;
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .tab-button.active::before {
            opacity: 1;
        }

        .status-badge {
            position: relative;
            overflow: hidden;
        }

        .status-badge::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, currentColor, transparent);
            opacity: 0.1;
            border-radius: inherit;
        }

        .metric-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dark .metric-card {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.1));
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>

    <div
        class="min-h-screen py-6 bg-slate-950 dark:bg-gray-900 bg-gradient-to-br from-slate-950 via-gray-900 to-slate-900">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8 animate-fadeInDown">
                <div class="relative overflow-hidden shadow-2xl glass-effect rounded-3xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 via-purple-600/5 to-pink-600/10">
                    </div>
                    <div class="relative p-8">
                        <div
                            class="flex flex-col items-start justify-between space-y-6 lg:flex-row lg:items-center lg:space-y-0">
                            <div class="flex-1">
                                <h1
                                    class="text-4xl font-bold text-transparent bg-gradient-to-r from-blue-600 via-purple-600 to-purple-600 bg-clip-text">
                                    Halo, {{ $user->name }}! 👋
                                </h1>
                                <p class="mt-3 text-lg text-gray-600 dark:text-gray-300">
                                    Pantau progres pengerjaan kuesioner Anda dengan mudah dan detail
                                </p>
                                <div class="flex items-center mt-4 space-x-4">
                                    <div
                                        class="flex items-center px-3 py-1 text-sm font-medium text-blue-700 bg-blue-100 rounded-full dark:bg-blue-900/50 dark:text-blue-300">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Terupdate Real-time
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Terakhir diperbarui: {{ now()->format('d M Y, H:i') }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                                <button onclick="window.location.reload()"
                                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-gray-700 transition-all duration-200 transform bg-white border border-gray-300 shadow-lg hover:bg-gray-50 rounded-xl hover:shadow-xl hover:scale-105 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    Refresh Data
                                </button>
                                <a href="{{ route('user.progress.download') }}" target="_blank"
                                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white transition-all duration-200 transform shadow-lg bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-xl hover:shadow-xl hover:scale-105">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Unduh Laporan PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Draft Notification Section --}}
            @if(isset($incompleteDrafts) && $incompleteDrafts->count() > 0)
            <div class="mb-8 animate-fadeInUp">
                <div class="relative overflow-hidden border shadow-lg bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border-amber-200 dark:border-amber-700/50 rounded-2xl">
                    <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-amber-400 to-orange-500"></div>
                    <div class="p-6 pl-8">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-amber-800 dark:text-amber-300">
                                    📝 Anda memiliki {{ $incompleteDrafts->count() }} draft yang belum diselesaikan
                                </h3>
                                <p class="mt-1 text-sm text-amber-700 dark:text-amber-400">
                                    Draft kuesioner berikut masih tersimpan dan menunggu untuk dilanjutkan:
                                </p>
                                <div class="mt-4 space-y-2">
                                    @foreach($incompleteDrafts as $draft)
                                        @php
                                            $cobitItem = $draft->level->kategori->cobitItem ?? null;
                                            $kategori = $draft->level->kategori ?? null;
                                        @endphp
                                        @if($cobitItem && $kategori)
                                        <a href="{{ route('audit.showQuisioner', [$cobitItem->id, $kategori->id, $draft->level_id]) }}" 
                                           class="flex items-center justify-between p-3 transition-all duration-200 bg-white border rounded-lg shadow-sm dark:bg-gray-800 border-amber-200 dark:border-amber-700/50 hover:shadow-md hover:scale-[1.01] group">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center justify-center w-8 h-8 text-sm font-bold text-white rounded-lg bg-gradient-to-br from-amber-400 to-orange-500">
                                                    {{ count($draft->answers ?? []) }}
                                                </div>
                                                <div>
                                                    <span class="font-medium text-gray-900 dark:text-white">{{ $draft->level->nama_level ?? 'Level' }}</span>
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                                        • {{ $cobitItem->nama_item ?? '' }} / {{ $kategori->nama ?? '' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2 text-amber-600 dark:text-amber-400 group-hover:text-amber-700 dark:group-hover:text-amber-300">
                                                <span class="text-sm font-medium">Lanjutkan</span>
                                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if ($progressData->isEmpty())
                <div class="py-20 text-center animate-fadeInUp">
                    <div class="max-w-md mx-auto">
                        <div
                            class="flex items-center justify-center w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/50 dark:to-purple-900/50 rounded-2xl">
                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="mb-3 text-2xl font-bold text-gray-900 dark:text-white">Belum Ada Data</h3>
                        <p class="text-lg text-gray-500 dark:text-gray-400">
                            Progres kuesioner belum tersedia. Mulai mengerjakan kuesioner untuk melihat progres Anda!
                        </p>
                        <div class="mt-6">
                            <a href="#"
                                class="inline-flex items-center px-6 py-3 text-sm font-medium text-white transition-all duration-200 transform shadow-lg bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-xl hover:shadow-xl hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Mulai Kuesioner
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Overall Progress Summary -->
                <div class="mb-8 animate-fadeInUp">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div class="p-6 rounded-2xl metric-card card-hover">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Item</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">
                                        {{ count($progressData) }}</p>
                                </div>
                                <div
                                    class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 rounded-2xl metric-card card-hover">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Item Selesai</p>
                                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">
                                        {{ $progressData->where('completed_levels_in_item', '>=', 'total_levels_in_item')->count() }}
                                    </p>
                                </div>
                                <div
                                    class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-green-500 to-green-500 rounded-xl">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>


                        <div class="p-6 rounded-2xl metric-card card-hover">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Progres Rata-rata
                                    </p>
                                    @php
                                        $totalProgress = $progressData->sum(function ($item) {
                                            return $item['total_levels_in_item'] > 0
                                                ? ($item['completed_levels_in_item'] / $item['total_levels_in_item']) *
                                                        100
                                                : 0;
                                        });
                                        $averageProgress =
                                            count($progressData) > 0 ? round($totalProgress / count($progressData)) : 0;
                                    @endphp
                                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                                        {{ $averageProgress }}%</p>
                                </div>
                                <div
                                    class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-red-500 to-red-500 rounded-xl">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-data="{ activeTab: 0 }" class="w-full animate-fadeInUp">
                    <!-- Tab Navigation -->
                    <div class="mb-8">
                        <div class="relative p-2 overflow-hidden shadow-xl glass-effect rounded-2xl">
                            <div class="flex flex-wrap gap-2" role="tablist">
                                @foreach ($progressData as $itemIndex => $cobitItem)
                                    <button @click="activeTab = {{ $itemIndex }}"
                                        :class="{
                                            'bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg transform scale-105': activeTab ===
                                                {{ $itemIndex }},
                                            'text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700/50': activeTab !==
                                                {{ $itemIndex }}
                                        }"
                                        class="px-6 py-3 text-sm font-medium transition-all duration-300 transform rounded-xl whitespace-nowrap hover:scale-105 tab-button"
                                        :class="{ 'active': activeTab === {{ $itemIndex }} }" role="tab">
                                        <span class="flex items-center space-x-2">
                                            <span class="w-2 h-2 bg-current rounded-full opacity-75"></span>
                                            <span>{{ $cobitItem['nama_item'] }}</span>
                                            @php
                                                $itemPercentage = 0;
                                                if ($cobitItem['total_levels_in_item'] > 0) {
                                                    $itemPercentage = round(
                                                        ($cobitItem['completed_levels_in_item'] /
                                                            $cobitItem['total_levels_in_item']) *
                                                            100,
                                                    );
                                                }
                                            @endphp
                                            <span class="text-xs opacity-75">({{ $itemPercentage }}%)</span>
                                        </span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    @foreach ($progressData as $itemIndex => $cobitItem)
                        <div x-show="activeTab === {{ $itemIndex }}" x-cloak
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">

                            @php
                                $itemPercentage = 0;
                                if ($cobitItem['total_levels_in_item'] > 0) {
                                    $itemPercentage = round(
                                        ($cobitItem['completed_levels_in_item'] / $cobitItem['total_levels_in_item']) *
                                            100,
                                    );
                                }
                            @endphp

                            <!-- Item Progress Overview -->
                            <div class="relative p-8 overflow-hidden shadow-2xl glass-effect rounded-2xl card-hover">
                                <div
                                    class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 rounded-t-2xl">
                                </div>
                                <div
                                    class="flex flex-col space-y-6 lg:flex-row lg:items-center lg:justify-between lg:space-y-0">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-4">
                                            <div
                                                class="flex items-center justify-center w-12 h-12 mr-4 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                                    {{ $cobitItem['nama_item'] }}
                                                </h3>
                                                <p class="text-gray-600 dark:text-gray-400">
                                                    Progres keseluruhan untuk item ini
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-4">
                                            <span
                                                class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-full status-badge
                                                {{ $itemPercentage == 100 ? 'bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300' : 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300' }}">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $itemPercentage }}% Selesai
                                            </span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $cobitItem['completed_levels_in_item'] }} dari
                                                {{ $cobitItem['total_levels_in_item'] }} level
                                            </span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                • {{ count($cobitItem['kategoris']) }} kategori
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="relative w-32 h-32">
                                            <svg class="w-32 h-32 transform -rotate-90" viewBox="0 0 100 100">
                                                <circle cx="50" cy="50" r="42" fill="none"
                                                    stroke="currentColor" stroke-width="4"
                                                    class="text-gray-200 dark:text-gray-700"></circle>
                                                <circle cx="50" cy="50" r="42" fill="none"
                                                    stroke="currentColor" stroke-width="4"
                                                    class="progress-circle {{ $itemPercentage == 100 ? 'text-green-500' : 'text-blue-500' }}"
                                                    style="stroke-dashoffset: {{ 264 - (264 * $itemPercentage) / 100 }}">
                                                </circle>
                                            </svg>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <div class="text-center">
                                                    <span
                                                        class="text-2xl font-bold text-gray-900 dark:text-white">{{ $itemPercentage }}%</span>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">Complete
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                @forelse ($cobitItem['kategoris'] as $kategori)
                                    @php
                                        $kategoriPercentage =
                                            $kategori['total_levels_in_kategori'] > 0
                                                ? round(
                                                    ($kategori['completed_levels_in_kategori'] /
                                                        $kategori['total_levels_in_kategori']) *
                                                        100,
                                                )
                                                : 0;
                                    @endphp
                                    <div x-data="{ open: false }"
                                        class="relative overflow-hidden border shadow-lg bg-white/80 backdrop-blur-sm border-gray-200/50 dark:bg-gray-800/80 dark:border-gray-700/50 rounded-xl card-hover">
                                        <div @click="open = !open"
                                            class="p-6 transition-colors duration-200 cursor-pointer hover:bg-gray-50/50 dark:hover:bg-gray-700/50">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="flex items-center justify-center w-12 h-12 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600">
                                                            <svg class="w-6 h-6 text-white" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h4
                                                            class="text-lg font-semibold text-gray-900 dark:text-white">
                                                            {{ $kategori['nama_kategori'] }}</h4>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ count($kategori['levels']) }} level tersedia</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-3">
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full {{ $kategoriPercentage == 100 ? 'bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300' : 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300' }}">{{ $kategoriPercentage }}%</span>
                                                    <svg class="w-5 h-5 text-gray-400 transition-transform duration-300"
                                                        :class="{ 'rotate-180': open }" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div x-show="open" x-cloak
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 max-h-0"
                                            x-transition:enter-end="opacity-100 max-h-screen"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100 max-h-screen"
                                            x-transition:leave-end="opacity-0 max-h-0"
                                            class="border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50">
                                            <div class="p-6 space-y-4">
                                                @forelse ($kategori['levels'] as $levelIndex => $level)
                                                    <div class="p-4 bg-white border rounded-lg shadow-sm dark:bg-gray-800 border-gray-200/50 dark:border-gray-700/50 animate-slideInLeft"
                                                        style="animation-delay: {{ $levelIndex * 0.1 }}s">
                                                        <div class="flex items-center justify-between mb-3">
                                                            <div class="flex items-center space-x-3">
                                                                <div
                                                                    class="flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-br from-blue-400 to-blue-600">
                                                                    <span
                                                                        class="text-xs font-bold text-white">{{ $levelIndex + 1 }}</span>
                                                                </div>
                                                                <span
                                                                    class="font-medium text-gray-900 dark:text-white">{{ $level['nama_level'] }}</span>
                                                            </div>
                                                            <div class="flex items-center space-x-2">
                                                                <span
                                                                    class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $level['percentage'] }}%</span>
                                                                @if ($level['percentage'] == 100)
                                                                    <svg class="w-5 h-5 text-green-500"
                                                                        fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd"
                                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                            clip-rule="evenodd"></path>
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="relative">
                                                            <div
                                                                class="w-full h-3 overflow-hidden bg-gray-200 rounded-full dark:bg-gray-600">
                                                                <div class="h-full rounded-full transition-all duration-1000 ease-out progress-bar-animated {{ $level['percentage'] == 100 ? 'bg-gradient-to-r from-green-400 to-green-600' : 'bg-gradient-to-r from-blue-400 to-blue-600' }}"
                                                                    style="width: {{ $level['percentage'] }}%"></div>
                                                            </div>
                                                            @if ($level['percentage'] > 0 && $level['percentage'] < 100)
                                                                <div
                                                                    class="absolute inset-0 rounded-full progress-shimmer">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="py-8 text-center">
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada
                                                            level dalam kategori ini</p>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-12 text-center">
                                        <p class="text-gray-500 dark:text-gray-400">Tidak ada kategori dalam item ini
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

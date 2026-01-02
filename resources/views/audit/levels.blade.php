@php
    $user = auth()->user();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight tracking-wide text-gray-700 dark:text-sky-300">
            {{ $kategori->nama }}
        </h2>
    </x-slot>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px)
            }

            to {
                opacity: 1;
                transform: translateX(0)
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
        }

        .animate-slideIn {
            animation: slideIn 0.5s ease-out forwards;
            opacity: 0;
        }

        .animation-delay-100 {
            animation-delay: 0.1s;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
        }

        .animation-delay-300 {
            animation-delay: 0.3s;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
        }

        .animation-delay-500 {
            animation-delay: 0.5s;
        }

        .level-card {
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .level-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .progress-ring {
            transform: rotate(-90deg);
        }

        .progress-ring-circle {
            stroke-dasharray: 113;
            stroke-dashoffset: 113;
            transition: stroke-dashoffset 0.5s ease-in-out;
        }
    </style>

    <div class="min-h-screen py-8 bg-slate-950 dark:bg-gray-900 bg-gradient-to-br from-slate-950 via-gray-900 to-slate-900">
        <div class="max-w-6xl px-4 mx-auto sm:px-6 lg:px-8">

            {{-- Breadcrumb Navigation --}}
            <div class="mb-8 animate-slideIn">
                @include('audit.partials.breadcrumbs', [
                    'breadcrumbs' => [
                        ['title' => $cobitItem->nama_item, 'url' => route('audit.showCategories', $cobitItem->id)],
                        ['title' => $kategori->nama],
                    ],
                ])
            </div>

            {{-- Header Section --}}
            <div class="mb-8 animate-fadeIn">
                <div
                    class="p-6 border shadow-lg bg-slate-900/50 dark:bg-slate-800/80 backdrop-blur-lg rounded-2xl border-slate-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 shadow-lg bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Level</h1>
                                <p class="text-gray-600 dark:text-gray-300">Selesaikan setiap level untuk mencapai
                                    maturity yang diinginkan</p>
                            </div>
                        </div>
                        <div class="text-right">
                            @php
                                $totalLevels = $kategori->levels->count();
                                $completedLevels = $kategori->levels
                                    ->filter(function ($level) use ($user) {
                                        return $level->isFullyAchievedByUser($user);
                                    })
                                    ->count();
                                $progressPercentage = $totalLevels > 0 ? ($completedLevels / $totalLevels) * 100 : 0;
                            @endphp
                            <div class="flex items-center space-x-3">
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                        {{ $completedLevels }}/{{ $totalLevels }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Level Selesai</div>
                                </div>
                                <div class="relative w-16 h-16">
                                    <svg class="w-16 h-16 progress-ring" viewBox="0 0 36 36">
                                        <path class="text-gray-200 dark:text-gray-700" stroke="currentColor"
                                            stroke-width="3" fill="none"
                                            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        <path class="text-blue-600 dark:text-blue-400 progress-ring-circle"
                                            stroke="currentColor" stroke-width="3" fill="none"
                                            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                            style="stroke-dashoffset: {{ 113 - (113 * $progressPercentage) / 100 }}" />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span
                                            class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ round($progressPercentage) }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Alert Messages --}}
            @if (session('success'))
                <div class="mb-6 animate-fadeIn animation-delay-200">
                    <div
                        class="p-4 border border-green-200 shadow-sm bg-green-50 dark:bg-green-900/20 dark:border-green-800 rounded-xl">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-green-600 dark:text-green-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-green-800 dark:text-green-300">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 animate-fadeIn animation-delay-200">
                    <div
                        class="p-4 border border-red-200 shadow-sm bg-red-50 dark:bg-red-900/20 dark:border-red-800 rounded-xl">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-red-600 dark:text-red-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-red-800 dark:text-red-300">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Levels Grid --}}
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @php
                    $user = auth()->user();
                    $previousLevelFullyAchieved = true;
                @endphp
                @forelse ($kategori->levels->sortBy('level_number') as $index => $level)
                    @php
                        $delayClass = 'animation-delay-' . (($index % 5) + 1) . '00';
                        $levelNumber = $level->level_number ?? $index + 1;
                    @endphp

                    @if ($previousLevelFullyAchieved)
                        @php
                            $isCompleted = $level->isCompletedByUser($user);
                            $isFullyAchieved = $isCompleted && $level->isFullyAchievedByUser($user);
                            $hasActiveRequest = $level->hasActiveResubmissionRequest($user);
                            $isApprovedForResubmission = $level->isApprovedForResubmission($user);
                        @endphp

                        <div
                            class="level-card bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-2xl p-6 shadow-lg border border-white/20 dark:border-slate-700/50 animate-fadeIn {{ $delayClass }}">
                            {{-- Level Header --}}
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex items-center justify-center w-10 h-10 shadow-lg bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl">
                                        <span class="text-sm font-bold text-white">{{ $levelNumber }}</span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $level->nama_level }}
                                        </h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Level {{ $levelNumber }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Status Badge --}}
                                @if ($isCompleted && $isFullyAchieved)
                                    <div
                                        class="flex items-center px-2 py-1 space-x-1 bg-green-100 rounded-full dark:bg-green-900/30">
                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span
                                            class="text-xs font-medium text-green-700 dark:text-green-300">Selesai</span>
                                    </div>
                                @elseif ($isCompleted && !$isFullyAchieved)
                                    <div
                                        class="flex items-center px-2 py-1 space-x-1 bg-yellow-100 rounded-full dark:bg-yellow-900/30">
                                        <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-xs font-medium text-yellow-700 dark:text-yellow-300">Perlu
                                            Review</span>
                                    </div>
                                @else
                                    <div
                                        class="flex items-center px-2 py-1 space-x-1 bg-blue-100 rounded-full dark:bg-blue-900/30">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        <span
                                            class="text-xs font-medium text-blue-700 dark:text-blue-300">Tersedia</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Level Description --}}
                            @if ($level->description)
                                <p class="mb-4 text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
                                    {{ $level->description }}</p>
                            @endif

                            {{-- Action Button --}}
                            <div class="mt-auto">
                                @if (!$isCompleted || $isApprovedForResubmission)
                                    <a href="{{ route('audit.showQuisioner', ['cobitItem' => $cobitItem->id, 'kategori' => $kategori->id, 'level' => $level->id]) }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                        {{ $isApprovedForResubmission ? 'Isi Ulang Kuesioner' : 'Mulai Kuesioner' }}
                                    </a>
                                @elseif ($isCompleted && $isFullyAchieved)
                                    <div
                                        class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 font-medium rounded-xl">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Tercapai Penuh
                                    </div>
                                @elseif ($isCompleted && !$isFullyAchieved)
                                    @if ($hasActiveRequest)
                                        <div
                                            class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 font-medium rounded-xl">
                                            <svg class="w-4 h-4 mr-2 animate-spin" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Menunggu Persetujuan
                                        </div>
                                    @else
                                        <form action="{{ route('resubmission.request', $level->id) }}" method="POST"
                                            class="w-full">
                                            @csrf
                                            <button type="submit"
                                                class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                Ajukan Pengisian Ulang
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @php $previousLevelFullyAchieved = $isFullyAchieved; @endphp
                    @else
                        {{-- Locked Level --}}
                        <div
                            class="level-card bg-gray-100/80 dark:bg-slate-800/50 backdrop-blur-lg rounded-2xl p-6 shadow-lg border border-gray-200/50 dark:border-slate-700/50 opacity-60 animate-fadeIn {{ $delayClass }}">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex items-center justify-center w-10 h-10 bg-gray-400 dark:bg-gray-600 rounded-xl">
                                        <span class="text-sm font-bold text-white">{{ $levelNumber }}</span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-500 dark:text-gray-400">
                                            {{ $level->nama_level }}</h3>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">Level {{ $levelNumber }}
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center px-2 py-1 space-x-1 bg-gray-200 rounded-full dark:bg-gray-700">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Terkunci</span>
                                </div>
                            </div>
                            <p class="mb-4 text-sm text-gray-400 dark:text-gray-500">Selesaikan level sebelumnya untuk
                                membuka level ini</p>
                            <div
                                class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-medium rounded-xl cursor-not-allowed">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                </svg>
                                Tidak Tersedia
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="col-span-full">
                        <div
                            class="p-12 text-center border shadow-lg bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-2xl border-white/20 dark:border-slate-700/50">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Tidak Ada Level</h3>
                            <p class="text-gray-600 dark:text-gray-300">Tidak ada level yang tersedia untuk kategori
                                ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold leading-tight tracking-wide text-gray-800 dark:text-white">
                    {{ __('Audit COBIT') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    Kelola dan pantau progres audit COBIT framework Anda
                </p>
            </div>
            <div class="items-center hidden space-x-4 md:flex">
                <div class="px-4 py-2 bg-blue-100 rounded-lg dark:bg-blue-900/30">
                    <span class="text-sm font-medium text-blue-800 dark:text-blue-200">
                        {{ count($cobitItems) }} Domain Tersedia
                    </span>
                </div>
            </div>
        </div>
    </x-slot>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
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
                transform: scale(1.05);
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

        .animation-delay-600 {
            animation-delay: 0.6s;
        }

        .gradient-border::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 1rem;
            padding: 2px;
            background: linear-gradient(135deg, #0ea5e9, #6366f1, #ec4899, #f59e0b);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: destination-out;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .group:hover .gradient-border::before {
            opacity: 0.8;
        }

        .progress-ring {
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        .progress-ring-circle {
            transition: stroke-dashoffset 0.5s ease-in-out;
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
        }

        .status-badge {
            position: relative;
            overflow: hidden;
        }

        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .status-badge:hover::before {
            left: 100%;
        }
    </style>

    <div
        class="min-h-screen py-8 bg-slate-950 dark:bg-gray-900 bg-gradient-to-br from-slate-950 via-gray-900 to-slate-900">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Flash Messages -->
            @if(session('info'))
                <div class="p-4 mb-6 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-900/40 dark:text-blue-200 border border-blue-200 dark:border-blue-800 animate-slideIn" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium">Informasi:</span> {{ session('info') }}
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/40 dark:text-green-200 border border-green-200 dark:border-green-800 animate-slideIn" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium">Berhasil!</span> {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/40 dark:text-red-200 border border-red-200 dark:border-red-800 animate-slideIn" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0v-4a1 1 0 112 0v4z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium">Gagal:</span> {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Statistics Overview -->
            <div class="mb-8 animate-slideIn">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    @php
                        $totalItems = count($cobitItems);
                        $completedItems = 0;
                        $totalProgress = 0;
                        $user = auth()->user(); // Definisikan user sekali di awal

                        foreach ($cobitItems as $item) {
                            $isItemCompleted = $item->isCompletedByUser($user);

                            if ($isItemCompleted) {
                                $completedItems++;
                            }

                            // Hitung persentase berdasarkan level
                            $totalLevels = $item->kategoris->flatMap->levels->count();
                            $completedLevels = 0;
                            if ($totalLevels > 0) {
                                foreach ($item->kategoris as $kategori) {
                                    foreach ($kategori->levels as $level) {
                                        if ($level->isFullyAchievedByUser($user)) {
                                            $completedLevels++;
                                        }
                                    }
                                }
                            }
                            $percentage = $totalLevels > 0 ? round(($completedLevels / $totalLevels) * 100) : 0;

                            // --- PERBAIKAN LOGIKA DIMULAI DI SINI ---
                            // Jika item sudah ditandai selesai, pastikan progresnya dihitung sebagai 100 untuk rata-rata.
                            if ($isItemCompleted) {
                                $percentage = 100;
                            }
                            // --- PERBAIKAN SELESAI ---

                            $totalProgress += $percentage;
                        }

                        $averageProgress = $totalItems > 0 ? round($totalProgress / $totalItems) : 0;
                    @endphp

                    <div
                        class="p-6 bg-slate-900/50 border border-slate-700 shadow-xl dark:bg-slate-800/90 glass-effect rounded-2xl dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Total Domain</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalItems }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full dark:bg-blue-900/30">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-6 bg-slate-900/50 border border-slate-700 shadow-xl dark:bg-slate-800/90 glass-effect rounded-2xl dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Selesai</p>
                                <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $completedItems }}
                                </p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full dark:bg-green-900/30">
                                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-6 bg-slate-900/50 border border-slate-700 shadow-xl dark:bg-slate-800/90 glass-effect rounded-2xl dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Rata-rata Progres</p>
                                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                                    {{ $averageProgress }}%</p>
                            </div>
                            <div class="p-3 bg-indigo-100 rounded-full dark:bg-indigo-900/30">
                                <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Audit Items Grid -->
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($cobitItems as $index => $item)
                    {{-- Di DALAM perulangan 'foreach', ganti blok PHP yang ada dengan ini --}}
                    @php
                        $user = auth()->user();
                        $isCompleted = $item->isCompletedByUser($user);
                        $delayClass = 'animation-delay-' . (($index % 6) + 1) . '00';
                        $totalLevels = $item->kategoris->flatMap->levels->count();
                        $completedLevels = 0;

                        if ($totalLevels > 0) {
                            foreach ($item->kategoris as $kategori) {
                                foreach ($kategori->levels as $level) {
                                    if ($level->isFullyAchievedByUser($user)) {
                                        $completedLevels++;
                                    }
                                }
                            }
                        }

                        $percentage = $totalLevels > 0 ? round(($completedLevels / $totalLevels) * 100) : 0;

                        // INI ADALAH PERBAIKANNYA
                        // Jika item sudah selesai, paksa progres jadi 100%
                        if ($isCompleted) {
                            $percentage = 100;
                            if ($totalLevels > 0) {
                                $completedLevels = $totalLevels;
                            }
                        }

                        // Progress circle calculations
                        $radius = 40;
                        $circumference = 2 * M_PI * $radius;
                        $strokeDashoffset = $circumference - ($percentage / 100) * $circumference;
                    @endphp

                    {{-- Kode untuk kartu audit (APO01, BA103, dst.) ada DI BAWAH BLOK INI --}}

                    <div
                        class="group relative bg-white dark:bg-slate-800/90 glass-effect border border-gray-200 dark:border-slate-700 rounded-2xl shadow-xl card-hover animate-fadeIn {{ $delayClass }}">

                        <!-- Gradient Border Effect -->
                        <div class="absolute inset-0 hidden overflow-hidden pointer-events-none dark:block rounded-2xl">
                            <div class="gradient-border"></div>
                        </div>

                        <!-- Status Badge -->
                        <div class="absolute top-0 right-0 z-10 p-2">
                            @if ($isCompleted)
                                <div
                                    class="flex items-center px-3 py-1 bg-green-100 rounded-full status-badge dark:bg-green-900/30">
                                    <svg class="w-4 h-4 mr-1 text-green-600 dark:text-green-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span
                                        class="text-xs font-semibold text-green-700 dark:text-green-300">Selesai</span>
                                </div>
                            @else
                                <div
                                    class="flex items-center px-3 py-1 bg-yellow-100 rounded-full status-badge dark:bg-yellow-900/30">
                                    <svg class="w-4 h-4 mr-1 text-yellow-600 dark:text-yellow-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span
                                        class="text-xs font-semibold text-yellow-700 dark:text-yellow-300">Berlangsung</span>
                                </div>
                            @endif
                        </div>

                        <div class="relative p-6 pt-8">
                            <!-- Header with Progress Circle -->
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex-1 pr-4">
                                    <h3 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                                        {{ $item->nama_item }}
                                    </h3>
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                        {{ $totalLevels }} Level
                                    </div>
                                </div>

                                <!-- Circular Progress -->
                                <div class="relative flex items-center justify-center w-20 h-20">
                                    <svg class="w-full h-full progress-ring" viewBox="0 0 100 100">
                                        <circle cx="50" cy="50" r="{{ $radius }}" fill="none"
                                            stroke="currentColor" stroke-width="8"
                                            class="text-gray-200 dark:text-gray-700" />
                                        <circle cx="50" cy="50" r="{{ $radius }}" fill="none"
                                            stroke="currentColor" stroke-width="8" stroke-linecap="round"
                                            stroke-dasharray="{{ $circumference }}"
                                            stroke-dashoffset="{{ $strokeDashoffset }}"
                                            class="text-blue-500 progress-ring-circle dark:text-blue-400" />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span
                                            class="text-sm font-bold text-gray-900 dark:text-white">{{ $percentage }}%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed mb-6 min-h-[4rem]">
                                {{ \Illuminate\Support\Str::limit($item->deskripsi, 120) }}
                            </p>

                            <!-- Progress Bar -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                        Progres Detail
                                    </span>
                                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                        {{ $completedLevels }} / {{ $totalLevels }} Level
                                    </span>
                                </div>
                                <div class="w-full h-3 overflow-hidden bg-gray-200 rounded-full dark:bg-gray-700">
                                    <div class="h-full transition-all duration-700 ease-out rounded-full bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-600"
                                        style="width: {{ $percentage }}%">
                                    </div>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                @if ($isCompleted)
                                    <div
                                        class="flex items-center justify-center w-full px-4 py-3 text-sm font-semibold text-white bg-green-600 shadow-lg dark:bg-green-700 rounded-xl">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Audit Selesai
                                    </div>
                                @else
                                    <a href="{{ route('audit.showCategories', $item->id) }}"
                                        class="flex items-center justify-center w-full px-4 py-3 text-sm font-semibold text-white transition-all duration-200 transform shadow-lg group/btn bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 rounded-xl hover:scale-105 hover:shadow-xl">
                                        <span>{{ $completedLevels > 0 ? 'Lanjutkan Audit' : 'Mulai Audit' }}</span>
                                        <svg class="w-5 h-5 ml-2 transition-transform duration-200 group-hover/btn:translate-x-1"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if (count($cobitItems) === 0)
                <div class="py-16 text-center animate-fadeIn">
                    <div
                        class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full dark:bg-gray-800">
                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Belum ada item audit</h3>
                    <p class="max-w-md mx-auto text-gray-600 dark:text-gray-400">
                        Saat ini belum ada item audit COBIT yang tersedia. Silakan tambahkan item audit untuk memulai.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

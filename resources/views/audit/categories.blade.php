<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold leading-tight tracking-wide text-gray-800 dark:text-white">
                    {{ __('Kategori Audit') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    {{ $cobitItem->nama_item }} - Pilih kategori untuk memulai audit
                </p>
            </div>
            <div class="items-center hidden space-x-4 md:flex">
                <div class="px-4 py-2 bg-blue-100 rounded-lg dark:bg-blue-900/30">
                    <span class="text-sm font-medium text-blue-800 dark:text-blue-200">
                        {{ count($kategoris) }} Kategori
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

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
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

        .animate-scaleIn {
            animation: scaleIn 0.4s ease-out forwards;
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

        .glass-effect {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .category-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .category-card:hover::before {
            left: 100%;
        }

        .category-card:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .category-card:hover .category-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .category-icon {
            transition: transform 0.3s ease;
        }

        .progress-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .gradient-border {
            position: relative;
        }

        .gradient-border::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 1rem;
            padding: 2px;
            background: linear-gradient(135deg, #0ea5e9, #6366f1, #ec4899);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: destination-out;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .category-card:hover .gradient-border::after {
            opacity: 0.6;
        }

        .breadcrumb-item {
            transition: all 0.2s ease;
        }

        .breadcrumb-item:hover {
            color: #3b82f6;
            transform: translateX(2px);
        }
    </style>

    <div
        class="min-h-screen py-8 bg-slate-950 dark:bg-gray-900 bg-gradient-to-br from-slate-950 via-gray-900 to-slate-900">
        <div class="max-w-6xl px-4 mx-auto sm:px-6 lg:px-8">

            {{-- Breadcrumb Navigation --}}
            <div class="mb-8 animate-slideIn">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('audit.index') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 breadcrumb-item hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-300">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                                Audit COBIT
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">
                                    {{ $cobitItem->nama_item }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- Main Content Card --}}
            <div
                class="bg-slate-900/50 border border-slate-700 shadow-xl dark:bg-slate-800/90 glass-effect rounded-2xl dark:border-slate-700 animate-scaleIn animation-delay-100">

                {{-- Header Section --}}
                <div class="p-8 border-b border-slate-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    Pilih Kategori Audit
                                </h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                    Setiap kategori memiliki level yang berbeda untuk dinilai
                                </p>
                            </div>
                        </div>

                        @php
                            $user = auth()->user();
                            $totalCategories = count($kategoris);
                            $completedCategories = 0;
                            foreach ($kategoris as $kategori) {
                                $isCompleted = true;
                                foreach ($kategori->levels as $level) {
                                    if (!$level->isFullyAchievedByUser($user)) {
                                        $isCompleted = false;
                                        break;
                                    }
                                }
                                if ($isCompleted && $kategori->levels->count() > 0) {
                                    $completedCategories++;
                                }
                            }
                            $overallProgress =
                                $totalCategories > 0 ? round(($completedCategories / $totalCategories) * 100) : 0;
                        @endphp

                        <div class="text-right">
                            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                                {{ $overallProgress }}%
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                {{ $completedCategories }}/{{ $totalCategories }} Selesai
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Categories Grid --}}
                <div class="p-8">
                    @forelse ($kategoris as $index => $kategori)
                        @php
                            $delayClass = 'animation-delay-' . (($index % 6) + 2) . '00';
                            $user = auth()->user();
                            $totalLevels = $kategori->levels->count();
                            $completedLevels = 0;

                            foreach ($kategori->levels as $level) {
                                if ($level->isFullyAchievedByUser($user)) {
                                    $completedLevels++;
                                }
                            }

                            $categoryProgress = $totalLevels > 0 ? round(($completedLevels / $totalLevels) * 100) : 0;
                            $isCompleted = $completedLevels === $totalLevels && $totalLevels > 0;
                        @endphp

                        <div class="mb-6 animate-fadeIn {{ $delayClass }}">
                            <a href="{{ route('audit.showLevels', [$cobitItem->id, $kategori->id]) }}"
                                class="block p-6 border border-gray-200 category-card gradient-border bg-gray-50 dark:bg-slate-700/50 rounded-xl dark:border-slate-600 hover:border-transparent dark:hover:border-transparent">

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center flex-1 space-x-4">
                                        {{-- Category Icon --}}
                                        <div
                                            class="category-icon p-3 rounded-lg {{ $isCompleted ? 'bg-green-100 dark:bg-green-900/30' : 'bg-blue-100 dark:bg-blue-900/30' }}">
                                            @if ($isCompleted)
                                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                                    </path>
                                                </svg>
                                            @endif
                                        </div>

                                        {{-- Category Info --}}
                                        <div class="flex-1 min-w-0">
                                            <h4 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ $kategori->nama }}
                                            </h4>
                                            <div
                                                class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-300">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                                        </path>
                                                    </svg>
                                                    {{ $totalLevels }} Level
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                    {{ $categoryProgress }}% Selesai
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Progress Section --}}
                                    <div class="flex items-center space-x-4">
                                        {{-- Progress Dots --}}
                                        <div class="items-center hidden space-x-1 sm:flex">
                                            @for ($i = 0; $i < min($totalLevels, 5); $i++)
                                                <div
                                                    class="progress-dot {{ $i < $completedLevels ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }}">
                                                </div>
                                            @endfor
                                            @if ($totalLevels > 5)
                                                <span
                                                    class="ml-1 text-xs text-gray-500 dark:text-gray-400">+{{ $totalLevels - 5 }}</span>
                                            @endif
                                        </div>

                                        {{-- Status Badge --}}
                                        @if ($isCompleted)
                                            <div
                                                class="flex items-center px-3 py-1 bg-green-100 rounded-full dark:bg-green-900/30">
                                                <svg class="w-3 h-3 mr-1 text-green-600 dark:text-green-400"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span
                                                    class="text-xs font-medium text-green-700 dark:text-green-300">Selesai</span>
                                            </div>
                                        @elseif($completedLevels > 0)
                                            <div
                                                class="flex items-center px-3 py-1 bg-yellow-100 rounded-full dark:bg-yellow-900/30">
                                                <svg class="w-3 h-3 mr-1 text-yellow-600 dark:text-yellow-400"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span
                                                    class="text-xs font-medium text-yellow-700 dark:text-yellow-300">Berlangsung</span>
                                            </div>
                                        @else
                                            <div
                                                class="flex items-center px-3 py-1 bg-gray-100 rounded-full dark:bg-gray-700">
                                                <svg class="w-3 h-3 mr-1 text-gray-600 dark:text-gray-400"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span
                                                    class="text-xs font-medium text-gray-700 dark:text-gray-300">Belum
                                                    Mulai</span>
                                            </div>
                                        @endif

                                        {{-- Arrow Icon --}}
                                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 dark:text-gray-500 group-hover:translate-x-1"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>

                                {{-- Progress Bar --}}
                                <div class="mt-4">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs text-gray-600 dark:text-gray-400">Progress</span>
                                        <span
                                            class="text-xs font-medium text-gray-900 dark:text-white">{{ $completedLevels }}/{{ $totalLevels }}</span>
                                    </div>
                                    <div class="w-full h-2 bg-gray-200 rounded-full dark:bg-gray-700">
                                        <div class="h-2 transition-all duration-500 ease-out rounded-full bg-gradient-to-r from-blue-500 to-indigo-600"
                                            style="width: {{ $categoryProgress }}%"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="py-16 text-center animate-fadeIn">
                            <div
                                class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full dark:bg-gray-800">
                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Belum ada kategori
                            </h3>
                            <p class="max-w-md mx-auto text-gray-600 dark:text-gray-400">
                                Tidak ada kategori yang tersedia untuk item audit ini.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

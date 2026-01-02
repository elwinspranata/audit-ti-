<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold leading-tight tracking-wide text-gray-800 dark:text-white">
                    {{ __('My Assessments') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    Kelola dan pantau progres assessment audit Anda
                </p>
            </div>
            <div class="items-center hidden space-x-4 md:flex">
                <a href="{{ route('audit.index') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Start New Audit
                    </span>
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-fadeIn { animation: fadeIn 0.6s ease-out forwards; opacity: 0; }
        .animate-slideIn { animation: slideIn 0.5s ease-out forwards; opacity: 0; }
        .animation-delay-100 { animation-delay: 0.1s; }
        .animation-delay-200 { animation-delay: 0.2s; }
        .animation-delay-300 { animation-delay: 0.3s; }
        .animation-delay-400 { animation-delay: 0.4s; }
        .animation-delay-500 { animation-delay: 0.5s; }
        .animation-delay-600 { animation-delay: 0.6s; }
        .glass-effect { backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-8px) scale(1.02); }
        .progress-ring { transform: rotate(-90deg); transform-origin: 50% 50%; }
        .progress-ring-circle { transition: stroke-dashoffset 0.5s ease-in-out; }
    </style>

    <div class="min-h-screen py-8 bg-slate-950 dark:bg-gray-900 bg-gradient-to-br from-slate-950 via-gray-900 to-slate-900">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Flash Messages -->
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
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium">Gagal:</span> {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Statistics Overview -->
            <div class="mb-8 animate-slideIn">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    @php
                        $totalAssessments = $assessments->count();
                        $completedAssessments = $assessments->where('status', 'completed')->count();
                        $averageProgress = $totalAssessments > 0 ? round($assessments->avg('progress')) : 0;
                    @endphp

                    <div class="p-6 bg-slate-900/50 border border-slate-700 shadow-xl dark:bg-slate-800/90 glass-effect rounded-2xl dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Total Assessment</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalAssessments }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full dark:bg-blue-900/30">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-900/50 border border-slate-700 shadow-xl dark:bg-slate-800/90 glass-effect rounded-2xl dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Selesai</p>
                                <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $completedAssessments }}</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full dark:bg-green-900/30">
                                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-900/50 border border-slate-700 shadow-xl dark:bg-slate-800/90 glass-effect rounded-2xl dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Rata-rata Progres</p>
                                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $averageProgress }}%</p>
                            </div>
                            <div class="p-3 bg-indigo-100 rounded-full dark:bg-indigo-900/30">
                                <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assessment Grid -->
            @if($assessments->isEmpty())
                <div class="py-16 text-center animate-fadeIn">
                    <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full dark:bg-gray-800">
                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Belum ada assessment</h3>
                    <p class="max-w-md mx-auto text-gray-600 dark:text-gray-400">
                        Anda belum memiliki assessment. Hubungi administrator atau mulai audit baru.
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($assessments as $index => $assessment)
                        @php
                            $isCompleted = $assessment->status === 'completed' || $assessment->status === 'verified';
                            $isInProgress = $assessment->status === 'in_progress';
                            $delayClass = 'animation-delay-' . (($index % 6) + 1) . '00';
                            $percentage = $assessment->progress ?? 0;
                            $totalItems = $assessment->items->count();
                            $completedItems = $assessment->items->where('progress', 100)->count();
                            
                            // Progress circle calculations
                            $radius = 40;
                            $circumference = 2 * M_PI * $radius;
                            $strokeDashoffset = $circumference - ($percentage / 100) * $circumference;
                        @endphp

                        <div class="group relative bg-white dark:bg-slate-800/90 glass-effect border border-gray-200 dark:border-slate-700 rounded-2xl shadow-xl card-hover animate-fadeIn {{ $delayClass }}">
                            
                            <!-- Status Badge -->
                            <div class="absolute top-0 right-0 z-10 p-2">
                                @if($isCompleted)
                                    <div class="flex items-center px-3 py-1 bg-green-100 rounded-full dark:bg-green-900/30">
                                        <svg class="w-4 h-4 mr-1 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-xs font-semibold text-green-700 dark:text-green-300">Selesai</span>
                                    </div>
                                @elseif($isInProgress)
                                    <div class="flex items-center px-3 py-1 bg-yellow-100 rounded-full dark:bg-yellow-900/30">
                                        <svg class="w-4 h-4 mr-1 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-xs font-semibold text-yellow-700 dark:text-yellow-300">Berlangsung</span>
                                    </div>
                                @elseif($assessment->status === 'approved')
                                    <div class="flex items-center px-3 py-1 bg-blue-100 rounded-full dark:bg-blue-900/30">
                                        <svg class="w-4 h-4 mr-1 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-xs font-semibold text-blue-700 dark:text-blue-300">Disetujui</span>
                                    </div>
                                @elseif($assessment->status === 'pending_approval')
                                    <div class="flex items-center px-3 py-1 bg-amber-100 rounded-full dark:bg-amber-900/30">
                                        <svg class="w-4 h-4 mr-1 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-xs font-semibold text-amber-700 dark:text-amber-300">Menunggu</span>
                                    </div>
                                @else
                                    <div class="flex items-center px-3 py-1 bg-gray-100 rounded-full dark:bg-gray-700/30">
                                        <svg class="w-4 h-4 mr-1 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 7a1 1 0 112 0v4a1 1 0 11-2 0V7zm0 8a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">Draft</span>
                                    </div>
                                @endif
                            </div>

                            <div class="relative p-6 pt-8">
                                <!-- Header with Progress Circle -->
                                <div class="flex items-start justify-between mb-6">
                                    <div class="flex-1 pr-4">
                                        <h3 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                                            {{ $assessment->name ?? 'Assessment #' . $assessment->id }}
                                        </h3>
                                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            {{ $totalItems }} Level
                                        </div>
                                    </div>

                                    <!-- Circular Progress -->
                                    <div class="relative flex items-center justify-center w-20 h-20">
                                        <svg class="w-full h-full progress-ring" viewBox="0 0 100 100">
                                            <circle cx="50" cy="50" r="{{ $radius }}" fill="none" stroke="currentColor" stroke-width="8" class="text-gray-200 dark:text-gray-700" />
                                            <circle cx="50" cy="50" r="{{ $radius }}" fill="none" stroke="currentColor" stroke-width="8" stroke-linecap="round" stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $strokeDashoffset }}" class="text-blue-500 progress-ring-circle dark:text-blue-400" />
                                        </svg>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $percentage }}%</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed mb-6 min-h-[4rem]">
                                    {{ $assessment->description ?? 'Assessment untuk melakukan audit IT governance framework.' }}
                                </p>

                                <!-- Progress Bar -->
                                <div class="mb-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Progres Detail</span>
                                        <span class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $completedItems }} / {{ $totalItems }} Level</span>
                                    </div>
                                    <div class="w-full h-3 overflow-hidden bg-gray-200 rounded-full dark:bg-gray-700">
                                        <div class="h-full transition-all duration-700 ease-out rounded-full bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-600" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                    @if($isCompleted)
                                        <div class="flex items-center justify-center w-full px-4 py-3 text-sm font-semibold text-white bg-green-600 shadow-lg dark:bg-green-700 rounded-xl">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Audit Selesai
                                        </div>
                                    @elseif($assessment->status === 'approved')
                                        <form action="{{ route('user.assessments.start', $assessment) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="flex items-center justify-center w-full px-4 py-3 text-sm font-semibold text-white transition-all duration-200 transform shadow-lg group/btn bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 rounded-xl hover:scale-105 hover:shadow-xl">
                                                <span>Mulai Audit</span>
                                                <svg class="w-5 h-5 ml-2 transition-transform duration-200 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @elseif($isInProgress)
                                        <a href="{{ route('user.assessments.show', $assessment) }}" class="flex items-center justify-center w-full px-4 py-3 text-sm font-semibold text-white transition-all duration-200 transform shadow-lg group/btn bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 rounded-xl hover:scale-105 hover:shadow-xl">
                                            <span>Lanjutkan Audit</span>
                                            <svg class="w-5 h-5 ml-2 transition-transform duration-200 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                        </a>
                                    @else
                                        <a href="{{ route('user.assessments.show', $assessment) }}" class="flex items-center justify-center w-full px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-200 transition-all duration-200 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl">
                                            <span>Lihat Detail</span>
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

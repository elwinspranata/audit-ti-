<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold leading-tight tracking-wide text-gray-800 dark:text-white">
                    {{ $assessment->name ?? 'Assessment Detail' }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    Detail dan progres assessment audit Anda
                </p>
            </div>
            <div class="items-center hidden space-x-4 md:flex">
                <a href="{{ route('user.assessments.index') }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
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
        .glass-effect { backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
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

            <!-- Rejection Alert -->
            @if($assessment->status === 'rejected' && $assessment->rejection_reason)
                <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/40 dark:text-red-200 border border-red-200 dark:border-red-800 animate-slideIn" role="alert">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <div>
                            <span class="font-medium">Revisi Diperlukan:</span>
                            <p class="mt-1">"{{ $assessment->rejection_reason }}"</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Header Info Card -->
            @php
                $statusConfig = [
                    'pending_submission' => ['label' => 'Draft', 'bg' => 'bg-gray-100 dark:bg-gray-700/30', 'text' => 'text-gray-700 dark:text-gray-300'],
                    'pending_approval'   => ['label' => 'Menunggu Review', 'bg' => 'bg-amber-100 dark:bg-amber-900/30', 'text' => 'text-amber-700 dark:text-amber-300'],
                    'approved'           => ['label' => 'Disetujui', 'bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-300'],
                    'in_progress'        => ['label' => 'Berlangsung', 'bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-700 dark:text-yellow-300'],
                    'completed'          => ['label' => 'Selesai', 'bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-700 dark:text-green-300'],
                    'verified'           => ['label' => 'Terverifikasi', 'bg' => 'bg-purple-100 dark:bg-purple-900/30', 'text' => 'text-purple-700 dark:text-purple-300'],
                    'rejected'           => ['label' => 'Ditolak', 'bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-700 dark:text-red-300'],
                ];
                $currentStatus = $statusConfig[$assessment->status] ?? $statusConfig['pending_submission'];
            @endphp

            <div class="mb-6 p-6 bg-slate-900/50 border border-slate-700 shadow-xl dark:bg-slate-800/90 glass-effect rounded-2xl animate-slideIn">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $currentStatus['bg'] }} {{ $currentStatus['text'] }}">
                            {{ $currentStatus['label'] }}
                        </span>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Dibuat: {{ $assessment->created_at->format('d M Y') }}
                        </div>
                        @if($assessment->approver)
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Approver: {{ $assessment->approver->name }}
                            </div>
                        @endif
                    </div>
                    <div class="flex gap-3">
                        @if($assessment->status === 'pending_submission')
                            <form action="{{ route('user.assessments.submit', $assessment) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    Submit untuk Approval
                                </button>
                            </form>
                        @elseif($assessment->status === 'approved')
                            <form action="{{ route('user.assessments.start', $assessment) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-colors flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Mulai Audit
                                </button>
                            </form>
                        @elseif($assessment->status === 'in_progress')
                            <a href="{{ route('audit.index') }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                Lanjutkan Questionnaire
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left: Audit Scope Items -->
                <div class="lg:col-span-2">
                    <div class="p-6 bg-slate-900/50 border border-slate-700 shadow-xl dark:bg-slate-800/90 glass-effect rounded-2xl animate-fadeIn">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Audit Scope</h3>
                            <div class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <span class="text-sm font-medium text-blue-800 dark:text-blue-200">{{ $assessment->items->count() }} Items</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @forelse($assessment->items as $index => $item)
                                @php
                                    $itemProgress = $item->progress ?? 0;
                                    $radius = 35;
                                    $circumference = 2 * M_PI * $radius;
                                    $strokeDashoffset = $circumference - ($itemProgress / 100) * $circumference;
                                @endphp

                                <div class="group p-5 bg-white dark:bg-slate-800/70 border border-gray-200 dark:border-slate-700 rounded-xl hover:border-blue-500/50 transition-all duration-300">
                                    <div class="flex flex-col lg:flex-row gap-4">
                                        <!-- Circular Progress -->
                                        <div class="relative flex items-center justify-center w-16 h-16 flex-shrink-0">
                                            <svg class="w-full h-full progress-ring" viewBox="0 0 80 80">
                                                <circle cx="40" cy="40" r="{{ $radius }}" fill="none" stroke="currentColor" stroke-width="6" class="text-gray-200 dark:text-gray-700" />
                                                <circle cx="40" cy="40" r="{{ $radius }}" fill="none" stroke="currentColor" stroke-width="6" stroke-linecap="round" stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $strokeDashoffset }}" class="text-blue-500 progress-ring-circle dark:text-blue-400" />
                                            </svg>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <span class="text-xs font-bold text-gray-900 dark:text-white">{{ $itemProgress }}%</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Item Details -->
                                        <div class="flex-1">
                                            <h4 class="text-base font-bold text-gray-900 dark:text-white mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                {{ $item->cobitItem->nama_item ?? 'Undefined Process' }}
                                            </h4>
                                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">
                                                {{ $item->cobitItem->deskripsi ?? 'No documentation available.' }}
                                            </p>
                                            
                                            <!-- Progress Bar -->
                                            <div class="w-full h-2 overflow-hidden bg-gray-200 rounded-full dark:bg-gray-700">
                                                <div class="h-full transition-all duration-700 ease-out rounded-full bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-600" style="width: {{ $itemProgress }}%"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Action Button -->
                                        @if($assessment->status === 'in_progress')
                                            <div class="flex items-center">
                                                <a href="{{ route('audit.showCategories', $item->cobitItem) }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-medium rounded-lg transition-all flex items-center">
                                                    Akses
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="py-12 text-center">
                                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full dark:bg-gray-800">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-400">Tidak ada item dalam assessment ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right: Stats & Timeline -->
                <div class="space-y-6">
                    
                    <!-- Progress Summary -->
                    @php
                        $totalItems = $assessment->items->count();
                        $completedItems = $assessment->items->where('progress', 100)->count();
                        $percentage = $assessment->progress ?? 0;
                        $radius = 60;
                        $circumference = 2 * M_PI * $radius;
                        $strokeDashoffset = $circumference - ($percentage / 100) * $circumference;
                    @endphp

                    <div class="p-6 bg-slate-900/50 border border-slate-700 shadow-xl dark:bg-slate-800/90 glass-effect rounded-2xl text-center animate-fadeIn">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider mb-6">Overall Progress</h3>
                        
                        <!-- Circular Progress -->
                        <div class="relative w-40 h-40 mx-auto mb-6">
                            <svg class="w-full h-full progress-ring" viewBox="0 0 140 140">
                                <circle cx="70" cy="70" r="{{ $radius }}" fill="none" stroke="currentColor" stroke-width="10" class="text-gray-200 dark:text-gray-700" />
                                <circle cx="70" cy="70" r="{{ $radius }}" fill="none" stroke="currentColor" stroke-width="10" stroke-linecap="round" stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $strokeDashoffset }}" class="text-blue-500 progress-ring-circle dark:text-blue-400" />
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $percentage }}%</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 uppercase">Selesai</span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="p-4 bg-white dark:bg-slate-800/70 border border-gray-200 dark:border-slate-700 rounded-xl flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Total Items</span>
                                <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalItems }}</span>
                            </div>
                            <div class="p-4 bg-white dark:bg-slate-800/70 border border-gray-200 dark:border-slate-700 rounded-xl flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Selesai</span>
                                <span class="text-xl font-bold text-green-600 dark:text-green-400">{{ $completedItems }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Audit Timeline -->
                    <div class="p-6 bg-slate-900/50 border border-slate-700 shadow-xl dark:bg-slate-800/90 glass-effect rounded-2xl animate-fadeIn">
                        <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider mb-6">Audit Timeline</h3>
                        
                        @php
                            $steps = [
                                ['label' => 'Dibuat', 'time' => $assessment->created_at, 'active' => true],
                                ['label' => 'Disubmit', 'time' => $assessment->submitted_at, 'active' => !!$assessment->submitted_at],
                                ['label' => 'Disetujui', 'time' => $assessment->approved_at, 'active' => !!$assessment->approved_at],
                                ['label' => 'Eksekusi', 'time' => $assessment->completed_at, 'active' => !!$assessment->completed_at],
                                ['label' => 'Terverifikasi', 'time' => $assessment->verified_at, 'active' => !!$assessment->verified_at],
                            ];
                        @endphp

                        <div class="relative space-y-6 pl-6 border-l-2 border-gray-200 dark:border-gray-700">
                            @foreach($steps as $s)
                                <div class="relative {{ !$s['active'] ? 'opacity-40' : '' }}">
                                    <div class="absolute -left-[25px] top-0 w-3 h-3 rounded-full {{ $s['active'] ? 'bg-blue-500' : 'bg-gray-300 dark:bg-gray-600' }}"></div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $s['label'] }}</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $s['time'] ? $s['time']->format('d M Y, H:i') : 'Menunggu...' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>

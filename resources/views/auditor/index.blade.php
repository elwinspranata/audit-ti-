<x-auditor-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard Auditor</h1>
                <p class="text-gray-600 dark:text-gray-400">Verifikasi bukti dan jawaban assessment</p>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-3">
                <div class="p-6 bg-white rounded-lg shadow dark:bg-slate-800">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-12 h-12 text-orange-600 bg-orange-100 rounded-lg dark:bg-orange-900/30 dark:text-orange-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Menunggu Verifikasi</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['pending'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white rounded-lg shadow dark:bg-slate-800">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-12 h-12 text-green-600 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Diverifikasi Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['verified_today'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white rounded-lg shadow dark:bg-slate-800">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-12 h-12 text-purple-600 bg-purple-100 rounded-lg dark:bg-purple-900/30 dark:text-purple-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Diverifikasi</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['verified_total'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="p-4 mb-6 text-green-800 bg-green-100 border-l-4 border-green-500 rounded-lg dark:bg-green-900/30 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Pending Verification --}}
            <div class="p-6 mb-6 bg-white rounded-lg shadow dark:bg-slate-800">
                <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">Assessment Menunggu Verifikasi</h2>
                
                @if($pendingVerification->isEmpty())
                    <div class="p-8 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="mt-4 text-gray-500 dark:text-gray-400">Tidak ada assessment yang perlu diverifikasi</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($pendingVerification as $assessment)
                            <div class="p-4 border rounded-lg dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center justify-center w-10 h-10 font-semibold text-white bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full">
                                                {{ strtoupper(substr($assessment->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h3 class="font-medium text-gray-800 dark:text-white">{{ $assessment->name ?? 'Assessment #' . $assessment->id }}</h3>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $assessment->user->name }} - {{ $assessment->user->email }}</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap gap-2 mt-2 ml-13">
                                            @foreach($assessment->cobitItems->take(3) as $item)
                                                <span class="inline-flex items-center px-2 py-1 text-xs text-purple-700 bg-purple-100 rounded dark:bg-purple-900/30 dark:text-purple-400">
                                                    {{ $item->nama_item }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Selesai pada</p>
                                            <p class="font-medium text-gray-800 dark:text-white">{{ $assessment->completed_at ? $assessment->completed_at->format('d M Y') : '-' }}</p>
                                        </div>
                                        <a href="{{ route('auditor.assessments.show', $assessment) }}" 
                                            class="px-4 py-2 text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                                            Verifikasi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4">
                        {{ $pendingVerification->links() }}
                    </div>
                @endif
            </div>

            {{-- Recently Verified --}}
            @if($verified->isNotEmpty())
                <div class="p-6 bg-white rounded-lg shadow dark:bg-slate-800">
                    <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">Terakhir Diverifikasi</h2>
                    <div class="space-y-3">
                        @foreach($verified as $assessment)
                            <div class="flex items-center justify-between p-3 border rounded-lg dark:border-slate-700">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center w-8 h-8 text-green-600 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-white">{{ $assessment->name ?? 'Assessment #' . $assessment->id }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $assessment->user->name }}</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $assessment->verified_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-auditor-layout>

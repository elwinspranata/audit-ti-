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
                <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
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
                <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
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
                <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
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
            <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">Assessment Menunggu Verifikasi</h2>
            <div class="mb-10">
                @if($pendingVerification->isEmpty())
                    <div class="p-8 text-center bg-gray-50/50 dark:bg-gray-800/20 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                        <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="mt-4 text-gray-500 dark:text-gray-400">Tidak ada assessment yang perlu diverifikasi</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($pendingVerification as $assessment)
                            <div class="p-6 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-blue-400 transition-all duration-200">
                                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center justify-center w-10 h-10 font-semibold text-white bg-gradient-to-br from-sky-500 to-blue-600 rounded-full shadow-lg shadow-blue-500/20">
                                                {{ strtoupper(substr($assessment->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h3 class="font-medium text-gray-800 dark:text-white">{{ $assessment->name ?? 'Assessment #' . $assessment->id }}</h3>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $assessment->user->name }} - {{ $assessment->user->email }}</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap gap-2 mt-2 ml-13">
                                            @foreach($assessment->cobitItems->take(3) as $item)
                                                <span class="inline-flex items-center px-2 py-1 text-xs text-blue-700 bg-blue-100 rounded dark:bg-blue-900/30 dark:text-blue-400">
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
                                            class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all shadow-md shadow-blue-500/20">
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
                <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                    <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">Terakhir Diverifikasi</h2>
                    <div class="space-y-3">
                        @foreach($verified as $assessment)
                            <div class="flex items-center justify-between p-3 border rounded-lg dark:border-gray-700">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center w-8 h-8 text-green-600 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <a href="{{ route('auditor.assessments.show', $assessment) }}" class="font-medium text-gray-800 dark:text-white hover:text-blue-600 transition-colors">
                                            {{ $assessment->name ?? 'Assessment #' . $assessment->id }}
                                        </a>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $assessment->user->name }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mr-2">{{ $assessment->verified_at->diffForHumans() }}</p>
                                    @if($assessment->auditReport)
                                        <a href="{{ route('auditor.report.pdf', $assessment->auditReport) }}" 
                                           target="_blank"
                                           class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg dark:text-blue-400 dark:hover:bg-blue-900/20 transition-colors" 
                                           title="Download PDF">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </a>

                                        <a href="{{ route('auditor.report.show', $assessment->auditReport) }}" 
                                           class="px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all shadow-sm">
                                            Lihat Laporan
                                        </a>
                                    @else
                                        <a href="{{ route('auditor.report.create', $assessment) }}" 
                                           class="px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all shadow-sm">
                                            Buat Laporan
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-auditor-layout>

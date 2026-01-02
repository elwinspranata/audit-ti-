<x-admin-layout>
    <style>
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.5s ease-out forwards; }
        .animation-delay-100 { animation-delay: 0.1s; opacity: 0; }
        .animation-delay-200 { animation-delay: 0.2s; opacity: 0; }
    </style>

    <div class="py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8 animate-fadeInUp">
            <a href="{{ route('admin.assessments.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors mb-4 group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg text-xs font-semibold">
                            Assessment
                        </span>
                        <span class="text-gray-400 dark:text-gray-500">•</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $assessment->created_at->format('d M Y') }}</span>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                        {{ $assessment->name ?? 'Untitled Audit' }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Detail analisis dan progress tracking untuk assessment IT Process.</p>
                </div>
                
                <div class="flex gap-2">
                    @if($assessment->status == 'pending_approval')
                        <form action="{{ route('admin.assessments.approve', $assessment) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-lg shadow-green-500/25 transition-all text-sm">
                                Setujui
                            </button>
                        </form>
                        <button onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow-lg shadow-red-500/25 transition-all text-sm">
                            Tolak
                        </button>
                    @endif
                    <a href="{{ route('admin.assessments.edit', $assessment) }}" class="px-5 py-2.5 bg-gray-700 dark:bg-slate-700 hover:bg-gray-800 dark:hover:bg-slate-600 text-white font-semibold rounded-xl border border-gray-600 dark:border-slate-600 transition-all text-sm">
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column: User & Progress --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- User Card --}}
                <div class="p-6 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl shadow-lg animate-fadeInUp animation-delay-100" style="opacity:0;">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi User
                    </h2>
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-2xl font-bold text-white shadow-lg">
                            {{ strtoupper(substr($assessment->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">{{ $assessment->user->name }}</h3>
                            <p class="text-gray-500 dark:text-gray-400">{{ $assessment->user->email }}</p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="inline-flex items-center px-2.5 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg text-xs font-semibold">
                                    {{ ucfirst($assessment->user->role) }}
                                </span>
                                <span class="text-xs text-gray-400 dark:text-gray-500">ID: #{{ str_pad($assessment->user->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Progress Details --}}
                <div class="p-6 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl shadow-lg animate-fadeInUp animation-delay-200" style="opacity:0;">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        COBIT Framework Coverage
                    </h2>
                    <div class="space-y-4">
                        @foreach($assessment->items as $item)
                            <div class="p-5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl group hover:border-blue-400 dark:hover:border-blue-500 transition-all">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gray-200 dark:bg-slate-700 rounded-xl flex items-center justify-center text-sm font-bold text-gray-600 dark:text-gray-400 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                                            {{ $item->cobitItem->nama_item }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800 dark:text-white">{{ $item->cobitItem->nama_item }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md">{{ Str::limit($item->cobitItem->deskripsi, 80) }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Progress</p>
                                        <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $item->progress }}%</span>
                                    </div>
                                </div>
                                <div class="w-full h-2.5 bg-gray-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full transition-all duration-500" style="width: {{ $item->progress }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right Column: Status & Timeline --}}
            <div class="space-y-6">
                {{-- Status Card --}}
                <div class="p-6 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl shadow-lg animate-fadeInUp animation-delay-100" style="opacity:0;">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Status
                    </h2>
                    
                    @php
                        $statusConfig = [
                            'pending_submission' => ['bg' => 'bg-gray-100 dark:bg-slate-700', 'text' => 'text-gray-600 dark:text-gray-400', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'pending_approval' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-700 dark:text-yellow-400', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'approved' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-400', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'in_progress' => ['bg' => 'bg-indigo-100 dark:bg-indigo-900/30', 'text' => 'text-indigo-700 dark:text-indigo-400', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                            'completed' => ['bg' => 'bg-orange-100 dark:bg-orange-900/30', 'text' => 'text-orange-700 dark:text-orange-400', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                            'verified' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-700 dark:text-green-400', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                            'rejected' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-700 dark:text-red-400', 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ];
                        $current = $statusConfig[$assessment->status] ?? $statusConfig['pending_submission'];
                    @endphp
                    
                    <div class="flex items-center gap-4 p-4 {{ $current['bg'] }} rounded-xl">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $current['icon'] }}"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Status Saat Ini</p>
                            <p class="text-lg font-bold {{ $current['text'] }}">{{ $assessment->status_label }}</p>
                        </div>
                    </div>

                    @if($assessment->status == 'rejected' && $assessment->rejection_reason)
                        <div class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                            <p class="text-xs font-semibold text-red-600 dark:text-red-400 uppercase mb-1">Alasan Penolakan</p>
                            <p class="text-sm text-red-700 dark:text-red-300">{{ $assessment->rejection_reason }}</p>
                        </div>
                    @endif

                    @if($assessment->admin_notes)
                        <div class="mt-4 p-4 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1">Catatan Admin</p>
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $assessment->admin_notes }}</p>
                        </div>
                    @endif
                </div>

                {{-- Timeline Card --}}
                <div class="p-6 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl shadow-lg animate-fadeInUp animation-delay-200" style="opacity:0;">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-6 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Timeline
                    </h2>
                    
                    <div class="relative space-y-6">
                        <div class="absolute left-3 top-2 bottom-2 w-0.5 bg-gradient-to-b from-blue-500 via-gray-300 dark:via-slate-600 to-gray-200 dark:to-slate-700"></div>
                        
                        <div class="relative pl-10">
                            <div class="absolute left-0 top-1 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center ring-4 ring-white dark:ring-slate-800">
                                <div class="w-2 h-2 bg-white rounded-full"></div>
                            </div>
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Dibuat</p>
                            <p class="font-semibold text-gray-800 dark:text-white">Assessment Initialized</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $assessment->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        @if($assessment->submitted_at)
                            <div class="relative pl-10">
                                <div class="absolute left-0 top-1 w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center ring-4 ring-white dark:ring-slate-800">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Diajukan</p>
                                <p class="font-semibold text-gray-800 dark:text-white">Submitted for Approval</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $assessment->submitted_at->format('d M Y, H:i') }}</p>
                            </div>
                        @endif

                        @if($assessment->approved_at)
                            <div class="relative pl-10">
                                <div class="absolute left-0 top-1 w-6 h-6 {{ $assessment->status == 'rejected' ? 'bg-red-500' : 'bg-green-500' }} rounded-full flex items-center justify-center ring-4 ring-white dark:ring-slate-800">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">{{ $assessment->status == 'rejected' ? 'Ditolak' : 'Disetujui' }}</p>
                                <p class="font-semibold text-gray-800 dark:text-white">{{ $assessment->status == 'rejected' ? 'Request Rejected' : 'Approved by Admin' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $assessment->approved_at->format('d M Y, H:i') }}</p>
                                @if($assessment->approver)
                                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">by {{ $assessment->approver->name }}</p>
                                @endif
                            </div>
                        @endif

                        @if($assessment->completed_at)
                            <div class="relative pl-10">
                                <div class="absolute left-0 top-1 w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center ring-4 ring-white dark:ring-slate-800">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Selesai</p>
                                <p class="font-semibold text-gray-800 dark:text-white">Assessment Completed</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $assessment->completed_at->format('d M Y, H:i') }}</p>
                            </div>
                        @endif

                        @if($assessment->verified_at)
                            <div class="relative pl-10">
                                <div class="absolute left-0 top-1 w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center ring-4 ring-white dark:ring-slate-800">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Terverifikasi</p>
                                <p class="font-semibold text-gray-800 dark:text-white">Verified by Auditor</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $assessment->verified_at->format('d M Y, H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl p-6 max-w-md w-full shadow-2xl">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Tolak Assessment</h3>
            <form action="{{ route('admin.assessments.reject', $assessment) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Alasan Penolakan</label>
                    <textarea name="rejection_reason" required rows="4" 
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white transition-all"
                        placeholder="Berikan alasan mengapa assessment ini ditolak..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" 
                        class="flex-1 py-2.5 text-gray-600 dark:text-gray-400 font-medium hover:text-gray-800 dark:hover:text-white transition-all">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow-lg shadow-red-500/25 transition-all">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

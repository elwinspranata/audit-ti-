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
        <div class="flex flex-col gap-6 mb-8 md:flex-row md:items-center md:justify-between animate-fadeInUp">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                    Manajemen Assessment
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Pantau dan kelola seluruh aktivitas audit sistem informasi.
                </p>
            </div>
            <a href="{{ route('admin.assessments.create') }}" 
                class="inline-flex items-center px-6 py-3 text-sm font-semibold text-white transition-all bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Buat Assessment Baru
            </a>
        </div>

        {{-- Filter Section --}}
        <div class="p-6 mb-8 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl shadow-lg animate-fadeInUp animation-delay-100" style="opacity:0;">
            <form method="GET" action="{{ route('admin.assessments.index') }}" class="grid gap-4 md:grid-cols-4 md:items-end">
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Cari Assessment / User</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Nama assessment, user, atau email..."
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-all">
                        <option value="all">Semua Status</option>
                        <option value="pending_approval" {{ request('status') == 'pending_approval' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                    </select>
                </div>
                <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-gray-800 dark:bg-slate-700 border border-gray-700 dark:border-slate-600 rounded-xl hover:bg-gray-700 dark:hover:bg-slate-600 transition-all shadow-md">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter
                </button>
            </form>
        </div>

        @if (session('success'))
            <div class="p-4 mb-6 text-green-700 bg-green-100 dark:bg-green-900/30 dark:text-green-400 border border-green-300 dark:border-green-500/50 rounded-xl">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if($assessments->isEmpty())
            <div class="p-16 text-center bg-white dark:bg-slate-800/50 border-2 border-dashed border-gray-300 dark:border-slate-700 rounded-2xl shadow-lg animate-fadeInUp animation-delay-200" style="opacity:0;">
                <div class="inline-flex items-center justify-center w-20 h-20 mb-6 bg-gray-100 dark:bg-slate-700 rounded-2xl text-gray-400 dark:text-slate-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Tidak Ada Data Assessment</h3>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Sesuaikan filter atau buat assessment baru untuk memulai.</p>
                <a href="{{ route('admin.assessments.create') }}" class="inline-flex items-center mt-6 px-6 py-3 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Buat Assessment Pertama
                </a>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 animate-fadeInUp animation-delay-200" style="opacity:0;">
                @foreach($assessments as $assessment)
                    <div class="flex flex-col overflow-hidden transition-all duration-300 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl group hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-xl hover:-translate-y-1">
                        <div class="p-6">
                            {{-- User Info & Status --}}
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center w-11 h-11 font-bold text-white bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-md">
                                        {{ strtoupper(substr($assessment->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                            {{ $assessment->user->name }}
                                        </h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $assessment->user->email }}</p>
                                    </div>
                                </div>
                                @php
                                    $statusStyles = [
                                        'pending_submission' => 'bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-gray-400',
                                        'pending_approval' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'approved' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        'in_progress' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
                                        'completed' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                        'verified' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                        'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusStyles[$assessment->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ $assessment->status_label }}
                                </span>
                            </div>

                            {{-- Assessment Name --}}
                            <h4 class="mb-3 text-lg font-bold text-gray-800 dark:text-white leading-tight">
                                {{ $assessment->name ?? 'Untitled Assessment' }}
                            </h4>

                            {{-- COBIT Tags --}}
                            <div class="flex flex-wrap gap-1.5 mb-4">
                                @foreach($assessment->cobitItems->take(3) as $item)
                                    <span class="px-2 py-0.5 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 rounded-md">
                                        {{ $item->nama_item }}
                                    </span>
                                @endforeach
                                @if($assessment->cobitItems->count() > 3)
                                    <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center">+{{ $assessment->cobitItems->count() - 3 }} lainnya</span>
                                @endif
                            </div>

                            {{-- Progress --}}
                            <div class="space-y-2 pt-4 border-t border-gray-100 dark:border-slate-700">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Progress</span>
                                    <span class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ $assessment->progress ?? 0 }}%</span>
                                </div>
                                <div class="w-full h-2 bg-gray-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full transition-all duration-500" style="width: {{ $assessment->progress ?? 0 }}%"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-auto p-4 bg-gray-50 dark:bg-slate-900/50 flex gap-2 border-t border-gray-100 dark:border-slate-700">
                            <a href="{{ route('admin.assessments.show', $assessment) }}" 
                                class="flex-1 py-2.5 text-center text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-xl transition-all">
                                Lihat Detail
                            </a>
                            @if($assessment->status == 'pending_approval')
                                <form action="{{ route('admin.assessments.approve', $assessment) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2.5 text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl hover:bg-green-100 dark:hover:bg-green-900/40 transition-all" title="Setujui">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.assessments.destroy', $assessment) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus assessment ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/40 transition-all" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $assessments->withQueryString()->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>

<x-admin-layout>
    <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8 flex justify-between items-center animate-fadeInDown">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white bg-clip-text text-transparent bg-gradient-to-r from-sky-400 via-sky-300 to-cyan-400">
                    Manajemen Paket Layanan
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Kelola paket berlangganan dan fitur yang tersedia
                </p>
            </div>
            <a href="{{ route('admin.packages.create') }}"
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg shadow-sky-500/30 transition-all duration-300 transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Paket
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-400/10 border border-emerald-200 dark:border-emerald-700 text-emerald-700 dark:text-emerald-300 animate-fadeInUp">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-400/10 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 animate-fadeInUp">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- Statistics --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white/80 backdrop-blur-md dark:bg-slate-800/80 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl animate-fadeInUp">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Paket</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $packages->count() }}</h3>
                    </div>
                    <div class="p-3 bg-blue-500/10 rounded-xl">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-md dark:bg-slate-800/80 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl animate-fadeInUp">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Paket Aktif</p>
                        <h3 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ $packages->where('is_active', true)->count() }}</h3>
                    </div>
                    <div class="p-3 bg-emerald-500/10 rounded-xl">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-md dark:bg-slate-800/80 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl animate-fadeInUp">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nonaktif</p>
                        <h3 class="text-2xl font-bold text-gray-500 dark:text-gray-400 mt-1">{{ $packages->where('is_active', false)->count() }}</h3>
                    </div>
                    <div class="p-3 bg-gray-500/10 rounded-xl">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-md dark:bg-slate-800/80 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl animate-fadeInUp">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Transaksi</p>
                        <h3 class="text-2xl font-bold text-purple-600 dark:text-purple-400 mt-1">{{ $packages->sum('transactions_count') }}</h3>
                    </div>
                    <div class="p-3 bg-purple-500/10 rounded-xl">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Package Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-fadeInUp">
            @forelse($packages as $package)
                @php
                    $levelColors = [
                        1 => ['bg' => 'from-blue-500 to-blue-600', 'badge' => 'bg-blue-100 dark:bg-blue-400/10 text-blue-600 dark:text-blue-400'],
                        2 => ['bg' => 'from-indigo-500 to-indigo-600', 'badge' => 'bg-indigo-100 dark:bg-indigo-400/10 text-indigo-600 dark:text-indigo-400'],
                        3 => ['bg' => 'from-purple-500 to-purple-600', 'badge' => 'bg-purple-100 dark:bg-purple-400/10 text-purple-600 dark:text-purple-400'],
                    ];
                    $color = $levelColors[$package->level] ?? $levelColors[1];
                @endphp

                <div class="relative bg-white/80 backdrop-blur-md dark:bg-slate-800/80 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 {{ !$package->is_active ? 'opacity-60' : '' }}">

                    {{-- Popular Badge --}}
                    @if($package->is_popular)
                        <div class="absolute top-0 right-0 -mr-1 -mt-1 z-10">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-white bg-gradient-to-r from-amber-500 to-orange-500 rounded-bl-lg rounded-tr-xl shadow-lg">
                                ⭐ POPULER
                            </span>
                        </div>
                    @endif

                    {{-- Inactive Overlay --}}
                    @if(!$package->is_active)
                        <div class="absolute top-3 left-3 z-10">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-red-600 bg-red-100 dark:bg-red-400/10 dark:text-red-400 rounded-lg">
                                NONAKTIF
                            </span>
                        </div>
                    @endif

                    {{-- Card Header --}}
                    <div class="bg-gradient-to-r {{ $color['bg'] }} p-6 text-white">
                        <h3 class="text-xl font-bold">{{ $package->name }}</h3>
                        <div class="flex items-baseline mt-2">
                            <span class="text-sm opacity-80">Rp</span>
                            <span class="text-3xl font-extrabold ml-1">{{ number_format($package->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center mt-2 space-x-3 text-sm opacity-90">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $package->duration_days }} hari
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                Level {{ $package->level }}
                            </span>
                        </div>
                    </div>

                    {{-- Features List --}}
                    <div class="p-6">
                        <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Fitur ({{ $package->features_count }})</h4>
                        @if($package->features_count > 0)
                            <ul class="space-y-2 mb-4 max-h-32 overflow-y-auto">
                                @foreach($package->features as $feature)
                                    <li class="flex items-center text-sm">
                                        @if($feature->is_included)
                                            <svg class="w-4 h-4 text-emerald-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-gray-700 dark:text-gray-300">{{ $feature->feature_name }}</span>
                                        @else
                                            <svg class="w-4 h-4 text-red-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-gray-400 dark:text-gray-500 line-through">{{ $feature->feature_name }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-400 dark:text-gray-500 italic mb-4">Belum ada fitur ditambahkan</p>
                        @endif

                        {{-- Stats --}}
                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 border-t border-gray-100 dark:border-slate-700 pt-4 mb-4">
                            <span>{{ $package->transactions_count }} transaksi</span>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2">
                            {{-- Toggle Active --}}
                            <form action="{{ route('admin.packages.toggle-active', $package) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" title="{{ $package->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                        class="p-2 rounded-lg transition-colors {{ $package->is_active ? 'text-emerald-600 bg-emerald-50 dark:bg-emerald-400/10 hover:bg-emerald-100' : 'text-gray-400 bg-gray-50 dark:bg-gray-400/10 hover:bg-gray-100' }}">
                                    @if($package->is_active)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    @endif
                                </button>
                            </form>

                            {{-- Toggle Popular --}}
                            <form action="{{ route('admin.packages.toggle-popular', $package) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" title="{{ $package->is_popular ? 'Hapus dari Populer' : 'Jadikan Populer' }}"
                                        class="p-2 rounded-lg transition-colors {{ $package->is_popular ? 'text-amber-600 bg-amber-50 dark:bg-amber-400/10 hover:bg-amber-100' : 'text-gray-400 bg-gray-50 dark:bg-gray-400/10 hover:bg-gray-100' }}">
                                    <svg class="w-5 h-5" fill="{{ $package->is_popular ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                </button>
                            </form>

                            {{-- Edit --}}
                            <a href="{{ route('admin.packages.edit', $package) }}"
                               class="p-2 rounded-lg text-blue-600 bg-blue-50 dark:bg-blue-400/10 hover:bg-blue-100 transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.packages.destroy', $package) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus paket &quot;{{ $package->name }}&quot;? Tindakan ini tidak dapat dibatalkan.')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg text-red-600 bg-red-50 dark:bg-red-400/10 hover:bg-red-100 transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">Belum ada paket layanan.</p>
                    <a href="{{ route('admin.packages.create') }}" class="inline-flex items-center mt-4 px-6 py-3 bg-gradient-to-r from-sky-500 to-blue-600 text-white font-semibold rounded-xl hover:from-sky-600 hover:to-blue-700 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Buat Paket Pertama
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInDown { animation: fadeInDown 0.6s ease-out forwards; }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }
    </style>
</x-admin-layout>

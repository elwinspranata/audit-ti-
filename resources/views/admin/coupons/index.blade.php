<x-admin-layout>
    <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-8 flex justify-between items-center animate-fadeInDown">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white bg-clip-text text-transparent bg-gradient-to-r from-sky-400 via-sky-300 to-cyan-400">
                    Manajemen Voucher Diskon
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Kelola voucher promo dan diskon untuk pelanggan
                </p>
            </div>
            <a href="{{ route('admin.coupons.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg shadow-sky-500/30 transition-all duration-300 transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Voucher
            </a>
        </div>

        {{-- Statistics Row --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white/80 backdrop-blur-md dark:bg-slate-800/80 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl animate-fadeInUp">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Voucher</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $coupons->total() }}</h3>
                    </div>
                    <div class="p-3 bg-blue-500/10 rounded-xl">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                    </div>
                </div>
            </div>
            {{-- Tambahkan statistik lain jika perlu --}}
        </div>

        {{-- Filter Section --}}
        <div class="mb-6 bg-white/80 backdrop-blur-md dark:bg-slate-800/80 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl animate-fadeInUp">
            <form action="{{ route('admin.coupons.index') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-200 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300"
                               placeholder="Cari kode voucher...">
                    </div>
                </div>
                <div class="w-48">
                    <select name="status" onchange="this.form.submit()"
                            class="block w-full py-2.5 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-200 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                </div>
                <div class="w-48">
                    <select name="package_id" onchange="this.form.submit()"
                            class="block w-full py-2.5 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-200 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300">
                        <option value="">Semua Paket</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" {{ request('package_id') == $package->id ? 'selected' : '' }}>
                                {{ $package->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-6 py-2.5 bg-gray-800 dark:bg-slate-700 text-white rounded-xl hover:bg-gray-700 dark:hover:bg-slate-600 transition-all duration-300">
                    Filter
                </button>
            </form>
        </div>

        {{-- Table Section --}}
        <div class="bg-white/80 backdrop-blur-md dark:bg-slate-800/80 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-2xl overflow-hidden animate-fadeInUp">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 uppercase text-xs font-bold tracking-wider">
                            <th class="px-6 py-4">Kode</th>
                            <th class="px-6 py-4">Paket</th>
                            <th class="px-6 py-4">Diskon</th>
                            <th class="px-6 py-4">Masa Berlaku</th>
                            <th class="px-6 py-4 text-center">Penggunaan</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($coupons as $coupon)
                        <tr class="group hover:bg-gray-50/50 dark:hover:bg-slate-900/50 transition-colors duration-200">
                            <td class="px-6 py-4 align-middle">
                                <span class="font-mono font-bold text-sky-600 dark:text-sky-400 bg-sky-50 dark:bg-sky-400/10 px-3 py-1 rounded-lg whitespace-nowrap">
                                    {{ $coupon->code }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                @if($coupon->package)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-lg bg-purple-100 dark:bg-purple-400/10 text-purple-600 dark:text-purple-400 whitespace-nowrap">
                                        {{ $coupon->package->name }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-lg bg-gray-100 dark:bg-gray-400/10 text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                        Semua Paket
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-middle text-gray-700 dark:text-gray-300">
                                @if($coupon->type === 'percentage')
                                    <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($coupon->value) }}%</span>
                                @else
                                    <span class="font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">Rp {{ number_format($coupon->value, 0, ',', '.') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-middle text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex flex-col whitespace-nowrap">
                                    <span>Dari: {{ $coupon->starts_at ? $coupon->starts_at->format('d M Y') : 'Sekarang' }}</span>
                                    <span>Sampai: {{ $coupon->expires_at ? $coupon->expires_at->format('d M Y') : 'Selamanya' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex flex-col items-center">
                                    <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-1.5 mb-1 max-w-[100px]">
                                        @php
                                            $percent = $coupon->usage_limit ? ($coupon->used_count / $coupon->usage_limit) * 100 : 0;
                                        @endphp
                                        <div class="bg-sky-500 h-1.5 rounded-full" style="width: {{ min($percent, 100) }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $coupon->used_count }}/{{ $coupon->usage_limit ?? '∞' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                @if($coupon->expires_at && $coupon->expires_at->isPast())
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 dark:bg-red-400/10 text-red-600 dark:text-red-400">
                                        Expired
                                    </span>
                                @elseif($coupon->is_active)
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-emerald-100 dark:bg-emerald-400/10 text-emerald-600 dark:text-emerald-400">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-400/10 text-gray-600 dark:text-gray-400">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.coupons.edit', $coupon) }}" 
                                       class="p-2 rounded-lg text-blue-600 bg-blue-50 dark:bg-blue-400/10 hover:bg-blue-100 transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Hapus voucher ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-red-600 bg-red-50 dark:bg-red-400/10 hover:bg-red-100 transition-colors" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada voucher yang ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($coupons->hasPages())
            <div class="px-6 py-4 bg-gray-50/50 dark:bg-slate-900/50 border-t border-gray-100 dark:border-slate-700">
                {{ $coupons->links() }}
            </div>
            @endif
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

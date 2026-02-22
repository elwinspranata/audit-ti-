<x-admin-layout>
    <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-8 flex justify-between items-center animate-fadeInDown">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white bg-clip-text text-transparent bg-gradient-to-r from-sky-400 via-sky-300 to-cyan-400">
                    Kelola Pembayaran
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Verifikasi dan pantau semua transaksi pembayaran</p>
            </div>
        </div>
        
        @if(session('success'))
            <div class="p-4 mb-6 text-sm text-emerald-700 bg-emerald-100 dark:bg-emerald-400/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 rounded-xl" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="bg-white/80 backdrop-blur-md dark:bg-slate-800/80 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 dark:bg-slate-700/50 dark:text-gray-400 border-b border-gray-100 dark:border-slate-700">
                        <tr>
                            <th class="px-6 py-4 font-bold">Tanggal</th>
                            <th class="px-6 py-4 font-bold">User</th>
                            <th class="px-6 py-4 font-bold text-center">Paket</th>
                            <th class="px-6 py-4 font-bold text-center">Potongan</th>
                            <th class="px-6 py-4 font-bold">Nominal</th>
                            <th class="px-6 py-4 font-bold text-center">Status Bayar</th>
                            <th class="px-6 py-4 font-bold text-center">Verifikasi</th>
                            <th class="px-6 py-4 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($transactions as $trx)
                        <tr class="group hover:bg-gray-50/50 dark:hover:bg-slate-900/50 transition-colors duration-200">
                            <td class="px-6 py-4 align-middle text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                {{ $trx->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $trx->user->name }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $trx->user->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-purple-100 dark:bg-purple-400/10 text-purple-600 dark:text-purple-400 whitespace-nowrap">
                                    {{ $trx->package->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                @if($trx->discount_amount > 0)
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="text-emerald-600 dark:text-emerald-400 font-bold whitespace-nowrap">
                                            -Rp {{ number_format($trx->discount_amount, 0, ',', '.') }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-600 uppercase tracking-wider">
                                            {{ $trx->coupon->code }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-gray-300 dark:text-gray-600">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <span class="font-bold text-gray-900 dark:text-white whitespace-nowrap">
                                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                @if($trx->payment_status == 'paid')
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-emerald-100 dark:bg-emerald-400/10 text-emerald-600 dark:text-emerald-400">
                                        Paid
                                    </span>
                                @elseif($trx->payment_status == 'pending')
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
                                        Pending
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 dark:bg-red-400/10 text-red-600 dark:text-red-400">
                                        {{ ucfirst($trx->payment_status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                @if($trx->admin_status == 'approved')
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-emerald-100 dark:bg-emerald-400/10 text-emerald-600 dark:text-emerald-400">
                                        Approved
                                    </span>
                                @elseif($trx->admin_status == 'pending')
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
                                        Pending
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 dark:bg-red-400/10 text-red-600 dark:text-red-400">
                                        {{ ucfirst($trx->admin_status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <a href="{{ route('admin.payments.show', $trx->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-xs font-bold rounded-lg transition-all transform hover:scale-105 shadow-md shadow-sky-500/20">
                                    VERIFIKASI
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <span>Belum ada data transaksi</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>

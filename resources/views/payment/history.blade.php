<x-app-layout>
    <div class="py-12 min-h-screen bg-slate-950 dark:bg-gray-900 bg-gradient-to-br from-slate-950 via-gray-900 to-slate-900">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h2 class="mb-6 text-3xl font-bold text-white">Riwayat Pembayaran</h2>
            <div class="overflow-hidden bg-slate-900/50 border border-slate-700 shadow-xl rounded-2xl backdrop-blur-sm">
                <div class="p-6 text-slate-300">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-slate-400 uppercase bg-slate-800/50 border-b border-slate-700">
                                <tr>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Kode Transaksi</th>
                                    <th class="px-6 py-3">Paket</th>
                                    <th class="px-6 py-3">Nominal</th>
                                    <th class="px-6 py-3">Status Bayar</th>
                                    <th class="px-6 py-3">Verifikasi Admin</th>
                                    <th class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $trx)
                                <tr class="bg-transparent border-b border-slate-800 hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4">{{ $trx->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 font-medium text-slate-200">{{ $trx->transaction_code }}</td>
                                    <td class="px-6 py-4">{{ $trx->package->name }}</td>
                                    <td class="px-6 py-4">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $trx->payment_status == 'paid' ? 'text-green-700 bg-green-100' : ($trx->payment_status == 'pending' ? 'text-orange-700 bg-orange-100' : 'text-red-700 bg-red-100') }}">
                                            {{ ucfirst($trx->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $trx->admin_status == 'approved' ? 'text-green-700 bg-green-100' : ($trx->admin_status == 'pending' ? 'text-orange-700 bg-orange-100' : 'text-red-700 bg-red-100') }}">
                                            {{ ucfirst($trx->admin_status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('payment.show', $trx->id) }}" class="font-medium text-blue-600 hover:underline">Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat transaksi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

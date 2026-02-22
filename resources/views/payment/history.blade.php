<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h2 class="mb-6 text-2xl font-semibold text-gray-800 dark:text-gray-200">Riwayat Pembayaran</h2>
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg border dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Kode Transaksi</th>
                                    <th class="px-6 py-3">Paket</th>
                                    <th class="px-6 py-3 text-center">Potongan</th>
                                    <th class="px-6 py-3">Total Bayar</th>
                                    <th class="px-6 py-3">Status Bayar</th>
                                    <th class="px-6 py-3">Verifikasi Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $trx)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $trx->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $trx->transaction_code }}</td>
                                    <td class="px-6 py-4">{{ $trx->package->name }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($trx->discount_amount > 0)
                                            <div class="text-green-600 font-bold whitespace-nowrap">-Rp{{ number_format($trx->discount_amount, 0, ',', '.') }}</div>
                                            <div class="text-[10px] text-gray-500 font-mono">{{ $trx->coupon->code }}</div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-blue-600 dark:text-blue-400 whitespace-nowrap">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full whitespace-nowrap {{ $trx->payment_status == 'paid' ? 'text-green-700 bg-green-100' : ($trx->payment_status == 'pending' ? 'text-orange-700 bg-orange-100' : 'text-red-700 bg-red-100') }}">
                                            {{ $trx->payment_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full whitespace-nowrap {{ $trx->admin_status == 'approved' ? 'text-green-700 bg-green-100' : ($trx->admin_status == 'pending' ? 'text-orange-700 bg-orange-100' : 'text-red-700 bg-red-100') }}">
                                            {{ $trx->admin_status }}
                                        </span>
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

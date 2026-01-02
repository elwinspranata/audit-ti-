<x-admin-layout>
    <div class="container py-5">
        <h2 class="mb-4 text-xl font-semibold text-gray-800 dark:text-gray-200">Kelola Pembayaran</h2>
        
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">User</th>
                                <th class="px-6 py-3">Paket</th>
                                <th class="px-6 py-3">Nominal</th>
                                <th class="px-6 py-3">Status Bayar</th>
                                <th class="px-6 py-3">Verifikasi</th>
                                <th class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4">{{ $trx->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $trx->user->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $trx->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">{{ $trx->package->name }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 font-semibold leading-tight rounded-full {{ $trx->payment_status == 'paid' ? 'text-green-700 bg-green-100 dark:bg-green-900 dark:text-green-200' : ($trx->payment_status == 'pending' ? 'text-orange-700 bg-orange-100 dark:bg-orange-900 dark:text-orange-200' : 'text-red-700 bg-red-100 dark:bg-red-900 dark:text-red-200') }}">
                                        {{ ucfirst($trx->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 font-semibold leading-tight rounded-full {{ $trx->admin_status == 'approved' ? 'text-green-700 bg-green-100 dark:bg-green-900 dark:text-green-200' : ($trx->admin_status == 'pending' ? 'text-orange-700 bg-orange-100 dark:bg-orange-900 dark:text-orange-200' : 'text-red-700 bg-red-100 dark:bg-red-900 dark:text-red-200') }}">
                                        {{ ucfirst($trx->admin_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.payments.show', $trx->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Verifikasi
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada data transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

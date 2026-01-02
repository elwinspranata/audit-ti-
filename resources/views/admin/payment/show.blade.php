<x-admin-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Verifikasi Pembayaran</h3>
                        <a href="{{ route('admin.payments.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">&laquo; Kembali</a>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <h4 class="mb-4 text-md font-medium text-gray-700 dark:text-gray-300">Informasi Transaksi</h4>
                            <div class="space-y-3">
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Kode Transaksi</div>
                                    <div class="col-span-2 text-sm text-gray-900 dark:text-white">{{ $transaction->transaction_code }}</div>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">User</div>
                                    <div class="col-span-2 text-sm text-gray-900 dark:text-white">
                                        {{ $transaction->user->name }}
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $transaction->user->email }}</div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Paket</div>
                                    <div class="col-span-2 text-sm text-gray-900 dark:text-white">{{ $transaction->package->name }}</div>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tagihan</div>
                                    <div class="col-span-2 text-sm font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</div>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Midtrans</div>
                                    <div class="col-span-2">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $transaction->payment_status == 'paid' ? 'text-green-700 bg-green-100 dark:bg-green-900 dark:text-green-200' : 'text-orange-700 bg-orange-100 dark:bg-orange-900 dark:text-orange-200' }}">
                                            {{ ucfirst($transaction->payment_status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                            <h4 class="mb-4 text-md font-medium text-gray-700 dark:text-gray-300">Keputusan Admin</h4>
                            <form action="{{ route('admin.payments.verify', $transaction->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                
                                <div class="mb-4">
                                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Status Verifikasi</label>
                                    <select name="admin_status" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="approved" {{ $transaction->admin_status == 'approved' ? 'selected' : '' }}>Setujui (Approve)</option>
                                        <option value="rejected" {{ $transaction->admin_status == 'rejected' ? 'selected' : '' }}>Tolak (Reject)</option>
                                        <option value="pending" {{ $transaction->admin_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                </div>

                                <button type="submit" class="inline-flex items-center justify-center w-full px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25">
                                    Simpan Perubahan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

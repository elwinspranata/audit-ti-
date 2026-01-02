<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="mb-4 text-xl font-semibold">Detail Pembayaran</h2>
                    
                    @if(session('success'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                         <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="space-y-4">
                             <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Kode Transaksi</span>
                                <span class="font-medium text-gray-900">{{ $transaction->transaction_code }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Paket</span>
                                <span class="font-medium text-gray-900">{{ $transaction->package->name }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Total Tagihan</span>
                                <span class="text-lg font-bold text-blue-600">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Status Pembayaran</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $transaction->payment_status == 'paid' ? 'text-green-700 bg-green-100' : ($transaction->payment_status == 'pending' ? 'text-orange-700 bg-orange-100' : 'text-red-700 bg-red-100') }}">
                                    {{ ucfirst($transaction->payment_status) }}
                                </span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Status Verifikasi Admin</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $transaction->admin_status == 'approved' ? 'text-green-700 bg-green-100' : ($transaction->admin_status == 'pending' ? 'text-orange-700 bg-orange-100' : 'text-red-700 bg-red-100') }}">
                                    {{ ucfirst($transaction->admin_status) }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col justify-center p-6 bg-gray-50 rounded-lg">
                             @if($transaction->payment_status == 'pending')
                                <p class="mb-4 text-sm text-center text-gray-600">Silakan selesaikan pembayaran Anda.</p>
                                <button id="pay-button" class="w-full px-4 py-2 font-bold text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                                    Bayar Sekarang
                                </button>
                            @elseif($transaction->payment_status == 'paid' && $transaction->admin_status == 'pending')
                                <div class="p-4 text-sm text-blue-700 bg-blue-100 rounded-lg">
                                    Pembayaran berhasil! Silakan tunggu verifikasi admin untuk mengakses sistem (Maks 1x24 jam).
                                </div>
                            @elseif($transaction->payment_status == 'paid' && $transaction->admin_status == 'approved')
                                <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                                    Paket Anda aktif. Silakan akses menu <a href="{{ route('audit.index') }}" class="font-bold underline">Audit</a>.
                                </div>
                            @endif
                            
                            <div class="mt-6 text-center">
                                 <a href="{{ route('payment.history') }}" class="text-sm text-gray-500 hover:text-gray-800">Lihat Riwayat Pembayaran</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
        // Check if Snap is loaded
        if (typeof snap === 'undefined') {
            console.error('Midtrans Snap not loaded. Check CLIENT_KEY in .env or Internet connection.');
            // Optional: alert user or disable button
            const btn = document.getElementById('pay-button');
            if(btn) {
                btn.innerHTML = 'Error: Sistem Pembayaran Tidak Siap';
                btn.disabled = true;
                btn.classList.add('bg-red-500', 'cursor-not-allowed');
                btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            }
        }

        document.getElementById('pay-button').onclick = function(){
            if (typeof snap === 'undefined') {
                alert('Sistem pembayaran belum siap (Library tidak termuat). Silakan refresh atau kontak admin.');
                return;
            }
            snap.pay('{{ $transaction->snap_token }}', {
                onSuccess: function(result){
                    alert("pembayaran berhasil!"); 
                    location.reload();
                },
                onPending: function(result){
                    alert("menunggu pembayaran!"); console.log(result);
                },
                onError: function(result){
                    alert("pembayaran gagal!"); console.log(result);
                },
                onClose: function(){
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        };
    </script>
</x-app-layout>

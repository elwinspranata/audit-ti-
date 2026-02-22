<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-transparent sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="mb-6 text-xl font-semibold">Detail Pembayaran</h2>
                    
                    @if(session('success'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/40 dark:text-green-200" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                         <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/40 dark:text-red-200" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                        <!-- Informasi Transaksi -->
                        <div class="space-y-4">
                            <div class="flex justify-between border-b dark:border-gray-700 pb-2">
                                <span class="text-gray-600 dark:text-gray-400">Kode Transaksi</span>
                                <span class="font-medium">#{{ $transaction->transaction_code }}</span>
                            </div>
                            <div class="flex justify-between border-b dark:border-gray-700 pb-2">
                                <span class="text-gray-600 dark:text-gray-400">Paket</span>
                                <span class="font-medium text-lg">{{ $transaction->package->name }}</span>
                            </div>
                            <div class="flex justify-between border-b dark:border-gray-700 pb-2">
                                <span class="text-gray-600 dark:text-gray-400">Total Tagihan</span>
                                <div class="text-right">
                                    @if($transaction->discount_amount > 0)
                                        <div class="text-xs line-through text-gray-500">Rp {{ number_format($transaction->package->price, 0, ',', '.') }}</div>
                                        <div class="text-xs text-green-600 font-semibold mb-1">- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }} ({{ $transaction->coupon->code }})</div>
                                    @endif
                                    <span id="display-amount" class="text-xl font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="flex justify-between border-b dark:border-gray-700 pb-2">
                                <span class="text-gray-600 dark:text-gray-400">Status Pembayaran</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $transaction->payment_status == 'paid' ? 'text-green-700 bg-green-100' : ($transaction->payment_status == 'pending' ? 'text-orange-700 bg-orange-100' : 'text-red-700 bg-red-100') }}">
                                    {{ $transaction->payment_status }}
                                </span>
                            </div>
                            <div class="flex justify-between border-b dark:border-gray-700 pb-2">
                                <span class="text-gray-600 dark:text-gray-400">Verifikasi Admin</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $transaction->admin_status == 'approved' ? 'text-green-700 bg-green-100' : ($transaction->admin_status == 'pending' ? 'text-orange-700 bg-orange-100' : 'text-red-700 bg-red-100') }}">
                                    {{ $transaction->admin_status }}
                                </span>
                            </div>
                        </div>

                        <!-- Aksi Pembayaran -->
                        <div class="flex flex-col justify-center p-8 bg-gray-100/5 dark:bg-gray-700/20 rounded-2xl border border-gray-200 dark:border-gray-700">
                             @if($transaction->payment_status == 'pending')
                                <p class="mb-4 text-sm text-center text-gray-600 dark:text-gray-400">Silakan selesaikan pembayaran melalui gerbang pembayaran aman Midtrans.</p>
                                <button id="pay-button" class="w-full py-3 px-4 font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-lg active:scale-95">
                                    Bayar Sekarang
                                </button>
                            @elseif($transaction->payment_status == 'paid' && $transaction->admin_status == 'pending')
                                <div class="text-center">
                                    <div class="inline-flex items-center justify-center w-12 h-12 mb-4 bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-full">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <h4 class="font-bold text-gray-900 dark:text-white">Menunggu Verifikasi</h4>
                                    <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">Pembayaran berhasil. Admin akan memverifikasi dalam 1x24 jam.</p>
                                </div>
                            @elseif($transaction->payment_status == 'paid' && $transaction->admin_status == 'approved')
                                <div class="text-center">
                                    <div class="inline-flex items-center justify-center w-12 h-12 mb-4 bg-green-100 dark:bg-green-900/30 text-green-600 rounded-full">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <h4 class="font-bold text-gray-900 dark:text-white">Layanan Aktif</h4>
                                    <a href="{{ route('user.assessments.index') }}" class="mt-4 inline-block px-6 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition">Mulai Audit</a>
                                </div>
                            @endif
                            
                            @if($transaction->payment_status == 'pending')
                                <div class="mt-8 pt-6 border-t dark:border-gray-600" id="coupon-section" @if($transaction->discount_amount > 0) style="display:none;" @endif>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gunakan Kode Kupon</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="coupon-code" class="flex-1 rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-600 text-sm focus:ring-blue-500" placeholder="Masukkan kode">
                                        <button type="button" id="apply-coupon-btn" class="px-4 py-2 bg-gray-800 dark:bg-gray-600 text-white text-sm font-bold rounded-lg hover:bg-gray-900">Pasang</button>
                                    </div>
                                    <p id="coupon-message" class="mt-2 text-xs"></p>
                                </div>
                            @endif

                            <div class="mt-6 text-center">
                                 <a href="{{ route('payment.history') }}" class="text-sm font-medium text-gray-500 hover:text-blue-600 transition tracking-tight uppercase tracking-widest text-[10px]">RIWAYAT PEMBAYARAN</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
        if (typeof snap === 'undefined') {
            const btn = document.getElementById('pay-button');
            if(btn) {
                btn.innerHTML = 'SISTEM ERROR';
                btn.disabled = true;
                btn.classList.add('bg-red-500', 'cursor-not-allowed');
            }
        }

        let snapToken = '{{ $transaction->snap_token }}';

        const payBtn = document.getElementById('pay-button');
        if(payBtn) {
            payBtn.onclick = function(){
                if (typeof snap === 'undefined') {
                    alert('Sistem pembayaran belum siap.');
                    return;
                }
                snap.pay(snapToken, {
                    onSuccess: function(result){ location.reload(); },
                    onPending: function(result){ location.reload(); },
                    onError: function(result){ alert("Pembayaran gagal!"); },
                    onClose: function(){ alert('Anda menutup jendela pembayaran'); }
                });
            };
        }

        const applyCouponBtn = document.getElementById('apply-coupon-btn');
        if (applyCouponBtn) {
            applyCouponBtn.onclick = async function() {
                const code = document.getElementById('coupon-code').value;
                const messageEl = document.getElementById('coupon-message');
                const btn = this;

                if (!code) return;

                btn.disabled = true;
                btn.innerHTML = '...';
                messageEl.className = 'mt-2 text-xs text-gray-500';
                messageEl.innerText = 'Memproses...';

                try {
                    const response = await fetch('{{ route("payment.apply-coupon", $transaction->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ coupon_code: code })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        messageEl.className = 'mt-2 text-xs text-green-600 font-bold';
                        messageEl.innerText = data.message;
                        snapToken = data.snap_token;
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        messageEl.className = 'mt-2 text-xs text-red-600 font-bold';
                        messageEl.innerText = data.message || 'Gagal menerapkan kupon';
                        btn.disabled = false;
                        btn.innerHTML = 'Pasang';
                    }
                } catch (error) {
                    messageEl.className = 'mt-2 text-xs text-red-600 font-bold';
                    messageEl.innerText = 'Kesalahan sistem';
                    btn.disabled = false;
                    btn.innerHTML = 'Pasang';
                }
            };
        }
    </script>
</x-app-layout>

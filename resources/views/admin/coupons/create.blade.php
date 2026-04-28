<x-admin-layout>
    <div class="py-12 mx-auto max-w-4xl sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center gap-4 animate-fadeInDown">
            <a href="{{ route('admin.coupons.index') }}" class="p-2 bg-white dark:bg-slate-800 rounded-xl shadow-md text-gray-400 hover:text-sky-500 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white bg-clip-text text-transparent bg-gradient-to-r from-sky-400 via-sky-300 to-cyan-400">
                    Tambah Voucher Baru
                </h2>
                <p class="text-gray-600 dark:text-gray-400">Buat kode promo baru untuk sistem</p>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-md dark:bg-slate-800/80 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-2xl overflow-hidden animate-fadeInUp">
            <form action="{{ route('admin.coupons.store') }}" method="POST" class="p-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Kode Voucher --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Kode Voucher</label>
                        <div class="relative">
                            <input type="text" name="code" id="code" value="{{ old('code') }}" required
                                   class="block w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all uppercase"
                                   placeholder="CONTOH: PROMO2024">
                            <button type="button" onclick="generateCode()" 
                                    class="absolute right-2 top-2 px-3 py-1 bg-sky-500 text-white text-xs font-bold rounded-lg hover:bg-sky-600 transition-colors">
                                Generate
                            </button>
                        </div>
                        @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tipe Diskon --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tipe Diskon</label>
                        <select name="type" required
                                class="block w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-sky-500 transition-all">
                            <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Nominal Tetap (Rp)</option>
                        </select>
                        @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Berlaku Untuk Paket --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Berlaku Untuk Paket</label>
                        <select name="package_id"
                                class="block w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-sky-500 transition-all">
                            <option value="">Semua Paket</option>
                            @foreach($packages as $package)
                                <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                    {{ $package->name }} (Rp {{ number_format($package->price, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                        @error('package_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nilai Diskon --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nilai Diskon</label>
                        <input type="number" name="value" value="{{ old('value') }}" required
                               class="block w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-sky-500 transition-all"
                               placeholder="e.g. 10 atau 50000">
                        @error('value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal Mulai (Opsional)</label>
                        <input type="date" name="starts_at" value="{{ old('starts_at') }}"
                               class="block w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-sky-500 transition-all">
                        @error('starts_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal Kadaluarsa --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal Berakhir (Opsional)</label>
                        <input type="date" name="expires_at" value="{{ old('expires_at') }}"
                               class="block w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-sky-500 transition-all">
                        @error('expires_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Batas Penggunaan --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Batas Penggunaan (Opsional)</label>
                        <input type="number" name="usage_limit" value="{{ old('usage_limit') }}"
                               class="block w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-sky-500 transition-all"
                               placeholder="Kosongkan jika tidak terbatas">
                        @error('usage_limit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Status Aktif --}}
                    <div class="flex items-center gap-3">
                        <label class="relative inline-flex items-center cursor-pointer mt-6">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-sky-300 dark:peer-focus:ring-sky-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-sky-600"></div>
                            <span class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300">Aktifkan Sekarang</span>
                        </label>
                    </div>
                </div>

                <div class="mt-10 flex justify-end gap-3 font-semibold">
                    <a href="{{ route('admin.coupons.index') }}" 
                       class="px-6 py-3 bg-white dark:bg-slate-700 text-gray-700 dark:text-white border border-gray-200 dark:border-slate-600 rounded-xl hover:bg-gray-50 transition-all">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white rounded-xl shadow-lg shadow-sky-500/30 transition-all transform hover:scale-105">
                        Simpan Voucher
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function generateCode() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = '';
            for (let i = 0; i < 8; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('code').value = result;
        }
    </script>

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

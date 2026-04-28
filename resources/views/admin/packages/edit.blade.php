<x-admin-layout>
    <div class="py-12 mx-auto max-w-4xl sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8 animate-fadeInDown">
            <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-sky-500 dark:hover:text-sky-400 transition-colors mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Daftar Paket
            </a>
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white bg-clip-text text-transparent bg-gradient-to-r from-sky-400 via-sky-300 to-cyan-400">
                Edit Paket: {{ $package->name }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Ubah konfigurasi paket dan fitur yang tersedia</p>
        </div>

        {{-- Flash Messages --}}
        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-400/10 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.packages.update', $package) }}" method="POST" id="packageForm">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                {{-- Basic Information --}}
                <div class="bg-white/80 backdrop-blur-md dark:bg-slate-800/80 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl p-6 animate-fadeInUp">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Informasi Dasar
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Name --}}
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Paket <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $package->name) }}" required
                                   class="block w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-200 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300"
                                   placeholder="Contoh: Paket Premium">
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" id="price" name="price" value="{{ old('price', $package->price) }}" required min="0" step="1000"
                                   class="block w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-200 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300"
                                   placeholder="5000000">
                            @error('price')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Level --}}
                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Level Paket <span class="text-red-500">*</span></label>
                            <select id="level" name="level" required
                                    class="block w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-200 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300">
                                <option value="">Pilih Level</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('level', $package->level) == $i ? 'selected' : '' }}>Level {{ $i }}</option>
                                @endfor
                            </select>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Level menentukan CobitItem yang bisa diakses user</p>
                            @error('level')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Duration --}}
                        <div>
                            <label for="duration_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Durasi (Hari) <span class="text-red-500">*</span></label>
                            <input type="number" id="duration_days" name="duration_days" value="{{ old('duration_days', $package->duration_days) }}" required min="1"
                                   class="block w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-200 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300"
                                   placeholder="30">
                            @error('duration_days')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi</label>
                            <textarea id="description" name="description" rows="3"
                                      class="block w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-200 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300"
                                      placeholder="Deskripsi singkat paket (opsional)">{{ old('description', $package->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Toggles --}}
                        <div class="flex items-center space-x-8">
                            <label class="flex items-center cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }}
                                       class="w-5 h-5 text-sky-600 bg-gray-100 border-gray-300 rounded focus:ring-sky-500 dark:focus:ring-sky-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Aktif</span>
                            </label>

                            <label class="flex items-center cursor-pointer">
                                <input type="hidden" name="is_popular" value="0">
                                <input type="checkbox" name="is_popular" value="1" {{ old('is_popular', $package->is_popular) ? 'checked' : '' }}
                                       class="w-5 h-5 text-amber-600 bg-gray-100 border-gray-300 rounded focus:ring-amber-500 dark:focus:ring-amber-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Tandai Populer</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Features Section --}}
                <div class="bg-white/80 backdrop-blur-md dark:bg-slate-800/80 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl p-6 animate-fadeInUp">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Daftar Fitur
                        </h3>
                        <button type="button" id="addFeatureBtn"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-sky-600 dark:text-sky-400 bg-sky-50 dark:bg-sky-400/10 rounded-lg hover:bg-sky-100 dark:hover:bg-sky-400/20 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            Tambah Fitur
                        </button>
                    </div>

                    <div id="featuresContainer" class="space-y-3">
                        {{-- Existing features will be loaded via JS --}}
                    </div>

                    <div id="emptyFeaturesMessage" class="text-center py-8 text-gray-400 dark:text-gray-500" style="display:none;">
                        <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p>Belum ada fitur. Klik "Tambah Fitur" untuk menambahkan.</p>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('admin.packages.index') }}"
                       class="px-6 py-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-all duration-300">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg shadow-sky-500/30 transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Feature Row Template --}}
    <template id="featureTemplate">
        <div class="feature-row flex items-center gap-3 p-3 bg-gray-50 dark:bg-slate-900/50 rounded-xl border border-gray-100 dark:border-slate-700 transition-all duration-200 hover:border-sky-300 dark:hover:border-sky-600" data-index="__INDEX__">
            <div class="cursor-move text-gray-400 dark:text-gray-500 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
            </div>
            <div class="flex-1">
                <input type="text" name="features[__INDEX__][name]" required
                       class="block w-full px-3 py-2 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-200 text-sm focus:ring-sky-500 focus:border-sky-500 transition-all duration-300"
                       placeholder="Nama fitur...">
            </div>
            <label class="flex items-center cursor-pointer whitespace-nowrap">
                <input type="hidden" name="features[__INDEX__][is_included]" value="0">
                <input type="checkbox" name="features[__INDEX__][is_included]" value="1" checked
                       class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500 dark:bg-gray-700 dark:border-gray-600">
                <span class="ml-1.5 text-xs font-medium text-gray-600 dark:text-gray-400">Termasuk</span>
            </label>
            <button type="button" class="remove-feature p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-400/10 rounded-lg transition-colors" title="Hapus fitur">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('featuresContainer');
            const template = document.getElementById('featureTemplate');
            const addBtn = document.getElementById('addFeatureBtn');
            const emptyMessage = document.getElementById('emptyFeaturesMessage');
            let featureIndex = 0;

            function updateEmptyMessage() {
                const rows = container.querySelectorAll('.feature-row');
                emptyMessage.style.display = rows.length === 0 ? 'block' : 'none';
            }

            function addFeature(name = '', isIncluded = true) {
                const html = template.innerHTML
                    .replace(/__INDEX__/g, featureIndex);
                
                const div = document.createElement('div');
                div.innerHTML = html;
                const row = div.firstElementChild;

                if (name) {
                    row.querySelector('input[type="text"]').value = name;
                }
                if (!isIncluded) {
                    row.querySelector('input[type="checkbox"]').checked = false;
                }

                container.appendChild(row);
                featureIndex++;
                updateEmptyMessage();
            }

            addBtn.addEventListener('click', function() {
                addFeature();
                // Focus on new input
                const rows = container.querySelectorAll('.feature-row');
                const lastRow = rows[rows.length - 1];
                if (lastRow) {
                    lastRow.querySelector('input[type="text"]').focus();
                }
            });

            container.addEventListener('click', function(e) {
                const removeBtn = e.target.closest('.remove-feature');
                if (removeBtn) {
                    removeBtn.closest('.feature-row').remove();
                    updateEmptyMessage();
                }
            });

            // Load existing features
            @if(old('features'))
                @foreach(old('features') as $i => $feature)
                    addFeature('{{ addslashes($feature["name"] ?? "") }}', {{ isset($feature["is_included"]) && $feature["is_included"] ? 'true' : 'false' }});
                @endforeach
            @else
                @foreach($package->features as $feature)
                    addFeature('{{ addslashes($feature->feature_name) }}', {{ $feature->is_included ? 'true' : 'false' }});
                @endforeach
            @endif

            updateEmptyMessage();
        });
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

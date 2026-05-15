{{-- Shared form partial for create/edit --}}
<div class="space-y-6">
    {{-- Basic Info --}}
    <div class="bg-white/80 backdrop-blur-md dark:bg-slate-800/80 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
            <svg class="w-5 h-5 mr-2 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Informasi Dasar
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Label --}}
            <div>
                <label for="label" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Label <span class="text-red-500">*</span></label>
                <input type="text" id="label" name="label" value="{{ old('label', $serviceType->label ?? '') }}" required
                       class="block w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-200 focus:ring-sky-500 focus:border-sky-500"
                       placeholder="Contoh: LAYANAN 1">
                @error('label') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Sort Order --}}
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Urutan <span class="text-red-500">*</span></label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $serviceType->sort_order ?? 0) }}" required min="0"
                       class="block w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-200 focus:ring-sky-500 focus:border-sky-500"
                       placeholder="0">
                @error('sort_order') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Title --}}
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Layanan <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $serviceType->title ?? '') }}" required
                       class="block w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-200 focus:ring-sky-500 focus:border-sky-500"
                       placeholder="Contoh: Layanan Test Design Factor untuk Penentuan Proses TI yang Diaudit">
                @error('title') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Icon --}}
            <div>
                <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ikon <span class="text-red-500">*</span></label>
                <select id="icon" name="icon" required
                        class="block w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-200 focus:ring-sky-500 focus:border-sky-500">
                    <option value="clipboard" {{ old('icon', $serviceType->icon ?? 'clipboard') == 'clipboard' ? 'selected' : '' }}>📋 Clipboard</option>
                    <option value="chart" {{ old('icon', $serviceType->icon ?? '') == 'chart' ? 'selected' : '' }}>📊 Chart</option>
                    <option value="shield" {{ old('icon', $serviceType->icon ?? '') == 'shield' ? 'selected' : '' }}>🛡️ Shield</option>
                    <option value="document" {{ old('icon', $serviceType->icon ?? '') == 'document' ? 'selected' : '' }}>📄 Document</option>
                    <option value="search" {{ old('icon', $serviceType->icon ?? '') == 'search' ? 'selected' : '' }}>🔍 Search</option>
                    <option value="cog" {{ old('icon', $serviceType->icon ?? '') == 'cog' ? 'selected' : '' }}>⚙️ Settings</option>
                </select>
                @error('icon') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Active --}}
            <div class="flex items-center pt-8">
                <label class="flex items-center cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $serviceType->is_active ?? true) ? 'checked' : '' }}
                           class="w-5 h-5 text-sky-600 bg-gray-100 border-gray-300 rounded focus:ring-sky-500 dark:bg-gray-700 dark:border-gray-600">
                    <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Aktif</span>
                </label>
            </div>

            {{-- Description 1 --}}
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi Utama <span class="text-red-500">*</span></label>
                <textarea id="description" name="description" rows="4" required
                          class="block w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-200 focus:ring-sky-500 focus:border-sky-500"
                          placeholder="Deskripsi utama layanan...">{{ old('description', $serviceType->description ?? '') }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Description 2 --}}
            <div class="md:col-span-2">
                <label for="description2" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi Tambahan (Opsional)</label>
                <textarea id="description2" name="description2" rows="3"
                          class="block w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-200 focus:ring-sky-500 focus:border-sky-500"
                          placeholder="Deskripsi tambahan (opsional)...">{{ old('description2', $serviceType->description2 ?? '') }}</textarea>
                @error('description2') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Closing Note --}}
            <div class="md:col-span-2">
                <label for="closing_note" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Penutup (Opsional)</label>
                <textarea id="closing_note" name="closing_note" rows="2"
                          class="block w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-200 focus:ring-sky-500 focus:border-sky-500"
                          placeholder="Catatan penutup yang akan ditampilkan di bawah daftar fitur...">{{ old('closing_note', $serviceType->closing_note ?? '') }}</textarea>
                @error('closing_note') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Features Section --}}
    <div class="bg-white/80 backdrop-blur-md dark:bg-slate-800/80 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Daftar Fitur Utama
            </h3>
            <button type="button" id="addFeatureBtn"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-sky-600 dark:text-sky-400 bg-sky-50 dark:bg-sky-400/10 rounded-lg hover:bg-sky-100 dark:hover:bg-sky-400/20 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Fitur
            </button>
        </div>

        <div id="featuresContainer" class="space-y-4">
            {{-- Features loaded via JS --}}
        </div>

        <div id="emptyFeaturesMessage" class="text-center py-8 text-gray-400 dark:text-gray-500" style="display:none;">
            <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p>Belum ada fitur. Klik "Tambah Fitur" untuk menambahkan.</p>
        </div>
    </div>

    {{-- Submit --}}
    <div class="flex items-center justify-end gap-4">
        <a href="{{ route('admin.service-types.index') }}"
           class="px-6 py-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-all duration-300">
            Batal
        </a>
        <button type="submit"
                class="px-8 py-3 bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg shadow-sky-500/30 transition-all duration-300 transform hover:scale-105">
            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ $serviceType ? 'Simpan Perubahan' : 'Tambah Layanan' }}
        </button>
    </div>
</div>

{{-- Feature Row Template --}}
<template id="featureTemplate">
    <div class="feature-row p-4 bg-gray-50 dark:bg-slate-900/50 rounded-xl border border-gray-100 dark:border-slate-700 transition-all duration-200 hover:border-sky-300 dark:hover:border-sky-600" data-index="__INDEX__">
        <div class="flex items-start gap-3">
            <div class="cursor-move text-gray-400 dark:text-gray-500 hover:text-gray-600 pt-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
            </div>
            <div class="flex-1 space-y-3">
                <input type="text" name="features[__INDEX__][name]" required
                       class="block w-full px-3 py-2 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-200 text-sm focus:ring-sky-500 focus:border-sky-500"
                       placeholder="Nama fitur (contoh: Self Assessment Design Factor)">
                <textarea name="features[__INDEX__][detail]" rows="2" required
                          class="block w-full px-3 py-2 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-200 text-sm focus:ring-sky-500 focus:border-sky-500"
                          placeholder="Penjelasan fitur..."></textarea>
            </div>
            <button type="button" class="remove-feature p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-400/10 rounded-lg transition-colors pt-3" title="Hapus fitur">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        </div>
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

        function addFeature(name = '', detail = '') {
            const html = template.innerHTML.replace(/__INDEX__/g, featureIndex);
            const div = document.createElement('div');
            div.innerHTML = html;
            const row = div.firstElementChild;

            if (name) row.querySelector('input[type="text"]').value = name;
            if (detail) row.querySelector('textarea').value = detail;

            container.appendChild(row);
            featureIndex++;
            updateEmptyMessage();
        }

        addBtn.addEventListener('click', function() {
            addFeature();
            const rows = container.querySelectorAll('.feature-row');
            const lastRow = rows[rows.length - 1];
            if (lastRow) lastRow.querySelector('input[type="text"]').focus();
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
                addFeature({!! json_encode($feature['name'] ?? '') !!}, {!! json_encode($feature['detail'] ?? '') !!});
            @endforeach
        @elseif($serviceType && $serviceType->features)
            @foreach($serviceType->features as $feature)
                addFeature({!! json_encode($feature['name'] ?? '') !!}, {!! json_encode($feature['detail'] ?? '') !!});
            @endforeach
        @endif

        updateEmptyMessage();
    });
</script>

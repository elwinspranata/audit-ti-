<x-admin-layout>
    <style>
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.5s ease-out forwards; }
        .animation-delay-100 { animation-delay: 0.1s; opacity: 0; }
        
        /* Checkbox card styles */
        .cobit-card {
            transition: all 0.2s ease;
        }
        .cobit-card.selected {
            border-color: #3b82f6 !important;
            background-color: #eff6ff !important;
        }
        .dark .cobit-card.selected {
            background-color: rgba(59, 130, 246, 0.1) !important;
        }
        .cobit-checkbox {
            transition: all 0.2s ease;
        }
        .cobit-checkbox.checked {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
        }
        .cobit-checkbox.checked svg {
            opacity: 1 !important;
        }
    </style>

    <div class="py-8 mx-auto max-w-4xl sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8 animate-fadeInUp">
            <a href="{{ route('admin.assessments.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors mb-4 group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Buat Assessment Baru</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Inisialisasi audit sistem informasi untuk unit kerja.</p>
        </div>

        <div class="p-8 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl shadow-lg animate-fadeInUp animation-delay-100" style="opacity:0;">
            <form action="{{ route('admin.assessments.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    {{-- User Selection --}}
                    <div>
                        <label for="user_id" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Target User <span class="text-red-500">*</span>
                        </label>
                        <select name="user_id" id="user_id" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-all">
                            <option value="" disabled selected>Pilih salah satu user...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Assessment Name --}}
                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Nama Assessment
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all"
                            placeholder="Contoh: Audit TI Triwulan I - 2024">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- COBIT Items Selection --}}
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Pilih Proses TI <span class="text-red-500">*</span>
                            </label>
                            @error('cobit_items')
                                <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($cobitItems as $cobitItem)
                                <label class="relative cursor-pointer group block" onclick="toggleCobitItem(this)">
                                    <input type="checkbox" name="cobit_items[]" value="{{ $cobitItem->id }}"
                                        class="hidden cobit-input"
                                        {{ in_array($cobitItem->id, old('cobit_items', [])) ? 'checked' : '' }}>
                                    <div class="cobit-card h-full p-4 border-2 border-gray-200 dark:border-slate-600 bg-gray-50 dark:bg-slate-900 rounded-xl hover:border-gray-300 dark:hover:border-slate-500 group-hover:shadow-md {{ in_array($cobitItem->id, old('cobit_items', [])) ? 'selected' : '' }}">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 bg-gray-200 dark:bg-slate-700 rounded-lg flex items-center justify-center transition-colors">
                                                    <span class="text-xs font-bold text-gray-600 dark:text-gray-400">{{ substr($cobitItem->nama_item, 0, 2) }}</span>
                                                </div>
                                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $cobitItem->nama_item }}</span>
                                            </div>
                                            {{-- Custom checkbox indicator --}}
                                            <div class="cobit-checkbox w-5 h-5 rounded-md border-2 border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-800 flex items-center justify-center transition-all {{ in_array($cobitItem->id, old('cobit_items', [])) ? 'checked' : '' }}">
                                                <svg class="w-3 h-3 text-white opacity-0 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2">
                                            {{ $cobitItem->deskripsi }}
                                        </p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="pt-6 mt-6 border-t border-gray-200 dark:border-slate-700 flex items-center justify-end gap-4">
                        <button type="reset" class="px-6 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors" onclick="resetCobitItems()">
                            Reset Form
                        </button>
                        <button type="submit" 
                            class="px-8 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 transition-all hover:-translate-y-0.5">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Buat Assessment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleCobitItem(label) {
            const checkbox = label.querySelector('.cobit-input');
            const card = label.querySelector('.cobit-card');
            const checkboxIndicator = label.querySelector('.cobit-checkbox');
            
            // Toggle checkbox state
            checkbox.checked = !checkbox.checked;
            
            // Toggle visual classes
            if (checkbox.checked) {
                card.classList.add('selected');
                checkboxIndicator.classList.add('checked');
            } else {
                card.classList.remove('selected');
                checkboxIndicator.classList.remove('checked');
            }
        }
        
        function resetCobitItems() {
            document.querySelectorAll('.cobit-card').forEach(card => {
                card.classList.remove('selected');
            });
            document.querySelectorAll('.cobit-checkbox').forEach(checkbox => {
                checkbox.classList.remove('checked');
            });
        }
        
        // Initialize on page load for old values
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.cobit-input:checked').forEach(input => {
                const label = input.closest('label');
                const card = label.querySelector('.cobit-card');
                const checkboxIndicator = label.querySelector('.cobit-checkbox');
                card.classList.add('selected');
                checkboxIndicator.classList.add('checked');
            });
        });
    </script>
</x-admin-layout>

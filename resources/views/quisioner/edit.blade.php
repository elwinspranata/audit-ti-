<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ __('Edit Quisioner') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Perbarui pertanyaan quisioner yang sudah ada
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900">
                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="#"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="#"
                                class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Quisioner</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Edit</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Current Question Info -->
            <div
                class="p-6 mb-8 border border-blue-200 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-xl dark:border-gray-600">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-10 h-10 bg-blue-500 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Pertanyaan Saat Ini
                        </h3>
                        <p class="mt-1 text-gray-600 dark:text-gray-300">
                            {{ Str::limit($quisioner->pertanyaan, 150) }}
                        </p>
                        <div class="flex items-center mt-2 space-x-4">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                ID: {{ $quisioner->id }}
                            </span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Level: {{ $quisioner->level->nama_level ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 rounded-2xl">
                <div
                    class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-gray-700 dark:to-gray-600 dark:border-gray-600">
                    <h3 class="flex items-center text-lg font-semibold text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-amber-500">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        Edit Form Quisioner
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Perbarui informasi pertanyaan quisioner di bawah ini
                    </p>
                </div>

                <div class="px-8 py-8">
                    <form action="{{ route('quisioner.update', $quisioner->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Level Field -->
                        <div class="space-y-2">
                            <label for="level_id" class="block text-sm font-semibold text-gray-900 dark:text-gray-100">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Level Quisioner
                                    <span class="ml-1 text-red-500">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <select name="level_id" id="level_id" required
                                    class="block w-full px-4 py-3 transition-all duration-200 border border-gray-300 shadow-sm appearance-none rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:ring-amber-500">
                                    @foreach ($levels as $level)
                                        <option value="{{ $level->id }}"
                                            {{ old('level_id', $quisioner->level_id) == $level->id ? 'selected' : '' }}>
                                            {{ $level->nama_level }} - {{ $level->kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('level_id')
                                <div class="flex items-center mt-2 text-sm text-red-600 dark:text-red-400">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <!-- Pertanyaan Field -->
                        <div class="space-y-2">
                            <label for="pertanyaan"
                                class="block text-sm font-semibold text-gray-900 dark:text-gray-100">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    Pertanyaan
                                    <span class="ml-1 text-red-500">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <textarea name="pertanyaan" id="pertanyaan" rows="5" required
                                    placeholder="Masukkan pertanyaan quisioner yang ingin Anda edit..."
                                    class="block w-full px-4 py-3 placeholder-gray-400 transition-all duration-200 border border-gray-300 shadow-sm resize-none rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:placeholder-gray-400 dark:focus:ring-amber-500">{{ old('pertanyaan', $quisioner->pertanyaan) }}</textarea>
                                <div class="absolute text-xs text-gray-400 bottom-3 right-3">
                                    <span id="charCount">{{ strlen($quisioner->pertanyaan) }}</span> karakter
                                </div>
                            </div>
                            @error('pertanyaan')
                                <div class="flex items-center mt-2 text-sm text-red-600 dark:text-red-400">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>



                        <!-- Change Log -->
                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                            <h4 class="flex items-center mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Informasi Perubahan
                            </h4>
                            <div class="space-y-1 text-xs text-gray-600 dark:text-gray-400">
                                <p>• Terakhir diubah:
                                    {{ $quisioner->updated_at ? $quisioner->updated_at->format('d M Y, H:i') : 'Belum pernah diubah' }}
                                </p>
                                <p>• Dibuat pada:
                                    {{ $quisioner->created_at ? $quisioner->created_at->format('d M Y, H:i') : 'Tidak diketahui' }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div
                            class="flex items-center justify-end pt-6 space-x-4 border-t border-gray-200 dark:border-gray-600">
                            <button type="button" onclick="window.history.back()"
                                class="inline-flex items-center px-6 py-3 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 shadow-sm rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500 dark:focus:ring-offset-gray-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </button>
                            <button type="button" onclick="resetForm()"
                                class="inline-flex items-center px-6 py-3 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 shadow-sm rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500 dark:focus:ring-offset-gray-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Reset
                            </button>
                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white transition-all duration-200 transform border border-transparent rounded-lg shadow-sm bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 dark:focus:ring-offset-gray-800 hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Update Quisioner
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="p-6 mt-8 bg-amber-50 dark:bg-gray-700 rounded-xl">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-amber-800 dark:text-amber-200">
                            Peringatan saat Edit
                        </h3>
                        <div class="mt-2 text-sm text-amber-700 dark:text-amber-300">
                            <ul class="space-y-1 list-disc list-inside">
                                <li>Pastikan perubahan yang Anda buat sudah benar</li>
                                <li>Perhatikan level yang dipilih agar sesuai dengan tingkat kesulitan</li>
                                <li>Gunakan tombol "Reset" untuk mengembalikan ke nilai awal</li>
                                <li>Perubahan akan langsung tersimpan setelah menekan tombol "Update"</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Store original values for reset functionality
        const originalValues = {
            pertanyaan: `{{ $quisioner->pertanyaan }}`,
            level_id: `{{ $quisioner->level_id }}`
        };

        // Character counter for textarea
        document.getElementById('pertanyaan').addEventListener('input', function() {
            const charCount = this.value.length;
            document.getElementById('charCount').textContent = charCount;
        });

        // Reset form function
        function resetForm() {
            if (confirm('Apakah Anda yakin ingin mengembalikan form ke nilai awal?')) {
                document.getElementById('pertanyaan').value = originalValues.pertanyaan;
                document.getElementById('level_id').value = originalValues.level_id;

                // Update character count
                document.getElementById('charCount').textContent = originalValues.pertanyaan.length;
            }
        }

        // Form validation enhancement
        document.querySelector('form').addEventListener('submit', function(e) {
            const pertanyaan = document.getElementById('pertanyaan').value.trim();
            const level = document.getElementById('level_id').value;

            if (!pertanyaan) {
                e.preventDefault();
                alert('Pertanyaan tidak boleh kosong!');
                return;
            }

            if (!level) {
                e.preventDefault();
                alert('Silakan pilih level quisioner!');
                return;
            }

            // Confirm before updating
            if (!confirm('Apakah Anda yakin ingin mengupdate quisioner ini?')) {
                e.preventDefault();
                return;
            }
        });

        // Initialize character count on page load
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('pertanyaan');
            const charCount = textarea.value.length;
            document.getElementById('charCount').textContent = charCount;
        });
    </script>
</x-admin-layout>

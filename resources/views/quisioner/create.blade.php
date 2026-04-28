<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ __('Tambah Quisioner') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Buat pertanyaan baru untuk sistem quisioner
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full dark:bg-blue-900">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
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
                            <span
                                class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Tambah</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Main Form Card -->
            <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 rounded-2xl">
                <div
                    class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 dark:border-gray-600">
                    <h3 class="flex items-center text-lg font-semibold text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-center w-8 h-8 mr-3 bg-blue-500 rounded-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        Form Quisioner Baru
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Lengkapi form di bawah ini untuk membuat pertanyaan quisioner baru
                    </p>
                </div>

                <div class="px-8 py-8">
                    <form action="{{ route('quisioner.store') }}" method="POST" class="space-y-8">
                        @csrf

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
                                    class="block w-full px-4 py-3 transition-all duration-200 border border-gray-300 shadow-sm appearance-none rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:ring-blue-500">
                                    <option value="" disabled selected>Pilih level quisioner...</option>
                                    @foreach ($levels as $level)
                                        <option value="{{ $level->id }}"
                                            {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                            {{ $level->nama_level }} - {{ $level->kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div> --}}
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
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor"
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
                                    placeholder="Masukkan pertanyaan quisioner yang ingin Anda buat..."
                                    class="block w-full px-4 py-3 placeholder-gray-400 transition-all duration-200 border border-gray-300 shadow-sm resize-none rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:placeholder-gray-400 dark:focus:ring-blue-500">{{ old('pertanyaan') }}</textarea>
                                <div class="absolute text-xs text-gray-400 bottom-3 right-3">
                                    <span id="charCount">0</span> karakter
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



                        <!-- Action Buttons -->
                        <div
                            class="flex items-center justify-end pt-6 space-x-4 border-t border-gray-200 dark:border-gray-600">
                            <button type="button" onclick="window.history.back()"
                                class="inline-flex items-center px-6 py-3 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 shadow-sm rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500 dark:focus:ring-offset-gray-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </button>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 text-sm font-medium text-white transition-all duration-200 transform border border-transparent shadow-sm rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Quisioner
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="p-6 mt-8 bg-blue-50 dark:bg-gray-700 rounded-xl">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            Tips Membuat Pertanyaan
                        </h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <ul class="space-y-1 list-disc list-inside">
                                <li>Gunakan bahasa yang jelas dan mudah dipahami</li>
                                <li>Hindari pertanyaan yang terlalu panjang atau rumit</li>
                                <li>Pastikan pertanyaan sesuai dengan level yang dipilih</li>
                                <li>Periksa kembali sebelum menyimpan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Character counter for textarea
        document.getElementById('pertanyaan').addEventListener('input', function() {
            const charCount = this.value.length;
            document.getElementById('charCount').textContent = charCount;
        });

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
        });
    </script>
</x-admin-layout>

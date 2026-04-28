<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold leading-tight text-gray-900 dark:text-gray-100">
                    {{ __('Edit Level') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Perbarui informasi level "<span class="font-medium">{{ $level->nama_level }}</span>"
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('level.show', $level->id) }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    Lihat
                </a>
                <a href="{{ route('level.index') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Current Level Info Card -->
            <div
                class="mb-6 overflow-hidden shadow-sm bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl dark:from-blue-900/20 dark:to-indigo-900/20">
                <div class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg dark:bg-blue-900">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ $level->nama_level }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Level {{ $level->level_number }} -
                                {{ $level->kategori->nama ?? 'Kategori tidak tersedia' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="overflow-hidden bg-white shadow-xl rounded-xl dark:bg-gray-800">
                <div class="px-6 py-8 sm:px-8">
                    <div class="mb-8">
                        <div
                            class="flex items-center justify-center w-16 h-16 mx-auto rounded-full bg-amber-100 dark:bg-amber-900">
                            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-center text-gray-900 dark:text-gray-100">
                            Form Edit Level
                        </h3>
                        <p class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">
                            Ubah informasi level sesuai kebutuhan Anda
                        </p>
                    </div>

                    <form action="{{ route('level.update', $level->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Level Number Field -->
                        <div class="space-y-2">
                            <label for="level_number"
                                class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                                Nomor Level
                                <span class="ml-1 text-red-500">*</span>
                            </label>
                            <input type="number" name="level_number" id="level_number" required min="1"
                                value="{{ old('level_number', $level->level_number) }}"
                                placeholder="Masukkan nomor urutan level (contoh: 1, 2, 3)"
                                class="block w-full px-4 py-3 text-sm placeholder-gray-400 transition-all duration-200 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-blue-400 dark:focus:ring-blue-800" />
                            @error('level_number')
                                <div class="flex items-center mt-2 text-sm text-red-600 dark:text-red-400">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Nomor ini akan menentukan urutan level dalam kategori
                            </p>
                        </div>

                        <!-- Nama Level Field -->
                        <div class="space-y-2">
                            <label for="nama_level"
                                class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                Nama Level
                                <span class="ml-1 text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_level" id="nama_level" required
                                value="{{ old('nama_level', $level->nama_level) }}"
                                placeholder="Masukkan nama level (contoh: Beginner, Intermediate, Advanced)"
                                class="block w-full px-4 py-3 text-sm placeholder-gray-400 transition-all duration-200 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-blue-400 dark:focus:ring-blue-800" />
                            @error('nama_level')
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

                        <!-- Kategori Field -->
                        <div class="space-y-2">
                            <label for="kategori_id"
                                class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                                Kategori
                                <span class="ml-1 text-red-500">*</span>
                            </label>
                            <select name="kategori_id" id="kategori_id" required
                                class="block w-full px-4 py-3 text-sm transition-all duration-200 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-800">
                                <option value="" class="text-gray-400">Pilih kategori untuk level ini</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        {{ old('kategori_id', $level->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
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
                            class="flex flex-col-reverse gap-3 pt-6 border-t border-gray-200 dark:border-gray-700 sm:flex-row sm:justify-end">
                            <a href="{{ route('level.index') }}"
                                class="inline-flex items-center justify-center px-6 py-3 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white transition-all duration-200 transform border border-transparent rounded-lg shadow-sm bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 dark:focus:ring-offset-gray-800 hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Perbarui Level
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Warning Card -->
            <div class="mt-6 overflow-hidden shadow-sm bg-yellow-50 rounded-xl dark:bg-yellow-900/20">
                <div class="px-6 py-4">
                    <div class="flex items-start">
                        <svg class="flex-shrink-0 w-5 h-5 mt-0.5 text-yellow-600 dark:text-yellow-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.99-.833-2.46 0L4.232 15.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                Peringatan
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                <ul class="space-y-1 list-disc list-inside">
                                    <li>Perubahan pada level akan mempengaruhi data terkait</li>
                                    <li>Pastikan nomor level tidak duplikat dalam satu kategori</li>
                                    <li>Periksa kembali semua data sebelum menyimpan perubahan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

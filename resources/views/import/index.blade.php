<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="p-3 shadow-lg rounded-xl bg-gradient-to-br from-blue-500 to-sky-500">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
            <h2
                class="text-2xl font-bold text-transparent bg-gradient-to-r from-blue-600 to-sky-500 bg-clip-text animate-slideInLeft">
                {{ __('Import Data Kuesioner dari Excel') }}
            </h2>
        </div>
    </x-slot>


    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow-lg dark:bg-slate-800/60 rounded-xl dark:border dark:border-sky-700/30">

                @if (session('success'))
                    <div
                        class="p-4 mb-4 text-sm text-green-700 bg-green-100 border border-green-400 rounded-md dark:bg-emerald-600/10 dark:text-emerald-300">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div
                        class="p-4 mb-4 text-sm text-red-700 bg-red-100 border border-red-400 rounded-md dark:bg-red-600/10 dark:text-red-300">
                        <p class="font-bold">Terjadi kesalahan saat impor:</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                {{-- Menampilkan error validasi --}}
                @if ($errors->any())
                    <div
                        class="p-4 mb-4 text-sm text-red-700 bg-red-100 border border-red-400 rounded-md dark:bg-red-600/10 dark:text-red-300">
                        <p class="font-bold">Harap perbaiki error berikut:</p>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form action="{{ route('excel.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Dropdown untuk memilih Kategori --}}
                    <div class="mb-6">
                        <label for="kategori_id"
                            class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Pilih Kategori Tujuan
                        </label>
                        <select name="kategori_id" id="kategori_id" required
                            class="block w-full text-sm border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring focus:ring-blue-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">
                                    {{ $kategori->cobitItem->nama_item }} - {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="file" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Pilih File Excel (.xlsx/.xls)
                        </label>
                        <input type="file" name="file" id="file" required
                            class="block w-full text-sm border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                        @error('file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2 text-sm font-semibold text-white transition-all duration-300 bg-blue-600 rounded-md shadow-md hover:bg-blue-700">
                            Import Sekarang
                        </button>
                    </div>
                </form>

                <div
                    class="pt-6 mt-8 text-sm text-gray-500 border-t border-gray-200 dark:border-gray-700 dark:text-gray-400">
                    <p class="font-semibold">Petunjuk Format File Excel:</p>
                    <ul class="pl-6 mt-2 space-y-1 list-disc">
                        <li>Pastikan file Excel Anda memiliki sheet bernama **Level 1**, **Level 2**, **Level 3**,
                            **Level 4**, dan **Level 5**.</li>
                        <li>Setiap sheet harus memiliki header kolom bernama **pertanyaan**.</li>
                        <li>Setiap baris di bawah header pada masing-masing sheet akan diimpor sebagai kuesioner untuk
                            level yang sesuai dengan nama sheet-nya.</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>

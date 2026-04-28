<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white">
                {{ __('Tambah Kategori') }}
            </h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('kategori.index') }}"
                                class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Kategori</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span
                                class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Tambah</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <style>
        @keyframes slideInFromTop {
            0% {
                opacity: 0;
                transform: translateY(-30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInFromBottom {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .animate-slideInFromTop {
            animation: slideInFromTop 0.6s ease-out forwards;
        }

        .animate-slideInFromBottom {
            animation: slideInFromBottom 0.6s ease-out forwards;
        }

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .custom-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.25em 1.25em;
            padding-right: 2.75rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .custom-select-dark {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2338bdf8' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.25em 1.25em;
            padding-right: 2.75rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .glass-effect {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
    </style>

    <div class="min-h-screen py-8 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-2xl px-4 mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div
                    class="p-4 mb-6 border border-green-200 rounded-lg bg-green-50 dark:bg-green-900/20 dark:border-green-800 animate-slideInFromTop">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm font-medium text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Main Form Card --}}
            <div
                class="bg-white border border-gray-200 shadow-xl dark:bg-gray-800 rounded-2xl dark:shadow-2xl glass-effect dark:border-gray-700 animate-slideInFromBottom">

                {{-- Card Header --}}
                <div class="px-6 py-8 border-b border-gray-200 sm:px-8 dark:border-gray-700">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div
                                class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                Tambah Kategori Baru
                            </h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Isi formulir di bawah untuk menambahkan kategori baru
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Form Body --}}
                <div class="px-6 py-8 sm:px-8">
                    <form action="{{ route('kategori.store') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Nama Kategori Field --}}
                        <div class="space-y-2">
                            <label for="nama" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Nama Kategori
                                    <span class="ml-1 text-red-500">*</span>
                                </span>
                            </label>
                            <input type="text" name="nama" id="nama" required value="{{ old('nama') }}"
                                placeholder="Masukkan nama kategori"
                                class="block w-full px-4 py-3 text-gray-900 placeholder-gray-500 transition-colors duration-200 ease-in-out bg-white border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400" />
                            @error('nama')
                                <div class="flex items-center mt-1 text-sm text-red-600 dark:text-red-400">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Cobit Item Field --}}
                        <div class="space-y-2">
                            <label for="cobit_item_id"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v4a2 2 0 002 2h2m6-6h2a2 2 0 012 2v4a2 2 0 01-2 2h-2m-6-6V9a2 2 0 012-2h4a2 2 0 012 2v2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Cobit Item
                                    <span class="ml-1 text-red-500">*</span>
                                </span>
                            </label>
                            <select name="cobit_item_id" id="cobit_item_id" required
                                class="block w-full px-4 py-3 text-gray-900 transition-colors duration-200 ease-in-out bg-white border border-gray-300 rounded-lg shadow-sm custom-select dark:custom-select-dark dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400">
                                <option value="" disabled {{ old('cobit_item_id') ? '' : 'selected' }}>
                                    Pilih Cobit Item
                                </option>
                                @foreach ($cobitItems as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('cobit_item_id') == $item->id ? 'selected' : '' }}
                                        class="dark:bg-gray-700 dark:text-white">
                                        {{ $item->nama_item }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cobit_item_id')
                                <div class="flex items-center mt-1 text-sm text-red-600 dark:text-red-400">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Form Actions --}}
                        <div
                            class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('kategori.index') }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 ease-in-out bg-white border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 dark:text-gray-300 dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali
                            </a>

                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 text-sm font-medium text-white transition-all duration-200 ease-in-out transform border border-transparent rounded-lg shadow-sm bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover:scale-105 hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

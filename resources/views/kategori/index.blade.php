<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="p-3 shadow-lg rounded-xl bg-gradient-to-r from-blue-600 to-sky-500">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                    </path>
                </svg>
            </div>
            <h2
                class="text-2xl font-bold text-transparent bg-gradient-to-r from-blue-600 to-sky-500 bg-clip-text animate-slideInLeft">
                {{ __('Manajemen Kategori') }}
            </h2>
        </div>
    </x-slot>

    <style>
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slideInLeft {
            animation: slideInLeft 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .animate-slideInRight {
            animation: slideInRight 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .animate-scaleIn {
            animation: scaleIn 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        [x-cloak] {
            display: none !important;
        }

        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .glassmorphism {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .custom-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236366f1' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.25rem 1.25rem;
            padding-right: 3rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dark .hover-lift:hover {
            box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.2), 0 10px 10px -5px rgba(59, 130, 246, 0.1);
        }

        .gradient-border {
            position: relative;
            background: linear-gradient(45deg, #2a78f4, #3b82f6, #06b6d4);
            padding: 2px;
            border-radius: 12px;
        }

        .gradient-border-inner {
            background: white;
            border-radius: 10px;
        }

        .dark .gradient-border-inner {
            background: rgb(30, 41, 59);
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }

        @keyframes pulse-glow {
            from {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
            }

            to {
                box-shadow: 0 0 30px rgba(59, 130, 246, 0.6);
            }
        }
    </style>

    <div
        class="min-h-screen py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-purple-50 dark:from-slate-950 dark:via-slate-900 dark:to-purple-950">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Success Alert -->
            @if (session('success'))
                <div class="p-4 mb-8 border shadow-lg animate-slideInLeft rounded-xl border-emerald-200 bg-gradient-to-r from-emerald-50 to-green-50 dark:border-emerald-700/50 dark:from-emerald-900/20 dark:to-green-900/20"
                    role="alert">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-emerald-800 dark:text-emerald-200">
                                {{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Card -->
            <div class="overflow-hidden shadow-2xl animate-scaleIn glassmorphism rounded-2xl">

                <!-- Header Section -->
                <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-sky-500">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="p-2 rounded-lg bg-white/20 backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Daftar Kategori</h3>
                        </div>

                        <a href="{{ route('kategori.create') }}"
                            class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white transition-all duration-300 ease-in-out transform border-black shadow-lg bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 hover:shadow-xl hover:shadow-sky-500/50 rounded-xl hover:scale-105 group">
                            <svg class="w-5 h-5 mr-2 -ml-1 transition-transform duration-300 group-hover:rotate-180"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Tambah Kategori</span>
                        </a>
                    </div>
                </div>

                <!-- Filter Section -->
                <div
                    class="px-8 py-6 border-b bg-white/50 dark:bg-slate-800/50 border-slate-200/50 dark:border-slate-700/50">
                    <form method="GET" action="{{ route('kategori.index') }}"
                        class="flex flex-col items-start gap-4 sm:flex-row sm:items-center">
                        <label for="cobit_item_id"
                            class="flex items-center space-x-2 text-sm font-semibold text-slate-700 dark:text-slate-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z">
                                </path>
                            </svg>
                            <span>Filter Item:</span>
                        </label>
                        <div class="relative">
                            <select name="cobit_item_id" id="cobit_item_id"
                                class="block w-full px-4 py-3 text-sm transition-all duration-200 border-2 shadow-sm custom-select sm:w-64 bg-white/80 border-slate-200 rounded-xl backdrop-blur-sm dark:bg-slate-700/80 dark:border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent hover:border-blue-300 dark:hover:border-blue-400"
                                onchange="this.form.submit()">
                                <option value="">🏷️ Semua Item</option>
                                @foreach ($cobitItems as $item)
                                    <option value="{{ $item->id }}" @selected($selectedCobitItemId == $item->id)>
                                        {{ $item->nama_item }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                <!-- Table Section -->
                <div class="p-8">
                    <div class="gradient-border hover-lift">
                        <div class="overflow-hidden gradient-border-inner">
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr
                                            class="bg-gradient-to-r from-slate-50 to-blue-50 dark:from-slate-800 dark:to-slate-700">
                                            <th
                                                class="px-6 py-4 text-xs font-bold tracking-wider text-left uppercase border-b-2 border-blue-200 text-slate-600 dark:text-slate-300 dark:border-blue-800">
                                                <div class="flex items-center space-x-2">
                                                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                                    <span>No.</span>
                                                </div>
                                            </th>
                                            <th
                                                class="px-6 py-4 text-xs font-bold tracking-wider text-left uppercase border-b-2 border-blue-200 text-slate-600 dark:text-slate-300 dark:border-blue-800">
                                                <div class="flex items-center space-x-2">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                        </path>
                                                    </svg>
                                                    <span>Nama Kategori</span>
                                                </div>
                                            </th>
                                            <th
                                                class="px-6 py-4 text-xs font-bold tracking-wider text-left uppercase border-b-2 border-blue-200 text-slate-600 dark:text-slate-300 dark:border-blue-800">
                                                <div class="flex items-center space-x-2">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 11H5m14-7H5m14 14H5"></path>
                                                    </svg>
                                                    <span>Cobit Item (Induk)</span>
                                                </div>
                                            </th>
                                            <th
                                                class="px-6 py-4 text-xs font-bold tracking-wider text-left uppercase border-b-2 border-blue-200 text-slate-600 dark:text-slate-300 dark:border-blue-800">
                                                <div class="flex items-center space-x-2">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                        </path>
                                                    </svg>
                                                    <span>Aksi</span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y dark:bg-slate-800 divide-slate-200 dark:divide-slate-700">
                                        @forelse ($kategoris as $kategori)
                                            <tr
                                                class="transition-all duration-200 group hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-slate-700 dark:hover:to-slate-600">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div
                                                        class="flex items-center justify-center w-8 h-8 text-sm font-bold text-white rounded-lg shadow-sm bg-gradient-to-r from-blue-600 to-sky-500">
                                                        {{ ($kategoris->currentPage() - 1) * $kategoris->perPage() + $loop->iteration }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div
                                                            class="flex-shrink-0 w-3 h-3 mr-3 rounded-full bg-gradient-to-r from-blue-400 to-blue-500">
                                                        </div>
                                                        <div
                                                            class="text-sm font-semibold transition-colors text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                                            {{ $kategori->nama }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-800 border border-blue-200 rounded-full bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 dark:text-blue-200 dark:border-blue-700">
                                                        {{ $kategori->cobitItem->nama_item ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                                    <div class="flex items-center space-x-3">
                                                        <a href="{{ route('kategori.edit', $kategori->id) }}"
                                                            class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 transition-all duration-200 transform border border-blue-200 rounded-lg group bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:text-blue-400 dark:bg-blue-900/20 dark:border-blue-700 dark:hover:bg-blue-900/40 hover:scale-105">
                                                            <svg class="w-4 h-4 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                </path>
                                                            </svg>
                                                            Edit
                                                        </a>
                                                        <button type="button" x-data
                                                            @click="$dispatch('open-delete-modal', { action: '{{ route('kategori.destroy', $kategori->id) }}' })"
                                                            class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-red-600 transition-all duration-200 transform border border-red-200 rounded-lg group bg-red-50 hover:bg-red-100 hover:text-red-700 dark:text-red-400 dark:bg-red-900/20 dark:border-red-700 dark:hover:bg-red-900/40 hover:scale-105">
                                                            <svg class="w-4 h-4 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-16 text-center">
                                                    <div class="flex flex-col items-center justify-center space-y-4">
                                                        <div
                                                            class="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-slate-200 to-slate-300 dark:from-slate-600 dark:to-slate-700">
                                                            <svg class="w-8 h-8 text-slate-400 dark:text-slate-500"
                                                                fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                        <div class="text-center">
                                                            <h3
                                                                class="mb-2 text-lg font-medium text-slate-900 dark:text-slate-100">
                                                                Tidak ada data kategori</h3>
                                                            <p class="text-sm text-slate-500 dark:text-slate-400">Belum
                                                                ada kategori yang cocok dengan filter yang dipilih.</p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if ($kategoris->hasPages())
                        <div class="p-4 mt-8 bg-white/50 dark:bg-slate-800/50 rounded-xl backdrop-blur-sm">
                            {{ $kategoris->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Delete Modal -->
    <div x-data="{ show: false, action: '' }" @open-delete-modal.window="show = true; action = $event.detail.action"
        x-show="show" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm">
        <div @click.away="show = false" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-1 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-1 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="relative w-full max-w-md mx-4 overflow-hidden bg-white shadow-2xl dark:bg-slate-800 rounded-2xl">

            <!-- Header with gradient -->
            <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-pink-500">
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-full bg-white/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.996-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Konfirmasi Hapus</h3>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="flex items-start space-x-4">
                    <div
                        class="flex items-center justify-center flex-shrink-0 w-12 h-12 bg-red-100 rounded-full dark:bg-red-900/30">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="mb-2 text-sm text-slate-600 dark:text-slate-300">
                            Apakah Anda yakin ingin menghapus kategori ini?
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="px-6 py-4 bg-slate-50 dark:bg-slate-700/50">
                <form :action="action" method="POST" class="flex justify-end space-x-3">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="show = false"
                        class="px-4 py-2 text-sm font-medium transition-colors duration-200 bg-white border rounded-lg shadow-sm text-slate-700 border-slate-300 hover:bg-slate-50 dark:text-slate-300 dark:bg-slate-600 dark:border-slate-500 dark:hover:bg-slate-500">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white transition-all duration-200 transform rounded-lg shadow-lg bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 hover:scale-105">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>

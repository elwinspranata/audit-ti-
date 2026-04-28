<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="p-3 shadow-lg rounded-xl bg-gradient-to-r from-blue-600 to-sky-500">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
            <h2
                class="text-2xl font-bold text-transparent bg-gradient-to-r from-blue-600 to-sky-500 bg-clip-text animate-slideInLeft">
                {{ __('Manajemen COBIT Item') }}
            </h2>

            {{-- <div class="items-center hidden text-sm text-gray-500 md:flex dark:text-gray-400">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                Dashboard / COBIT Items
            </div> --}}
        </div>
    </x-slot>

    <style>
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px)
            }

            to {
                opacity: 1;
                transform: translateX(0)
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .7;
            }
        }

        .animate-fadeInDown {
            animation: fadeInDown .6s ease-out forwards
        }

        .animate-fadeInUp {
            animation: fadeInUp .6s ease-out forwards
        }

        .animate-slideIn {
            animation: slideIn .5s ease-out forwards
        }

        .animate-pulse-slow {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        [x-cloak] {
            display: none !important;
        }

        .glass-effect {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dark .hover-lift:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }

        .gradient-border {
            background: linear-gradient(45deg, #3b82f6, #06b6d4, #10b981);
            padding: 1px;
            border-radius: 0.75rem;
        }

        .gradient-border>div {
            background: white;
            border-radius: calc(0.75rem - 1px);
        }

        .dark .gradient-border>div {
            background: rgb(30 41 59);
        }
    </style>

    <div
        class="min-h-screen py-8 bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 dark:from-slate-950 dark:via-slate-900 dark:to-indigo-950">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Success Alert -->
            @if (session('success'))
                <div class="mb-8 animate-slideIn">
                    <div
                        class="relative p-4 overflow-hidden rounded-lg shadow-lg bg-gradient-to-r from-green-500 to-emerald-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-white">{{ session('success') }}</p>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-white opacity-10 animate-pulse-slow"></div>
                    </div>
                </div>
            @endif

            <!-- Main Content Card -->
            <div class="gradient-border hover-lift animate-fadeInUp">
                <div class="bg-white dark:bg-slate-800 glass-effect">

                    <!-- Header Section -->
                    <div class="px-6 py-8 border-b border-gray-200 dark:border-slate-700">
                        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                            <!-- Title and Stats -->
                            <div class="flex-1">
                                <div class="flex items-center gap-4 mb-2">
                                    <div class="p-3 shadow-lg bg-gradient-to-r from-sky-500 to-blue-600 rounded-xl">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">COBIT Items</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Kelola dan pantau semua item
                                            COBIT</p>
                                    </div>
                                </div>

                                <!-- Quick Stats -->
                                <div class="flex gap-4 mt-4">
                                    <div class="px-3 py-1 bg-blue-100 rounded-full dark:bg-blue-900/30">
                                        <span class="text-xs font-medium text-blue-800 dark:text-blue-200">
                                            Total: {{ $cobitItems->total() }} items
                                        </span>
                                    </div>
                                    <div class="px-3 py-1 bg-green-100 rounded-full dark:bg-green-900/30">
                                        <span class="text-xs font-medium text-green-800 dark:text-green-200">
                                            Visible: {{ $cobitItems->where('is_visible', true)->count() }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col gap-3 sm:flex-row">
                                <a href="{{ route('cobititem.create') }}"
                                    class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white transition-all duration-300 ease-in-out transform rounded-lg shadow-lg bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 hover:shadow-xl hover:shadow-sky-500/50 rounded-xl hover:scale-105 group">
                                    <svg class="w-5 h-5 mr-2 -ml-1 transition-transform duration-300 group-hover:rotate-180"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Tambah Item Baru
                                    <div
                                        class="absolute inset-0 transition-opacity bg-white opacity-0 group-hover:opacity-10 rounded-xl">
                                    </div>
                                </a>

                                {{-- <button
                                    class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-gray-700 transition-all duration-200 bg-white border border-gray-300 shadow-sm rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-gray-200 dark:border-slate-600 dark:hover:bg-slate-600">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Export Data
                                </button> --}}
                            </div>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-slate-800/50">
                        <form method="GET" action="{{ route('cobititem.index') }}"
                            class="flex flex-col items-start gap-4 sm:flex-row sm:items-center">

                            <!-- Filter by Visibility -->
                            <div class="flex items-center gap-3">
                                <label for="filter_select"
                                    class="text-sm font-semibold text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z" />
                                    </svg>
                                    Filter Status:
                                </label>

                                <select name="is_visible" id="filter_select" onchange="this.form.submit()"
                                    class="block px-4 py-2 pr-8 text-sm transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:border-slate-600 dark:text-gray-200 dark:focus:ring-blue-400">
                                    <option value="">
                                        📋 Semua Item
                                    </option>
                                    <option value="true" {{ request('is_visible') === 'true' ? 'selected' : '' }}>
                                        ✅ Item Visible
                                    </option>
                                    <option value="false" {{ request('is_visible') === 'false' ? 'selected' : '' }}>
                                        ❌ Item Tersembunyi
                                    </option>
                                </select>
                            </div>

                            <!-- Search Input -->
                            <div class="flex-1 max-w-md">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Cari nama item atau deskripsi..."
                                        class="block w-full py-2 pl-10 pr-3 leading-5 placeholder-gray-500 transition-all duration-200 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-400">
                                </div>
                            </div>

                            <!-- Search and Clear Buttons -->
                            <div class="flex gap-2">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all duration-200 bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Cari
                                </button>

                                @if (request('search') || request('is_visible'))
                                    <a href="{{ route('cobititem.index') }}"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:bg-slate-700 dark:text-gray-200 dark:border-slate-600 dark:hover:bg-slate-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Table Section -->
                    <div class="overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                                <thead class="bg-gray-50 dark:bg-slate-800">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase dark:text-gray-300">
                                            <div class="flex items-center gap-2">
                                                #
                                                <svg class="w-3 h-3 opacity-50" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3z" />
                                                </svg>
                                            </div>
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase dark:text-gray-300">
                                            Nama Item
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase dark:text-gray-300">
                                            Deskripsi
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase dark:text-gray-300">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase dark:text-gray-300">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200 dark:bg-slate-800 dark:divide-slate-700">
                                    @forelse ($cobitItems as $item)
                                        <tr
                                            class="transition-colors duration-200 group hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                            <td
                                                class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                <div class="flex items-center">
                                                    <span
                                                        class="inline-flex items-center justify-center w-8 h-8 text-xs font-medium bg-gray-100 rounded-full dark:bg-slate-700">
                                                        {{ ($cobitItems->currentPage() - 1) * $cobitItems->perPage() + $loop->iteration }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 w-10 h-10">
                                                        <div
                                                            class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-r from-sky-500 to-blue-600">
                                                            <svg class="w-5 h-5 text-white" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div
                                                            class="text-sm font-semibold text-gray-900 dark:text-white">
                                                            {{ $item->nama_item }}
                                                        </div>
                                                        {{-- <div class="text-xs text-gray-500 dark:text-gray-400">
                                                            ID: {{ $item->id }}
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td x-data="{ expanded: false }" class="px-6 py-4">
                                                <div class="max-w-xs">
                                                    <p class="text-sm text-gray-700 dark:text-gray-300"
                                                        :class="!expanded && 'line-clamp-2'">
                                                        {{ $item->deskripsi }}
                                                    </p>

                                                    @if (strlen($item->deskripsi) > 100)
                                                        <button @click="expanded = !expanded"
                                                            class="mt-1 text-xs font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">
                                                            <span
                                                                x-text="expanded ? 'Sembunyikan' : 'Lihat selengkapnya...'"></span>
                                                        </button>
                                                    @endif

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($item->is_visible)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-green-800 bg-green-100 border border-green-200 rounded-full dark:bg-green-900/30 dark:text-green-300 dark:border-green-800">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Visible
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-gray-800 bg-gray-100 border border-gray-200 rounded-full dark:bg-gray-800/50 dark:text-gray-300 dark:border-gray-700">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM4 10a6 6 0 1012 0A6 6 0 004 10z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Hidden
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                                <div class="flex items-center justify-center space-x-3">
                                                    <a href="{{ route('cobititem.edit', $item->id) }}"
                                                        class="relative inline-flex items-center justify-center w-8 h-8 text-blue-600 transition-colors duration-200 group hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        <span class="sr-only">Edit</span>
                                                    </a>

                                                    <button type="button" x-data
                                                        @click="$dispatch('open-delete-modal', { action: '{{ route('cobititem.destroy', $item->id) }}', name: '{{ $item->nama_item }}' })"
                                                        class="relative inline-flex items-center justify-center w-8 h-8 text-red-600 transition-colors duration-200 group hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        <span class="sr-only">Hapus</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-16 text-center">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-16 h-16 mb-4 text-gray-400 dark:text-gray-600"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">
                                                        Tidak ada COBIT Item</h3>
                                                    <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">Mulai
                                                        dengan menambahkan item COBIT pertama Anda.</p>
                                                    <a href="{{ route('cobititem.create') }}"
                                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                        <svg class="w-4 h-4 mr-2" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Tambah Item Pertama
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Paginasi Links --}}
                    @if ($cobitItems->hasPages())
                        <div class="py-3 mt-0 bg-transparent mx-7 dark:bg-transparent sm:px-0 rounded-b-xl">
                            {{ $cobitItems->appends(request()->query())->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Delete Confirmation Modal -->
    <div x-data="{ show: false, action: '', itemName: '' }"
        @open-delete-modal.window="show = true; action = $event.detail.action; itemName = $event.detail.name"
        x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-900/80 backdrop-blur-sm" @click="show = false"></div>

            <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl dark:bg-slate-800 rounded-2xl"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-full dark:bg-red-900/30">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Konfirmasi Penghapusan</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tindakan ini tidak dapat dibatalkan</p>
                        </div>
                    </div>
                    <button @click="show = false"
                        class="text-gray-400 transition-colors hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="mb-6">
                    <p class="mb-3 text-sm text-gray-600 dark:text-gray-300">
                        Apakah Anda yakin ingin menghapus item berikut?
                    </p>
                    <div
                        class="p-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-slate-700/50 dark:border-slate-600">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="font-medium text-gray-900 dark:text-white" x-text="itemName"></span>
                        </div>
                    </div>
                    <p class="flex items-center mt-2 text-xs text-red-600 dark:text-red-400">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Data yang dihapus tidak dapat dikembalikan
                    </p>
                </div>

                <!-- Modal Actions -->
                <div class="flex flex-col gap-3 sm:flex-row sm:gap-4">
                    <button type="button" @click="show = false"
                        class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:bg-slate-700 dark:text-gray-200 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-400 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </button>

                    <form :action="action" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-red-600 to-red-700 rounded-lg shadow-lg hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Ya, Hapus Item
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

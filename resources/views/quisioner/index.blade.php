<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="p-3 shadow-lg rounded-xl bg-gradient-to-br from-blue-500 to-sky-500">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
            <h2
                class="text-2xl font-bold text-transparent bg-gradient-to-r from-blue-600 to-sky-500 bg-clip-text animate-slideInLeft">
                {{ __('Manajemen Questionaire') }}
            </h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        @keyframes slideInFromTop {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInFromBottom {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
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

        .animate-slideInFromTop {
            animation: slideInFromTop 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .animate-slideInFromBottom {
            animation: slideInFromBottom 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .animate-scaleIn {
            animation: scaleIn 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .glass-morphism {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-morphism-light {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dark .glass-morphism-light {
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #3b82f6, #06b6d4 100%);
        }

        .dark .gradient-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dark .card-hover:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 107, 107, 0.4);
        }

        .table-row-hover {
            transition: all 0.2s ease;
        }

        .table-row-hover:hover {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            transform: scale(1.01);
        }

        .dark .table-row-hover:hover {
            background: linear-gradient(90deg, rgba(14, 165, 233, 0.1) 0%, rgba(168, 85, 247, 0.1) 100%);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #068fb5);
            border-radius: 10px;
        }

        .floating-label {
            position: relative;
        }

        .floating-label select {
            padding-top: 1.5rem;
            padding-bottom: 0.5rem;
        }

        .floating-label label {
            position: absolute;
            left: 1rem;
            top: 1rem;
            background: transparent;
            transition: all 0.2s ease;
            pointer-events: none;
            color: #9ca3af;
        }

        .floating-label select:focus+label,
        .floating-label select:not(:placeholder-shown)+label {
            top: 0.25rem;
            font-size: 0.75rem;
            color: #667eea;
        }

        .dark .floating-label label {
            color: #64748b;
        }

        .dark .floating-label select:focus+label,
        .dark .floating-label select:not(:placeholder-shown)+label {
            color: #0ea5e9;
        }

        [x-cloak] {
            display: none !important;
        }

        .custom-select-dark {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2360a5fa' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right .5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 border rounded-lg dark:bg-green-700/20 dark:text-green-300 border-green-600/30 animate-slideInFromTop"
                    role="alert">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.parentElement.style.display='none'"
                            class="text-green-500 hover:text-green-700 dark:text-green-300 dark:hover:text-green-100">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <div
                class="p-6 bg-white shadow-xl glass-morphism-light dark:glass-morphism sm:p-8 dark:bg-slate-800/70 dark:backdrop-blur-md dark:shadow-blue-950/40 sm:rounded-3xl dark:border dark:border-blue-700/30 animate-slideInFromBottom card-hover">

                <!-- Header Actions -->
                <div class="flex flex-col items-start justify-between gap-4 mb-8 sm:flex-row sm:items-center">
                    <div>
                        <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-sky-300">
                            <svg class="inline w-6 h-6 mr-2 text-blue-600 dark:text-sky-400" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd"
                                    d="M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm2.5 4a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm6 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Daftar Pertanyaan
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">Kelola semua pertanyaan kuesioner Anda dengan
                            mudah
                        </p>
                    </div>

                    <a href="{{ route('quisioner.create') }}"
                        class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white transition-all duration-300 ease-in-out transform shadow-lg bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 hover:shadow-xl hover:shadow-sky-500/50 rounded-xl hover:scale-105 group">
                        <svg class="w-5 h-5 mr-2 -ml-1 transition-transform duration-300 group-hover:rotate-180"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Tambah Pertanyaan
                    </a>
                </div>

                {{-- Filter Section --}}
                <div
                    class="p-6 mb-8 bg-gradient-to-r from-blue-50 to-blue-50 dark:from-slate-800/50 dark:to-slate-700/50 rounded-2xl animate-fadeIn">
                    <form method="GET" action="{{ route('quisioner.index') }}"
                        class="flex flex-col items-start gap-4 sm:flex-row sm:items-center">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-600 dark:text-sky-400" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <label for="level_id" class="text-sm font-semibold text-gray-700 dark:text-sky-200">Filter
                                Level:</label>
                        </div>

                        <div class="flex-1 min-w-32">
                            <select name="level_id" id="level_id"
                                class="block w-full px-4 py-3 text-sm transition-all duration-300 bg-white border-2 border-gray-200 shadow-sm rounded-xl custom-select-dark dark:bg-slate-700/80 dark:border-slate-600 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:focus:border-sky-400"
                                onchange="this.form.submit()">
                                <option value="">Semua Level</option>
                                @foreach ($levelsForFilter as $level)
                                    <option value="{{ $level->id }}" @selected($selectedLevelId == $level->id)>
                                        {{ $level->kategori->nama ?? '' }} - {{ $level->nama_level }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <button type="submit"
                            class="flex items-center gap-2 px-6 py-3 font-semibold text-white shadow-lg btn-primary rounded-xl">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Filter
                        </button> --}}
                    </form>
                </div>

                {{-- Table Section --}}
                <div class="overflow-hidden bg-white shadow-xl dark:bg-slate-800 rounded-2xl animate-fadeIn">
                    <!-- Table Header -->
                    <div class="px-6 py-4 text-white gradient-bg ">
                        <div class="grid items-center grid-cols-12 gap-4 font-semibold">
                            <div class="col-span-1 text-center">
                                <svg class="w-4 h-4 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="col-span-6 sm:col-span-5">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Pertanyaan
                                </div>
                            </div>
                            <div class="hidden col-span-3 sm:block">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                        </path>
                                    </svg>
                                    Level (Induk)
                                </div>
                            </div>
                            <div class="col-span-5 text-center sm:col-span-3">
                                <div class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Aksi
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table Body -->
                    <div class="overflow-y-auto custom-scrollbar max-h-96">
                        @forelse ($quisioners as $quisioner)
                            <div class="px-6 py-4 border-b border-gray-100 table-row-hover dark:border-slate-700">
                                <div class="grid items-center grid-cols-12 gap-4">
                                    <div class="col-span-1 text-center">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 text-sm font-semibold text-blue-600 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-400">
                                            {{ ($quisioners->currentPage() - 1) * $quisioners->perPage() + $loop->iteration }}
                                        </span>
                                    </div>
                                    <div class="col-span-6 sm:col-span-5">
                                        <p class="mb-1 font-semibold text-gray-800 dark:text-sky-100">
                                            {{ $quisioner->pertanyaan }}</p>
                                        <span
                                            class="px-2 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-400">
                                            ID: {{ $quisioner->id }}
                                        </span>
                                    </div>
                                    <div class="hidden col-span-3 sm:block">
                                        <div class="flex items-center gap-2">
                                            <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                            <span
                                                class="text-sm text-gray-600 dark:text-gray-300">{{ $quisioner->level->nama_level ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-span-5 sm:col-span-3">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('quisioner.edit', $quisioner->id) }}"
                                                class="p-2 text-blue-600 transition-colors duration-200 bg-blue-100 rounded-lg dark:bg-blue-900/30 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-800/40 group">
                                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:scale-110"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <button type="button" x-data
                                                @click="$dispatch('open-delete-modal', { action: '{{ route('quisioner.destroy', $quisioner->id) }}' })"
                                                class="p-2 text-red-600 transition-colors duration-200 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-800/40 group">
                                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:scale-110"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Mobile Level Info -->
                                <div class="mt-2 ml-12 sm:hidden">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                        <span
                                            class="text-xs text-gray-600 dark:text-gray-400">{{ $quisioner->level->nama_level ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <div class="max-w-sm mx-auto">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 11-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 111.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 111.414-1.414L15.586 13H14a1 1 0 01-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <h3 class="mb-2 text-lg font-semibold text-gray-600 dark:text-gray-400">Belum
                                        Ada
                                        Data</h3>
                                    <p class="mb-6 text-gray-500 dark:text-gray-500">Belum ada pertanyaan yang
                                        ditambahkan. Mulai dengan menambahkan pertanyaan pertama Anda.</p>
                                    <a href="{{ route('quisioner.create') }}"
                                        class="inline-flex items-center gap-2 px-6 py-3 font-semibold text-white shadow-lg btn-primary rounded-xl">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Tambah Pertanyaan
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="flex flex-col items-center justify-between gap-4 mt-8 sm:flex-row">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Menampilkan {{ $quisioners->count() }} dari {{ $quisioners->total() }} pertanyaan
                    </div>

                    <div class="flex items-center gap-2">
                        {{ $quisioners->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    {{-- <div x-data="{ show: false, action: '' }" @open-delete-modal.window="show = true; action = $event.detail.action" x-show="show"
        x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm">

        <div @click.away="show = false" x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-1 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-1 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="w-full max-w-md p-8 mx-4 bg-white shadow-2xl dark:bg-gradient-to-br dark:from-slate-800 dark:to-slate-900 rounded-3xl dark:border dark:border-sky-700/50 animate-scaleIn">

            <div class="mb-6 text-center">
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full dark:bg-red-900/30">
                    <svg class="w-8 --}}

    {{-- Modal Konfirmasi Hapus --}}
    <div x-data="{ show: false, action: '' }" @open-delete-modal.window="show = true; action = $event.detail.action"
        x-show="show" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm">
        <div @click.away="show = false"
            class="w-full max-w-md p-6 mx-4 bg-white shadow-2xl dark:bg-gradient-to-br dark:from-slate-800 dark:to-slate-900 rounded-xl dark:border dark:border-sky-700/50">
            <h3 class="mb-2 text-xl font-bold text-gray-800 dark:text-sky-300">Konfirmasi Hapus</h3>
            <p class="mb-6 text-sm text-gray-600 dark:text-gray-300">Apakah Anda yakin ingin menghapus item ini?
                Tindakan ini tidak dapat dibatalkan.</p>
            <form :action="action" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-4">
                    <button type="button" @click="show = false"
                        class="px-5 py-2 text-sm font-medium text-gray-800 bg-gray-200 rounded-lg shadow-sm dark:text-gray-200 dark:bg-slate-600 hover:bg-gray-300 dark:hover:bg-slate-500">Batal</button>
                    <button type="submit"
                        class="px-5 py-2 text-sm font-medium text-white bg-red-600 rounded-lg shadow-lg hover:bg-red-700">Ya,
                        Hapus</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

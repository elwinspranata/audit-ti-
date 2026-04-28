<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="p-3 shadow-lg rounded-xl bg-gradient-to-br from-blue-500 to-sky-500">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                    </path>
                </svg>
            </div>
            <h2
                class="text-2xl font-bold text-transparent bg-gradient-to-r from-blue-600 to-sky-500 bg-clip-text animate-slideInLeft">
                {{ __('Manajemen Users') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl rounded-2xl dark:bg-slate-800">

                {{-- Header Section --}}
                <div
                    class="px-6 py-6 border-b border-gray-200 dark:border-slate-700 bg-gradient-to-r from-sky-50 to-blue-50 dark:from-slate-800 dark:to-slate-700">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <div
                                class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-sky-500 to-blue-600 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-sky-300">Daftar User</h3>
                                <p class="text-sm text-gray-600 dark:text-slate-400">Kelola akun pengguna aplikasi
                                    dengan mudah</p>
                            </div>
                        </div>

                        {{-- <a href="{{ route('users.create') }}"
                            class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white transition-all duration-300 ease-in-out transform shadow-lg rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 hover:shadow-xl hover:shadow-sky-500/30 hover:scale-105 group">
                            <svg class="w-5 h-5 mr-2 -ml-1 transition-transform duration-300 group-hover:rotate-180"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Tambah User
                        </a> --}}
                    </div>
                </div>

                {{-- Stats Cards --}}
                <div class="px-6 py-4 bg-gray-50 dark:bg-slate-700/50">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div
                            class="flex items-center p-4 bg-white border border-gray-100 shadow-sm rounded-xl dark:bg-slate-800 dark:border-slate-600">
                            <div
                                class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg dark:bg-blue-900/30">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-slate-400">Total Users</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $users->total() }}</p>
                            </div>
                        </div>
                        <div
                            class="flex items-center p-4 bg-white border border-gray-100 shadow-sm rounded-xl dark:bg-slate-800 dark:border-slate-600">
                            <div
                                class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg dark:bg-green-900/30">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-slate-400">Halaman Saat Ini</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $users->currentPage() }}
                                </p>
                            </div>
                        </div>
                        <div
                            class="flex items-center p-4 bg-white border border-gray-100 shadow-sm rounded-xl dark:bg-slate-800 dark:border-slate-600">
                            <div
                                class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg dark:bg-purple-900/30">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-slate-400">Per Halaman</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $users->perPage() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Filter & Search Section --}}
                <div class="px-6 py-6 border-b border-gray-200 dark:border-slate-700">
                    <form method="GET" action="{{ route('users.index') }}" class="space-y-4 sm:space-y-0">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                            <!-- Search Input -->
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="search" placeholder="Cari nama atau email…"
                                    value="{{ request('search') }}"
                                    class="w-full py-3 pl-10 pr-4 transition-all duration-200 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:placeholder-slate-400" />
                            </div>

                            <!-- Role Filter -->
                            <div class="relative">
                                <select name="role"
                                    class="appearance-none py-3 pl-4 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white bg-white min-w-[140px] transition-all duration-200"
                                    onchange="this.form.submit()">
                                    <option value="">Semua Role</option>
                                    <option value="admin" @selected(request('role') == 'admin')>Admin</option>
                                    <option value="user" @selected(request('role') == 'user')>User</option>
                                </select>
                                {{-- <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div> --}}
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-3 text-sm font-medium text-white transition-all duration-200 bg-sky-600 rounded-xl hover:bg-sky-700 focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Cari
                                </button>
                                <a href="{{ route('users.index') }}"
                                    class="inline-flex items-center px-4 py-3 text-sm font-medium text-gray-700 transition-all duration-200 bg-gray-100 rounded-xl hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-slate-600 dark:text-slate-200 dark:hover:bg-slate-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Table Section --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase dark:text-slate-300">
                                    <div class="flex items-center gap-2">
                                        <span>No.</span>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase dark:text-slate-300">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span>Nama</span>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase dark:text-slate-300">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span>Email</span>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase dark:text-slate-300">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                        <span>Role</span>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase dark:text-slate-300">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                            </path>
                                        </svg>
                                        <span>Aksi</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-slate-800 dark:divide-slate-700">
                            @forelse($users as $u)
                                <tr class="transition-colors duration-200 hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                    <td
                                        class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div
                                            class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full dark:bg-slate-700">
                                            {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-10 h-10">
                                                <div
                                                    class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-sky-400 to-blue-500">
                                                    <span
                                                        class="text-sm font-semibold text-white">{{ strtoupper(substr($u->name, 0, 1)) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $u->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-slate-300">
                                        {{ $u->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($u->role === 'admin')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                    </path>
                                                </svg>
                                                {{ ucfirst($u->role) }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                                {{ ucfirst($u->role) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('users.edit', $u) }}"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-sky-700 bg-sky-100 rounded-lg hover:bg-sky-200 focus:ring-2 focus:ring-sky-500 focus:ring-offset-1 dark:bg-sky-900/30 dark:text-sky-300 dark:hover:bg-sky-800/50 transition-all duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('users.destroy', $u) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200 focus:ring-2 focus:ring-red-500 focus:ring-offset-1 dark:bg-red-900/30 dark:text-red-300 dark:hover:bg-red-800/50 transition-all duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 mb-4 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                            <p class="mb-2 text-lg font-medium text-gray-900 dark:text-white">Tidak ada
                                                user ditemukan</p>
                                            <p class="text-sm text-gray-500 dark:text-slate-400">Coba ubah filter
                                                pencarian atau tambah user baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($users->hasPages())
                    <div
                        class="px-6 py-4 border-t border-gray-200 bg-gray-50 dark:bg-slate-700/50 dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <div class="flex justify-between flex-1 sm:hidden">
                                @if ($users->onFirstPage())
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 rounded-md cursor-default">
                                        « Previous
                                    </span>
                                @else
                                    <a href="{{ $users->previousPageUrl() }}"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700">
                                        « Previous
                                    </a>
                                @endif

                                @if ($users->hasMorePages())
                                    <a href="{{ $users->nextPageUrl() }}"
                                        class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700">
                                        Next »
                                    </a>
                                @else
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 rounded-md cursor-default">
                                        Next »
                                    </span>
                                @endif
                            </div>

                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700 dark:text-slate-300">
                                        Menampilkan
                                        <span class="font-medium">{{ $users->firstItem() ?? 0 }}</span>
                                        sampai
                                        <span class="font-medium">{{ $users->lastItem() ?? 0 }}</span>
                                        dari
                                        <span class="font-medium">{{ $users->total() }}</span>
                                        hasil
                                    </p>
                                </div>
                                <div>
                                    {{ $users->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-admin-layout>

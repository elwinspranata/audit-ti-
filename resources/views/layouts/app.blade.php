    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow dark:bg-gray-800">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <footer class="border-t bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700">
                <div class="w-full max-w-screen-xl p-4 py-6 mx-auto lg:py-8">
                    <div class="md:flex md:justify-between">
                        {{-- Bagian Kiri: Nama Sistem & Deskripsi --}}
                        <div class="pr-8 mb-6 md:mb-0 md:w-1/3">
                            <a href="#" class="flex items-center">
                                {{-- Ganti dengan logo sistem Anda jika ada --}}
                                <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                                <span
                                    class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">AuditSys</span>
                            </a>
                            <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">
                                Sistem terintegrasi untuk memastikan keamanan, kepatuhan, dan efisiensi infrastruktur TI
                                Anda.
                            </p>
                        </div>

                        {{-- Bagian Kanan: Grid untuk Tautan --}}
                        {{-- <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                            <div>
                                <h2 class="mb-6 text-sm font-semibold uppercase text-slate-900 dark:text-white">Navigasi
                                </h2>
                                <ul class="space-y-4 font-medium text-slate-500 dark:text-slate-400">
                                    <li><a href="#" class="hover:underline">Dashboard</a></li>
                                    <li><a href="#" class="hover:underline">Laporan Audit</a></li>
                                    <li><a href="#" class="hover:underline">Manajemen Aset</a></li>
                                    <li><a href="#" class="hover:underline">Jadwal Audit</a></li>
                                </ul>
                            </div>
                            <div>
                                <h2 class="mb-6 text-sm font-semibold uppercase text-slate-900 dark:text-white">Sumber
                                    Daya</h2>
                                <ul class="space-y-4 font-medium text-slate-500 dark:text-slate-400">
                                    <li><a href="#" class="hover:underline">Kebijakan Keamanan</a></li>
                                    <li><a href="#" class="hover:underline">Standar Kepatuhan</a></li>
                                    <li><a href="#" class="hover:underline">Dokumentasi API</a></li>
                                </ul>
                            </div>
                            <div>
                                <h2 class="mb-6 text-sm font-semibold uppercase text-slate-900 dark:text-white">Dukungan
                                </h2>
                                <ul class="space-y-4 font-medium text-slate-500 dark:text-slate-400">
                                    <li><a href="#" class="hover:underline">Hubungi Tim Audit</a></li>
                                    <li><a href="#" class="hover:underline">Laporkan Insiden</a></li>
                                    <li><a href="#" class="hover:underline">Status Sistem</a></li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}

                    <hr class="my-6 border-slate-200 sm:mx-auto dark:border-slate-700 lg:my-8" />

                    {{-- Copyright & Info Tambahan --}}
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <span class="text-sm text-slate-500 sm:text-center dark:text-slate-400">© {{ date('Y') }} <a
                                href="#" class="hover:underline">AuditSys™</a>. All Rights Reserved.
                        </span>
                        <div class="flex mt-4 space-x-5 sm:justify-center sm:mt-0">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Versi Aplikasi: 1.2.0</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        @stack('scripts')
    </body>

    </html>

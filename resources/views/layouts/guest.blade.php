<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Audit TI') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900">
    {{-- [PERBAIKAN] Latar belakang dengan gradien halus --}}
    <div
        class="flex flex-col items-center min-h-screen pt-6 sm:justify-center sm:pt-0 bg-gradient-to-br from-gray-50 to-gray-200 dark:from-slate-900 dark:to-slate-950">

        {{-- [PERBAIKAN] Kartu utama dengan efek modern --}}
        <div
            class="w-full p-8 transition-all duration-300 shadow-2xl sm:max-w-md bg-white/80 backdrop-blur-sm dark:bg-slate-800/80 dark:border dark:border-slate-700 sm:rounded-2xl">

            {{-- [PERBAIKAN] Logo dipindahkan ke dalam kartu --}}
            <div class="flex justify-center mb-6">
                <a href="/" class="flex items-center">
                    <svg class="w-16 h-16 mr-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                    <span class="text-4xl font-semibold whitespace-nowrap dark:text-white">AuditSys</span>
                </a>
            </div>

            {{-- Slot untuk konten form (login, register, dll.) --}}
            {{ $slot }}
        </div>

        {{-- [TAMBAHAN] Footer sederhana untuk hak cipta --}}
        <footer class="mt-6 text-sm text-center text-gray-500">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.</p>
        </footer>
    </div>
</body>

</html>

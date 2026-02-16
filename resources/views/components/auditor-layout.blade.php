<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Auditor</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="flex min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Sidebar -->
        <aside class="flex flex-col w-64 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700 h-screen sticky top-0">
            <div class="flex items-center justify-center h-16 border-b border-gray-100 dark:border-gray-700">
                <span class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Auditor Panel
                </span>
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('auditor.dashboard') }}" 
                    class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('auditor.dashboard') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 font-bold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-blue-600' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
            </nav>
            <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 font-bold text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/20">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-gray-800 dark:text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 font-medium">System Auditor</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2.5 text-sm font-bold text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-red-600 transition-all shadow-sm">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-col flex-1">
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow dark:bg-gray-800">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>

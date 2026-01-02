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
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <aside class="flex flex-col w-64 bg-gradient-to-b from-purple-800 to-indigo-900 dark:from-slate-800 dark:to-slate-900">
            <div class="flex items-center justify-center h-16 border-b border-purple-700 dark:border-slate-700">
                <span class="text-xl font-bold text-white">🔍 Auditor Panel</span>
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('auditor.dashboard') }}" 
                    class="flex items-center px-4 py-3 text-white rounded-lg transition-colors {{ request()->routeIs('auditor.dashboard') ? 'bg-purple-700 dark:bg-slate-700' : 'hover:bg-purple-700/50 dark:hover:bg-slate-700/50' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
            </nav>
            <div class="p-4 border-t border-purple-700 dark:border-slate-700">
                <div class="flex items-center text-white">
                    <div class="flex items-center justify-center w-10 h-10 font-semibold bg-purple-600 rounded-full">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-purple-300">Auditor</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-sm text-white bg-purple-700 rounded-lg hover:bg-purple-600">
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

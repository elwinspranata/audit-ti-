<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
             class="fixed inset-y-0 left-0 z-30 transition duration-300 transform bg-white dark:bg-gray-800 lg:translate-x-0 lg:static lg:inset-0">
            @include('layouts.partials.admin-sidebar')
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            <!-- Mobile Header -->
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b lg:hidden dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <span class="ml-4 text-xl font-semibold dark:text-white">AuditSys Admin</span>
                </div>
            </header>

            <!-- Backdrop -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" 
                 class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>

            <main class="flex-1 p-4 md:p-6 lg:p-8">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="mb-6 bg-white rounded-lg shadow dark:bg-gray-800">
                        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <div class="animate-fadeIn">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <style>
        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>

</html>

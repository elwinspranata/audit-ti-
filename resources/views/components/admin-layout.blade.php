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

    <!-- Scripts (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Perbaikan Layout Admin */
        body {
            overflow: hidden; /* Mencegah double scrollbar di body */
        }
        
        .admin-wrapper {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        .admin-sidebar-container {
            width: 16rem; /* w-64 = 16rem */
            flex-shrink: 0;
            height: 100%;
        }

        .admin-main-wrapper {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
            background-color: #f3f4f6; /* bg-gray-100 */
        }

        .dark .admin-main-wrapper {
            background-color: #111827; /* bg-gray-900 */
        }

        .admin-content-scrollable {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 1.5rem; /* p-6 */
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <div class="admin-sidebar-container">
            @include('layouts.partials.admin-sidebar')
        </div>

        <!-- Main Content -->
        <div class="admin-main-wrapper">
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow dark:bg-gray-800">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="admin-content-scrollable">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>

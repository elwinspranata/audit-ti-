<x-admin-layout>
    {{-- <x-slot name="header">
        <div class="mt-5 remove-bg"></div>
        {{-- <h2 class="text-xl font-bold leading-tight tracking-wide text-gray-700 dark:text-sky-300 animate-fadeInDown">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot> --}}

    <style>
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            0% {
                opacity: 0;
                transform: translateX(-30px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .8;
            }
        }

        .animation-delay-100 {
            animation-delay: 0.1s;
            opacity: 0;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .animation-delay-300 {
            animation-delay: 0.3s;
            opacity: 0;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
            opacity: 0;
        }

        .animate-fadeInDown {
            animation: fadeInDown 0.6s ease-out forwards;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .animate-slideInLeft {
            animation: slideInLeft 0.6s ease-out forwards;
        }

        .animate-bounce {
            animation: bounce 2s infinite;
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Enhanced stat card hover effects */
        .stat-card {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease-out;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15), 0 0 50px rgba(14, 165, 233, 0.3);
        }

        .dark .stat-card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), 0 0 60px rgba(56, 189, 248, 0.4);
        }

        /* Icon animation */
        .icon-bounce:hover {
            animation: bounce 1s ease-in-out;
        }

        /* Gradient text animation */
        .gradient-text {
            background: linear-gradient(-45deg, #0ea5e9, #3b82f6, #6366f1, #8b5cf6);
            background-size: 400% 400%;
            animation: gradientShift 3s ease infinite;
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Progress bar animation */
        .progress-bar {
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: progressShimmer 2s infinite;
        }

        @keyframes progressShimmer {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }
    </style>

    <div class="py-16 mx-auto max-w-8xl sm:px-6 lg:px-8">

        {{-- Enhanced Welcome Panel --}}
        <div class="mb-10 shadow-2xl bg-white/80 backdrop-blur-md sm:p-8 dark:bg-slate-800/80 dark:backdrop-blur-md dark:shadow-blue-950/40 sm:rounded-2xl dark:border dark:border-blue-700/30 animate-fadeInUp animation-delay-300"
            style="opacity:0;">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="mb-2 text-3xl font-bold gradient-text">
                        Welcome Back, Admin! 👋
                    </h3>
                    <p class="text-lg text-gray-600 dark:text-gray-300">
                        Kelola sistem dengan mudah dan efisien
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="p-4 rounded-full shadow-lg bg-gradient-to-r from-sky-500 to-blue-600 animate-pulse">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2">
                <div class="p-4 text-white bg-gradient-to-r from-emerald-500 to-green-500 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Sistem Status</p>
                            <p class="text-lg font-semibold">Online & Aktif</p>
                        </div>
                        <div class="w-3 h-3 bg-white rounded-full animate-pulse"></div>
                    </div>
                </div>
                <div class="p-4 text-white bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Last Login</p>
                            <p class="text-lg font-semibold">{{ now()->format('d M Y, H:i') }}</p>
                        </div>
                        <svg class="w-6 h-6 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <p class="mb-6 text-base leading-relaxed text-gray-600 dark:text-gray-300">
                Dashboard ini menyediakan akses lengkap untuk mengelola pengguna, item Cobit, kategori, level, dan
                kuesioner.
                Gunakan menu navigasi untuk mengakses berbagai fitur yang tersedia.
            </p>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white transition-all duration-300 ease-in-out transform rounded-lg shadow-md bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 hover:shadow-lg hover:shadow-sky-500/40 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-slate-800 focus:ring-blue-500 hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                    Kelola Users
                </a>
                <a href="{{ route('cobititem.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-gray-700 transition-all duration-300 ease-in-out transform bg-white border border-gray-300 rounded-lg shadow-md hover:bg-gray-50 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-500 hover:scale-105 dark:bg-slate-700 dark:text-white dark:border-slate-600 dark:hover:bg-slate-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Cobit Items
                </a>
                <a href="{{ route('admin.report.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-gray-700 transition-all duration-300 ease-in-out transform bg-white border border-gray-300 rounded-lg shadow-md hover:bg-gray-50 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-500 hover:scale-105 dark:bg-slate-700 dark:text-white dark:border-slate-600 dark:hover:bg-slate-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Reports
                </a>
            </div>
        </div>

        {{-- Enhanced Statistics Cards --}}
        <div class="grid grid-cols-1 gap-6 mt-8 sm:grid-cols-2 lg:grid-cols-3">

            {{-- Enhanced Users Card --}}
            <div class="relative p-6 transition-all duration-300 ease-out shadow-xl bg-white/80 backdrop-blur-md stat-card dark:bg-slate-800/80 dark:backdrop-blur-md dark:shadow-blue-950/40 sm:rounded-2xl dark:border dark:border-sky-700/40 animate-fadeInUp"
                style="opacity:0;">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-sky-200">Total Users</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pengguna terdaftar</p>
                    </div>
                    <div class="p-3 rounded-full shadow-lg bg-gradient-to-r from-sky-500 to-blue-600 icon-bounce">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mb-4">
                    <p
                        class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-sky-400 via-blue-500 to-indigo-500 dark:from-sky-300 dark:via-blue-400 dark:to-indigo-400">
                        {{ $usersCount ?? '0' }}
                    </p>
                    <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                            +12% dari bulan lalu
                        </span>
                    </p>
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full dark:bg-gray-700 progress-bar">
                    <div class="h-2 rounded-full bg-gradient-to-r from-sky-500 to-blue-600" style="width: 75%">
                    </div>
                </div>
            </div>

            {{-- Enhanced Pending Approvals Card --}}
            <div class="relative p-6 transition-all duration-300 ease-out shadow-xl bg-white/80 backdrop-blur-md stat-card dark:bg-slate-800/80 dark:backdrop-blur-md dark:shadow-blue-950/40 sm:rounded-2xl dark:border dark:border-sky-700/40 animate-fadeInUp animation-delay-100"
                style="opacity:0;">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-sky-200">Pending Approvals</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Menunggu persetujuan</p>
                    </div>
                    <div class="p-3 rounded-full shadow-lg bg-gradient-to-r from-amber-500 to-orange-600 icon-bounce">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mb-4">
                    <p
                        class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-orange-500 to-red-500 dark:from-amber-300 dark:via-orange-400 dark:to-red-400">
                        {{ $pendingApprovals ?? '11' }}
                    </p>
                    <p class="text-sm font-medium text-amber-600 dark:text-amber-400">
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Perlu tindakan segera
                        </span>
                    </p>
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full dark:bg-gray-700 progress-bar">
                    <div class="h-2 rounded-full bg-gradient-to-r from-amber-500 to-orange-600 animate-pulse"
                        style="width: 40%"></div>
                </div>
            </div>

            {{-- Enhanced Cobit Items Card --}}
            <div class="relative p-6 transition-all duration-300 ease-out shadow-xl bg-white/80 backdrop-blur-md stat-card dark:bg-slate-800/80 dark:backdrop-blur-md dark:shadow-blue-950/40 sm:rounded-2xl dark:border dark:border-sky-700/40 animate-fadeInUp animation-delay-200"
                style="opacity:0;">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-sky-200">Cobit Items</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total item tersedia</p>
                    </div>
                    <div class="p-3 rounded-full shadow-lg bg-gradient-to-r from-emerald-500 to-teal-600 icon-bounce">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mb-4">
                    <p
                        class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 via-emerald-500 to-green-500 dark:from-teal-300 dark:via-emerald-400 dark:to-green-400">
                        {{ $cobitItemsCount ?? '0' }}
                    </p>
                    <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Semua item aktif
                        </span>
                    </p>
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full dark:bg-gray-700 progress-bar">
                    <div class="h-2 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600" style="width: 90%">
                    </div>
                </div>
            </div>

        </div>

        {{-- Quick Actions Section --}}
        <div class="grid grid-cols-1 gap-6 mt-10 md:grid-cols-2">
            <div class="p-6 shadow-xl bg-white/80 backdrop-blur-md rounded-2xl dark:bg-slate-800/80 dark:border dark:border-sky-700/40 animate-slideInLeft animation-delay-400"
                style="opacity:0;">
                <h4 class="mb-4 text-lg font-semibold text-gray-800 dark:text-sky-200">Aksi Cepat</h4>
                <div class="space-y-3">
                    <a href="{{ route('admin.approvals.index') }}"
                        class="flex items-center justify-between w-full p-3 text-white transition-all duration-300 transform rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 hover:scale-105">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Approval Users
                        </span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                    <a href="{{ route('excel.index') }}"
                        class="flex items-center justify-between w-full p-3 text-white transition-all duration-300 transform rounded-lg bg-gradient-to-r from-emerald-500 to-green-500 hover:from-green-600 hover:to-teal-700 hover:scale-105">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            Import Data
                        </span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="p-6 shadow-xl bg-white/80 backdrop-blur-md rounded-2xl dark:bg-slate-800/80 dark:border dark:border-sky-700/40 animate-slideInLeft animation-delay-400"
                style="opacity:0;">
                <h4 class="mb-4 text-lg font-semibold text-gray-800 dark:text-sky-200">Aktivitas Terbaru</h4>
                <div class="space-y-3">
                    <div class="flex items-center p-3 rounded-lg bg-gray-50 dark:bg-slate-700/50">
                        <div class="w-2 h-2 mr-3 bg-green-500 rounded-full"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">User baru terdaftar</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">2 menit yang lalu</p>
                        </div>
                    </div>
                    <div class="flex items-center p-3 rounded-lg bg-gray-50 dark:bg-slate-700/50">
                        <div class="w-2 h-2 mr-3 bg-blue-500 rounded-full"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">Cobit item diperbarui
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">1 jam yang lalu</p>
                        </div>
                    </div>
                    <div class="flex items-center p-3 rounded-lg bg-gray-50 dark:bg-slate-700/50">
                        <div class="w-2 h-2 mr-3 rounded-full bg-amber-500"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">Approval menunggu</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">3 jam yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-admin-layout>

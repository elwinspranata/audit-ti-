<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold leading-tight tracking-wide text-gray-800 dark:text-white animate-fadeInDown">
                {{ __('Profile Settings') }}
            </h2>
            <div class="flex items-center space-x-2 animate-fadeInDown animation-delay-100">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <span class="text-sm text-gray-600 dark:text-gray-300">Online</span>
            </div>
        </div>
    </x-slot>

    {{-- Enhanced CSS animations and styling --}}
    <style>
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
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

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .animate-fadeInDown {
            animation: fadeInDown 0.8s ease-out forwards;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-slideInLeft {
            animation: slideInLeft 0.8s ease-out forwards;
        }

        .animate-pulse-slow {
            animation: pulse 2s infinite;
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

        /* Custom gradient backgrounds */
        .bg-gradient-profile {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-gradient-password {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
        }

        /* Glass morphism effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Hover effects */
        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Form styling */
        .form-section {
            position: relative;
            overflow: hidden;
        }

        .form-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.5), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }
    </style>

    {{-- Background with gradient --}}
    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-indigo-900">
        {{-- Background pattern --}}
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60"
            xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%236366f1"
            fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="1.5" /%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]">
        </div>

        <div class="relative py-12">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                {{-- Page intro --}}
                <div class="mb-12 text-center animate-fadeInUp">
                    <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-300">
                        Manage your account settings and preferences
                    </p>
                </div>

                {{-- Cards Grid --}}
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                    {{-- Profile Information Card --}}
                    <div class="lg:col-span-2">
                        <div
                            class="p-8 border shadow-2xl form-section bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border-white/20 dark:border-slate-700/50 hover-lift animate-fadeInUp">
                            {{-- Card Header --}}
                            <div class="flex items-center mb-8">
                                <div
                                    class="flex items-center justify-center w-12 h-12 shadow-lg bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Profile Information</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Update your account profile
                                        information and email address</p>
                                </div>
                            </div>

                            {{-- Form Content --}}
                            <div class="space-y-6">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>

                    {{-- Side Cards --}}
                    <div class="space-y-8">
                        {{-- Password Update Card --}}
                        <div
                            class="p-6 border shadow-2xl form-section bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border-white/20 dark:border-slate-700/50 hover-lift animate-fadeInUp animation-delay-100">
                            {{-- Card Header --}}
                            <div class="flex items-center mb-6">
                                <div
                                    class="flex items-center justify-center w-10 h-10 rounded-lg shadow-lg bg-gradient-to-r from-green-500 to-teal-600">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Change Password</h3>
                                    <p class="text-xs text-gray-600 dark:text-gray-300">Keep your account secure</p>
                                </div>
                            </div>

                            {{-- Form Content --}}
                            <div class="space-y-4">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>

                        {{-- Delete Account Card --}}
                        <div
                            class="p-6 border shadow-2xl form-section bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border-red-200/50 dark:border-red-900/50 hover-lift animate-fadeInUp animation-delay-200">
                            {{-- Card Header --}}
                            <div class="flex items-center mb-6">
                                <div
                                    class="flex items-center justify-center w-10 h-10 rounded-lg shadow-lg bg-gradient-to-r from-red-500 to-pink-600">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Delete Account</h3>
                                    <p class="text-xs text-gray-600 dark:text-gray-300">Permanently remove your account
                                    </p>
                                </div>
                            </div>

                            {{-- Form Content --}}
                            <div class="space-y-4">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Additional Info Section --}}
                <div class="mt-12 text-center animate-fadeInUp animation-delay-300">
                    <div
                        class="inline-flex items-center px-6 py-3 space-x-2 rounded-full shadow-lg bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm text-gray-600 dark:text-gray-300">
                            Need help? Contact our support team
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

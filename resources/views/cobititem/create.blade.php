<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight tracking-wide text-gray-700 dark:text-sky-300 animate-fadeInDown">
            {{ __('Create Cobit Item') }}
        </h2>
    </x-slot>

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

        @keyframes slideInRight {
            0% {
                opacity: 0;
                transform: translateX(20px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fadeInDown {
            animation: fadeInDown 0.6s ease-out forwards;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-slideInRight {
            animation: slideInRight 0.6s ease-out forwards;
        }

        .input-group {
            position: relative;
        }

        .input-group input:focus+.input-label,
        .input-group textarea:focus+.input-label,
        .input-group input:not(:placeholder-shown)+.input-label,
        .input-group textarea:not(:placeholder-shown)+.input-label {
            transform: translateY(-24px) scale(0.85);
            color: #0ea5e9;
        }

        .input-label {
            position: absolute;
            top: 12px;
            left: 12px;
            background: white;
            padding: 0 8px;
            transition: all 0.2s ease;
            pointer-events: none;
            font-weight: 500;
        }

        .dark .input-label {
            background: rgb(30 41 59 / 0.7);
        }

        .form-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }

        .dark .form-container {
            background: rgba(30, 41, 59, 0.8);
        }
    </style>

    <div
        class="min-h-screen py-8 dark:bg-slate-950 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-950">
        <div class="max-w-4xl px-4 mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="flex mb-8 animate-fadeInDown" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="#"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="#"
                                class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Cobit
                                Items</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span
                                class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Create</span>
                        </div>
                    </li>
                </ol>
            </nav>

            @if (session('success'))
                <div class="flex items-center p-4 mb-6 text-sm text-green-700 bg-green-100 border border-green-300 rounded-lg dark:bg-green-800/20 dark:text-green-300 dark:border-green-600/30 animate-fadeInDown"
                    role="alert">
                    <svg class="w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div
                class="p-8 border shadow-2xl form-container sm:rounded-2xl border-white/20 dark:border-slate-700/50 animate-fadeInUp">

                <!-- Header Section -->
                <div class="mb-8 text-center">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 mb-4 shadow-lg bg-gradient-to-br from-blue-500 to-sky-500 rounded-2xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-3xl font-bold text-gray-800 dark:text-white">
                        Create New Cobit Item
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Fill in the details below to create a new cobit item
                    </p>
                </div>

                <form action="{{ route('cobititem.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Form Fields -->
                    <div class="grid gap-8 md:grid-cols-1">

                        <!-- Nama Item Field -->
                        <div class="space-y-2 animate-slideInRight" style="animation-delay: 0.1s;">
                            <label for="nama_item"
                                class="block mb-3 text-sm font-semibold text-gray-700 dark:text-sky-200">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                        </path>
                                    </svg>
                                    Item Name
                                </span>
                            </label>
                            <input type="text" name="nama_item" id="nama_item" required
                                value="{{ old('nama_item') }}" placeholder="Enter the cobit item name"
                                class="block w-full px-4 py-3 text-base transition-all duration-200 ease-in-out border-2 border-gray-200 shadow-sm rounded-xl dark:border-slate-600 dark:bg-slate-700/50 dark:text-gray-100 focus:border-sky-500 dark:focus:border-sky-400 focus:ring-4 focus:ring-sky-500/20 dark:focus:ring-sky-400/20 placeholder:text-gray-400 dark:placeholder:text-slate-400 hover:border-gray-300 dark:hover:border-slate-500" />
                            @error('nama_item')
                                <p class="flex items-center mt-2 text-sm text-red-600 dark:text-red-400">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Deskripsi Field -->
                        <div class="space-y-2 animate-slideInRight" style="animation-delay: 0.2s;">
                            <label for="deskripsi"
                                class="block mb-3 text-sm font-semibold text-gray-700 dark:text-sky-200">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Description
                                </span>
                            </label>
                            <textarea name="deskripsi" id="deskripsi" rows="5" required
                                placeholder="Provide a detailed description of the cobit item..."
                                class="block w-full px-4 py-3 text-base transition-all duration-200 ease-in-out border-2 border-gray-200 shadow-sm resize-none rounded-xl dark:border-slate-600 dark:bg-slate-700/50 dark:text-gray-100 focus:border-sky-500 dark:focus:border-sky-400 focus:ring-4 focus:ring-sky-500/20 dark:focus:ring-sky-400/20 placeholder:text-gray-400 dark:placeholder:text-slate-400 hover:border-gray-300 dark:hover:border-slate-500">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="flex items-center mt-2 text-sm text-red-600 dark:text-red-400">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-4 pt-6 border-t border-gray-200 sm:flex-row dark:border-slate-700 animate-slideInRight"
                        style="animation-delay: 0.3s;">
                        <button type="submit"
                            class="inline-flex items-center justify-center flex-1 px-8 py-4 text-base font-semibold text-white transition-all duration-300 ease-in-out transform shadow-lg sm:flex-none rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 hover:shadow-xl hover:shadow-sky-500/25 focus:outline-none focus:ring-4 focus:ring-sky-500/50 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-slate-800 hover:scale-105 group">
                            <svg class="w-5 h-5 mr-2 transition-transform group-hover:scale-110" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Create Cobit Item
                        </button>

                        <a href="{{ route('cobititem.index') }}"
                            class="inline-flex items-center justify-center flex-1 px-8 py-4 text-base font-semibold text-gray-700 transition-all duration-300 ease-in-out bg-white border-2 border-gray-300 shadow-sm sm:flex-none dark:text-gray-300 dark:bg-slate-700 dark:border-slate-600 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-600 hover:border-gray-400 dark:hover:border-slate-500 focus:outline-none focus:ring-4 focus:ring-gray-500/20 hover:shadow-md group">
                            <svg class="w-5 h-5 mr-2 transition-transform group-hover:scale-110" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-admin-layout>

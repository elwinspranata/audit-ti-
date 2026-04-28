<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight tracking-wide text-gray-700 dark:text-sky-300 animate-fadeInDown">
            {{ __('Edit Cobit Item') }}
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

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .8;
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

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .form-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }

        .dark .form-container {
            background: rgba(30, 41, 59, 0.8);
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #0ea5e9;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
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
                            <a href="{{ route('cobititem.index') }}"
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Edit</span>
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

            @if (session('error'))
                <div class="flex items-center p-4 mb-6 text-sm text-red-700 bg-red-100 border border-red-300 rounded-lg dark:bg-red-800/20 dark:text-red-300 dark:border-red-600/30 animate-fadeInDown"
                    role="alert">
                    <svg class="w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div
                class="p-8 border shadow-2xl form-container sm:rounded-2xl border-white/20 dark:border-slate-700/50 animate-fadeInUp">

                <!-- Header Section -->
                <div class="mb-8 text-center">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 mb-4 shadow-lg bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-3xl font-bold text-gray-800 dark:text-white">
                        Edit Cobit Item
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Update the information for this cobit item
                    </p>
                </div>

                <!-- Current Item Info -->
                <div
                    class="p-4 mb-8 border border-blue-200 bg-blue-50 dark:bg-blue-900/20 rounded-xl dark:border-blue-800/30 animate-slideInRight">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h4 class="text-lg font-semibold text-blue-800 dark:text-blue-300">Current Item Information</h4>
                    </div>
                    <div class="grid gap-4 text-sm md:grid-cols-2">
                        <div>
                            <span class="font-medium text-blue-700 dark:text-blue-300">ID:</span>
                            <span class="ml-2 text-blue-600 dark:text-blue-400">#{{ $item->id }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-blue-700 dark:text-blue-300">Status:</span>
                            <span
                                class="ml-2 px-2 py-1 text-xs font-medium rounded-full {{ $item->is_visible ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                {{ $item->is_visible ? 'Visible' : 'Hidden' }}
                            </span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('cobititem.update', $item->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

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
                                value="{{ old('nama_item', $item->nama_item) }}"
                                placeholder="Enter the cobit item name"
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
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Description
                                </span>
                            </label>
                            <textarea name="deskripsi" id="deskripsi" rows="5" required
                                placeholder="Provide a detailed description of the cobit item..."
                                class="block w-full px-4 py-3 text-base transition-all duration-200 ease-in-out border-2 border-gray-200 shadow-sm resize-none rounded-xl dark:border-slate-600 dark:bg-slate-700/50 dark:text-gray-100 focus:border-sky-500 dark:focus:border-sky-400 focus:ring-4 focus:ring-sky-500/20 dark:focus:ring-sky-400/20 placeholder:text-gray-400 dark:placeholder:text-slate-400 hover:border-gray-300 dark:hover:border-slate-500">{{ old('deskripsi', $item->deskripsi) }}</textarea>
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

                        <!-- Visibility Toggle -->
                        <div class="space-y-2 animate-slideInRight" style="animation-delay: 0.3s;">
                            <label class="block mb-3 text-sm font-semibold text-gray-700 dark:text-sky-200">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Visibility Settings
                                </span>
                            </label>
                            <div
                                class="p-4 border border-gray-200 bg-gray-50 dark:bg-slate-700/30 rounded-xl dark:border-slate-600">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="mr-4">
                                            <h4 class="text-base font-medium text-gray-900 dark:text-white">Item
                                                Visibility</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Control whether this
                                                item is visible to users</p>
                                        </div>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="is_visible" value="1"
                                            {{ old('is_visible', $item->is_visible) ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        When enabled, this item will be visible in the public interface
                                    </span>
                                </div>
                            </div>
                            @error('is_visible')
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
                        style="animation-delay: 0.4s;">
                        <button type="submit"
                            class="inline-flex items-center justify-center flex-1 px-8 py-4 text-base font-semibold text-white transition-all duration-300 ease-in-out transform shadow-lg sm:flex-none rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 hover:shadow-xl hover:shadow-amber-500/25 focus:outline-none focus:ring-4 focus:ring-amber-500/50 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-slate-800 hover:scale-105 group">
                            <svg class="w-5 h-5 mr-2 transition-transform group-hover:scale-110" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Item
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

                        {{-- <a href="{{ route('cobititem.show', $item->id) }}"
                            class="inline-flex items-center justify-center flex-1 px-8 py-4 text-base font-semibold text-blue-700 transition-all duration-300 ease-in-out border-2 border-blue-200 shadow-sm sm:flex-none dark:text-blue-300 bg-blue-50 dark:bg-blue-900/20 dark:border-blue-800 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-900/30 hover:border-blue-300 dark:hover:border-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20 hover:shadow-md group">
                            <svg class="w-5 h-5 mr-2 transition-transform group-hover:scale-110" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            View Item
                        </a> --}}
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-admin-layout>

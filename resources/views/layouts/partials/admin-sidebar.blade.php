<aside
    class="sticky top-0 z-20 flex flex-col w-64 h-screen overflow-y-auto bg-white border-r dark:bg-gray-800 dark:border-gray-700">
    <!-- Logo -->
    <div class="flex items-center justify-center px-4 py-8 border-b dark:border-gray-700">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center">
            {{-- Ganti dengan logo sistem Anda jika ada --}}
            <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                </path>
            </svg>
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">AuditSys</span>
        </a>
        {{-- <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
            <x-application-logo class="block w-auto text-gray-800 fill-current h-9 dark:text-gray-200" />
            <span class="text-lg font-semibold text-gray-800 dark:text-gray-200">Admin Panel</span>
        </a> --}}
    </div>

    <!-- Navigation Links -->
    {{-- Class 'flex-grow' ini akan mendorong menu dropdown ke bawah --}}
    <nav class="flex-grow px-2 py-4 space-y-1">
        <!-- Dashboard -->
        <x-sidebar-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
            <!-- Heroicon: home -->
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            {{ __('Dashboard') }}
        </x-sidebar-link>

        <!-- User Approvals -->
        <x-sidebar-link :href="route('admin.approvals.index')" :active="request()->routeIs('admin.approvals.index')">
            <!-- Heroicon: user-check -->
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14l-4 6h8l-4-6z" />
            </svg>
            {{ __('User Approvals') }}
        </x-sidebar-link>

        <!-- Assessment Approvals -->
        <x-sidebar-link :href="route('admin.assessments.index')" :active="request()->routeIs('admin.assessments.*')">
            <!-- Heroicon: clipboard-check -->
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            {{ __('Manajemen Assessment') }}
        </x-sidebar-link>




        <!-- Reports (NEW) -->
        <x-sidebar-link :href="route('admin.report.index')" :active="request()->routeIs('admin.report.*')">
            <!-- Heroicon: document-report -->
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            {{ __('Reports') }}
        </x-sidebar-link>

        {{-- user manage --}}
        <x-sidebar-link :href="route('users.index')" :active="request()->routeIs('users.*')">
            <!-- Heroicon: person -->
            <!-- Heroicon: user -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A12.072 12.072 0 0112 15c2.21 0 4.27.607
           6 1.655M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>

            {{ __('Manage Users') }}
        </x-sidebar-link>

        <!-- Divider -->
        <div class="pt-2 pb-1">
            <hr class="border-gray-200 dark:border-gray-700">
        </div>

        <!-- Cobit Items -->
        <x-sidebar-link :href="route('cobititem.index')" :active="request()->routeIs('cobititem.*')">
            <!-- Heroicon: document-text -->
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            {{ __('Cobit Items') }}
        </x-sidebar-link>

        <!-- Kategori -->
        <x-sidebar-link :href="route('kategori.index')" :active="request()->routeIs('kategori.*')">
            <!-- Heroicon: collection -->
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            {{ __('Category') }}
        </x-sidebar-link>

        <!-- Level -->
        <x-sidebar-link :href="route('level.index')" :active="request()->routeIs('level.*')">
            <!-- Heroicon: trending-up -->
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            {{ __('Levels') }}
        </x-sidebar-link>

        <!-- Quisioner -->
        <x-sidebar-link :href="route('quisioner.index')" :active="request()->routeIs('quisioner.*')">
            <!-- Heroicon: question-mark-circle -->
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ __('Questionnaire') }}
        </x-sidebar-link>

        <!-- Resubmissions -->
        <x-sidebar-link :href="route('resubmissions.index')" :active="request()->routeIs('resubmissions.*')">
            <!-- Heroicon: reply -->
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h10a8 8 0 018 8v2M3 10l6-6m0 0l6 6" />
            </svg>
            {{ __('Resubmissions') }}
        </x-sidebar-link>

        <!-- Import -->
        <x-sidebar-link :href="route('excel.index')" :active="request()->routeIs('excel.*')">
            <!-- Heroicon: document-add -->
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            {{ __('Imports') }}
        </x-sidebar-link>

        <!-- Payments -->
        <x-sidebar-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.*')">
            <!-- Heroicon: currency-dollar -->
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ __('Payments') }}
        </x-sidebar-link>

    </nav>

    <!-- User Dropdown (Posisi yang Benar) -->
    <div class="px-2 py-3 border-t dark:border-gray-700">
        {{-- Kunci perbaikan ada di sini: x-data diletakkan di container --}}
        <div x-data="{ open: false }" class="relative">
            {{-- Trigger (Tombol untuk membuka dropdown) --}}
            <button @click="open = !open"
                class="inline-flex items-center justify-between w-full px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                <div>{{ Auth::user()->name }}</div>
                <div class="ms-1">
                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </button>

            {{-- Dropdown Panel (Konten yang muncul/hilang) --}}
            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 z-50 w-full mb-2 origin-bottom-right rounded-md shadow-lg bottom-full"
                style="display: none;">
                <div class="py-1 bg-white rounded-md ring-1 ring-black ring-opacity-5 dark:bg-gray-700">
                    <x-dropdown-link :href="route('profileadmin.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</aside>

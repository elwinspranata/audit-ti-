<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Account Pending Approval') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-6 py-4">
                    <h3 class="text-lg text-gray-900">Your account is currently pending approval by the admin.</h3>
                    <p class="mt-2 text-sm text-gray-600">Please wait until you receive confirmation of approval to
                        access the platform.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

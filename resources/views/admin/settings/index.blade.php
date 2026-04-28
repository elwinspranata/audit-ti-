<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Pengaturan Website') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                @foreach ($settings as $group => $groupSettings)
                    <div class="mb-8 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="mb-6 text-lg font-bold border-b pb-2 uppercase tracking-wider text-blue-600 dark:text-blue-400">
                                {{ ucfirst($group) }} Settings
                            </h3>
                            
                            <div class="space-y-6">
                                @foreach ($groupSettings as $setting)
                                    <div>
                                        <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            {{ ucwords(str_replace('_', ' ', str_replace($group . '_', '', $setting->key))) }}
                                        </label>
                                        
                                        @if ($setting->type === 'textarea')
                                            <textarea id="{{ $setting->key }}" name="{{ $setting->key }}" rows="4" 
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors">{{ $setting->value }}</textarea>
                                        @else
                                            <input type="text" id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ $setting->value }}"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors">
                                        @endif
                                        
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Key: <code class="bg-gray-100 dark:bg-gray-900 px-1 rounded">{{ $setting->key }}</code></p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="flex justify-end mt-6">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-bold text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-lg shadow-blue-500/20">
                        {{ __('Simpan Perubahan') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="text-center">
            <h2 class="text-3xl font-bold leading-tight tracking-wide text-gray-800 dark:text-white">
                {{ __('Pilih Paket Layanan') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                Silakan pilih paket berlangganan untuk mengakses sistem audit TI.
            </p>
        </div>
    </x-slot>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn 0.6s ease-out forwards; opacity: 0; }
        .animation-delay-100 { animation-delay: 0.1s; }
        .animation-delay-200 { animation-delay: 0.2s; }
        .animation-delay-300 { animation-delay: 0.3s; }
        .glass-effect { backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-8px) scale(1.02); }
    </style>

    <div class="py-8 min-h-screen bg-slate-950 dark:bg-gray-900 bg-gradient-to-br from-slate-950 via-gray-900 to-slate-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/40 dark:text-red-200 border border-red-200 dark:border-red-800" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium">Error:</span> {{ session('error') }}
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/40 dark:text-green-200 border border-green-200 dark:border-green-800" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium">Berhasil!</span> {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="grid gap-8 lg:grid-cols-3">
                @foreach($packages as $index => $package)
                    @php
                        $delayClass = 'animation-delay-' . (($index % 3) + 1) . '00';
                        
                        // Different accent colors for each package tier
                        $colors = [
                            0 => ['border' => 'border-blue-500/50', 'bg' => 'bg-blue-500', 'text' => 'text-blue-400', 'ring' => 'ring-blue-500'],
                            1 => ['border' => 'border-indigo-500/50', 'bg' => 'bg-indigo-500', 'text' => 'text-indigo-400', 'ring' => 'ring-indigo-500'],
                            2 => ['border' => 'border-purple-500/50', 'bg' => 'bg-purple-500', 'text' => 'text-purple-400', 'ring' => 'ring-purple-500'],
                        ];
                        $color = $colors[$index % 3];
                    @endphp

                    <div class="group relative flex flex-col overflow-hidden bg-white dark:bg-slate-800/90 glass-effect border border-gray-200 dark:border-slate-700 hover:{{ $color['border'] }} rounded-2xl shadow-xl card-hover animate-fadeIn {{ $delayClass }}">
                        
                        <!-- Package Header -->
                        <div class="p-6 bg-gray-50 dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700">
                            <h3 class="text-lg font-bold tracking-wide text-center text-gray-900 dark:text-white uppercase">
                                {{ $package->name }}
                            </h3>
                            
                            <div class="flex items-baseline justify-center mt-4 text-center">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Rp</span>
                                <span class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight ml-1">
                                    {{ number_format($package->price, 0, ',', '.') }}
                                </span>
                            </div>
                            
                            <p class="mt-3 text-center">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Masa aktif {{ $package->duration_days }} hari
                                </span>
                            </p>
                        </div>
                        
                        <!-- Package Body -->
                        <div class="flex flex-col flex-1 p-6 bg-white dark:bg-slate-800/50">
                            <div class="flex-1">
                                <!-- Features List -->
                                <ul class="space-y-3">
                                    @foreach(explode("\n", $package->description) as $feature)
                                        @if(trim($feature))
                                            <li class="flex items-start">
                                                <svg class="w-5 h-5 {{ $color['text'] }} mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-gray-700 dark:text-gray-300 text-sm">{{ trim($feature) }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            
                            <!-- Action Button -->
                            <div class="mt-8">
                                <a href="{{ route('payment.checkout', $package->id) }}" 
                                    class="flex items-center justify-center w-full px-6 py-3 text-base font-semibold text-white transition-all duration-200 transform shadow-lg group/btn bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 rounded-xl hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <span>Pilih Paket</span>
                                    <svg class="w-5 h-5 ml-2 transition-transform duration-200 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Popular Badge (for middle package) -->
                        @if($index === 1)
                            <div class="absolute top-0 right-0 -mr-1 -mt-1">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-white bg-gradient-to-r from-indigo-500 to-purple-500 rounded-bl-lg rounded-tr-xl shadow-lg">
                                    POPULER
                                </span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Additional Info -->
            <div class="mt-12 text-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    Butuh bantuan memilih paket? 
                    <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Hubungi tim kami</a>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="text-center">
            <h2 class="text-3xl font-bold leading-tight tracking-wide text-gray-800 dark:text-white">
                {{ __('Pilih Paket Layanan') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                Silakan pilih paket berlangganan untuk mengakses sistem assessment TI.
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

        /* Service Description Styles */
        .service-card {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.98));
            border: 1px solid rgba(99, 102, 241, 0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .service-card:hover {
            border-color: rgba(99, 102, 241, 0.4);
            box-shadow: 0 0 30px rgba(99, 102, 241, 0.08), 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        .service-icon-wrap {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.1));
            border: 1px solid rgba(99, 102, 241, 0.2);
        }
        .service-number {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .service-feature-item {
            border-left: 3px solid rgba(99, 102, 241, 0.3);
            transition: all 0.25s ease;
            background: rgba(99, 102, 241, 0.04);
        }
        .service-feature-item:hover {
            border-left-color: #818cf8;
            background: rgba(99, 102, 241, 0.1);
        }
        .service-toggle-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
            opacity: 0;
        }
        .service-toggle-content.open {
            max-height: 2000px;
            opacity: 1;
        }
        .service-toggle-btn {
            transition: all 0.3s ease;
        }
        .service-toggle-btn:hover {
            background: rgba(99, 102, 241, 0.1);
        }
        .service-toggle-btn .toggle-arrow {
            transition: transform 0.3s ease;
        }
        .service-toggle-btn.active .toggle-arrow {
            transform: rotate(180deg);
        }
        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.3), rgba(139, 92, 246, 0.3), transparent);
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .slide-in { animation: slideIn 0.4s ease-out forwards; }
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
                                <!-- Features List (Dynamic from database) -->
                                <ul class="space-y-3">
                                    @if($package->features->count() > 0)
                                        @foreach($package->features as $feature)
                                            <li class="flex items-start">
                                                @if($feature->is_included)
                                                    <svg class="w-5 h-5 {{ $color['text'] }} mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-gray-700 dark:text-gray-300 text-sm">{{ $feature->feature_name }}</span>
                                                @else
                                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-gray-400 dark:text-gray-600 text-sm line-through">{{ $feature->feature_name }}</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    @else
                                        {{-- Fallback: use description if no features defined yet --}}
                                        @foreach(explode("\n", $package->description) as $descFeature)
                                            @if(trim($descFeature))
                                                <li class="flex items-start">
                                                    <svg class="w-5 h-5 {{ $color['text'] }} mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-gray-700 dark:text-gray-300 text-sm">{{ trim($descFeature) }}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
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
                        
                        <!-- Popular Badge (Dynamic from database) -->
                        @if($package->is_popular)
                            <div class="absolute top-0 right-0 -mr-1 -mt-1">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-white bg-gradient-to-r from-indigo-500 to-purple-500 rounded-bl-lg rounded-tr-xl shadow-lg">
                                    POPULER
                                </span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if(isset($serviceTypes) && $serviceTypes->count() > 0)
            <!-- Section Divider -->
            <div class="section-divider my-16"></div>

            <!-- Jenis Layanan Section -->
            <div class="mb-12 animate-fadeIn animation-delay-300">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-white tracking-wide">Jenis Layanan</h2>
                    <p class="mt-3 text-gray-300 max-w-2xl mx-auto text-base leading-relaxed">Berikut adalah penjelasan lengkap mengenai layanan yang tersedia pada setiap paket.</p>
                </div>

                @php
                    $iconMap = [
                        'clipboard' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>',
                        'chart' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>',
                        'shield' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>',
                        'document' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>',
                        'search' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>',
                        'cog' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>',
                    ];
                @endphp

                <div class="space-y-6">
                    @foreach($serviceTypes as $svc)
                        <div class="service-card rounded-2xl overflow-hidden">
                            <button onclick="toggleService({{ $svc->id }})" class="service-toggle-btn w-full flex items-center justify-between p-6 text-left rounded-2xl" id="service-btn-{{ $svc->id }}">
                                <div class="flex items-center gap-4">
                                    <div class="service-icon-wrap w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $iconMap[$svc->icon] ?? $iconMap['clipboard'] !!}</svg>
                                    </div>
                                    <div>
                                        <span class="service-number text-sm font-bold">{{ $svc->label }}</span>
                                        <h3 class="text-lg font-bold text-white mt-0.5">{{ $svc->title }}</h3>
                                    </div>
                                </div>
                                <svg class="toggle-arrow w-5 h-5 text-gray-400 flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div class="service-toggle-content" id="service-content-{{ $svc->id }}">
                                <div class="px-5 sm:px-8 pb-8 pt-2">
                                    <div>
                                        <p class="text-gray-200 text-base leading-7 mb-4">{{ $svc->description }}</p>
                                        @if($svc->description2)
                                            <p class="text-gray-300 text-base leading-7 mb-6">{{ $svc->description2 }}</p>
                                        @endif

                                        @if(is_array($svc->features) && count($svc->features) > 0)
                                            <h4 class="text-white font-semibold text-base mb-4 flex items-center gap-2">
                                                <svg class="w-5 h-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path></svg>
                                                Fitur Utama
                                            </h4>
                                            <div class="space-y-3">
                                                @foreach($svc->features as $feature)
                                                    <div class="service-feature-item pl-4 py-3 rounded-r-lg">
                                                        <p class="text-base leading-7">
                                                            <span class="text-indigo-200 font-semibold">{{ $feature['name'] ?? '' }}</span><br>
                                                            <span class="text-gray-300">{{ $feature['detail'] ?? '' }}</span>
                                                        </p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if($svc->closing_note)
                                            <div class="mt-5 p-4 rounded-xl bg-indigo-500/10 border border-indigo-500/20">
                                                <p class="text-sm text-gray-200 italic leading-6">{{ $svc->closing_note }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Additional Info -->
            <div class="mt-12 text-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    Butuh bantuan memilih paket? 
                    <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Hubungi tim kami</a>
                </p>
            </div>

            <script>
                function toggleService(id) {
                    const content = document.getElementById('service-content-' + id);
                    const btn = document.getElementById('service-btn-' + id);
                    content.classList.toggle('open');
                    btn.classList.toggle('active');
                }
            </script>
        </div>
    </div>
</x-app-layout>

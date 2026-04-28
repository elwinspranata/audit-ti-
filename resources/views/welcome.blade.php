<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Landing Page Assessment Proses TI</title>
    <meta name="description" content="Sistem Informasi Assessment Proses Teknologi Informasi - Solusi profesional untuk audit dan pengawasan infrastruktur TI Anda." />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative min-h-screen bg-gray-900" x-data="{ showPolicy: true }">

    <!-- Policy Modal Overlay -->
    <div x-show="showPolicy" 
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <!-- Modal Container -->
        <div class="relative w-full max-w-2xl bg-slate-900 border border-slate-700 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden"
             @click.away="showPolicy = false"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-90 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            
            <!-- Header -->
            <div class="relative px-8 py-6 border-b border-slate-800 flex justify-between items-center bg-slate-900">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-white tracking-tight">{{ $site_settings['policy_title'] ?? 'Kebijakan Layanan' }}</h3>
                        <p class="text-xs text-blue-400 font-bold uppercase tracking-widest">{{ $site_settings['policy_subtitle'] ?? 'Audit Teknologi Informasi' }}</p>
                    </div>
                </div>
                <button @click="showPolicy = false" class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-full transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Content -->
            <div class="relative px-8 py-8 max-h-[50vh] overflow-y-auto text-white space-y-6 text-base leading-relaxed bg-slate-900">
                <div class="space-y-4">
                    <p class="font-bold text-lg text-white">{{ $site_settings['policy_welcome_message'] ?? 'Selamat datang di Platform Audit TI.' }}</p>
                    <p class="text-white">
                        {{ $site_settings['policy_main_description'] ?? 'Layanan audit kami dilaksanakan menggunakan kerangka kerja COBIT 2019 sebagai acuan utama dalam evaluasi tata kelola, manajemen risiko, dan efektivitas proses TI organisasi Anda.' }}
                    </p>
                    <div class="p-5 bg-slate-800 rounded-2xl border border-slate-700 space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="mt-1.5 w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                            <p class="text-white text-sm"><strong class="text-white text-base">{{ $site_settings['policy_point_1_title'] ?? 'Kerahasiaan Data' }}:</strong> {{ $site_settings['policy_point_1_content'] ?? 'Seluruh informasi yang diperoleh dijamin rahasia dan hanya digunakan untuk kepentingan audit.' }}</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="mt-1.5 w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                            <p class="text-white text-sm"><strong class="text-white text-base">{{ $site_settings['policy_point_2_title'] ?? 'Hasil Audit' }}:</strong> {{ $site_settings['policy_point_2_content'] ?? 'Temuan dan rekomendasi mencerminkan kondisi organisasi pada saat penilaian dilakukan.' }}</p>
                        </div>
                    </div>
                    <p class="text-white">
                        {{ $site_settings['policy_footer_message'] ?? 'Dengan melanjutkan penggunaan layanan ini, Anda dianggap telah memahami dan menyetujui seluruh syarat dan ketentuan yang berlaku.' }}
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="relative px-8 py-6 border-t border-slate-800 bg-slate-900 flex flex-col sm:flex-row justify-between items-center gap-4">
                <a href="{{ route('policy') }}" class="text-sm font-bold text-blue-400 hover:text-blue-300 transition-colors flex items-center">
                    Baca Kebijakan Lengkap
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
                <button @click="showPolicy = false" 
                        class="w-full sm:w-auto px-10 py-4 bg-blue-600 hover:bg-blue-500 text-white font-extrabold rounded-xl transition-all active:scale-95 shadow-xl shadow-blue-900/40">
                    Saya Setuju & Lanjutkan
                </button>
            </div>
        </div>
    </div>



    <!-- Hero Section -->
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="grid max-w-screen-xl gap-8 px-4 py-8 mx-auto lg:py-16 lg:grid-cols-2 lg:gap-16">
            <div class="flex flex-col justify-center">
                <h1
                    class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                    Optimalkan Assessment Proses TI untuk Keamanan & Efisiensi
                </h1>
                <p class="mb-6 text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
                    Kami fokus melakukan assessment dan pengawasan proses teknologi informasi untuk mendukung keamanan,
                    kepatuhan, dan pertumbuhan bisnis jangka panjang yang berkelanjutan.
                </p>
                <a href="{{ route('pricing.index') }}"
                    class="inline-flex items-center text-lg font-medium text-blue-600 dark:text-blue-500 hover:underline">
                    Pelajari lebih lanjut tentang assessment TI kami
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>
            <div>
                <div class="w-full p-6 space-y-8 bg-white rounded-lg shadow-xl lg:max-w-xl sm:p-8 dark:bg-gray-800">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Masuk ke Akun Anda
                    </h2>
                    <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div>
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Anda</label>
                            <input type="email" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                                dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="name@company.com" required />
                        </div>
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password
                                Anda</label>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                                dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required />
                        </div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="remember" aria-describedby="remember" name="remember" type="checkbox"
                                    class="w-4 h-4 border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600" />
                            </div>
                            <div class="text-sm ms-3">
                                <label for="remember" class="font-medium text-gray-500 dark:text-gray-400">Ingat
                                    saya</label>
                            </div>
                            <a href="{{ route('password.request') }}"
                                class="text-sm font-medium text-blue-600 ms-auto hover:underline dark:text-blue-500">Lupa
                                Password?</a>
                        </div>
                        <button type="submit"
                            class="w-full px-5 py-3 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 sm:w-auto dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Masuk ke Akun Anda
                        </button>
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                            Belum punya akun?
                            <a href="{{ route('register') }}"
                                class="text-blue-600 hover:underline dark:text-blue-500">Daftar Sekarang</a>
                        </div>

                        <div class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                            Dengan masuk, Anda menyetujui
                            <a href="{{ route('policy') }}" class="text-blue-600 hover:underline dark:text-blue-500">
                                Kebijakan Layanan
                            </a>
                            kami.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

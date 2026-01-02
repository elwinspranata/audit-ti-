<x-app-layout>
    {{-- Tambahkan ini di file CSS utama Anda atau di dalam tag <style> di layout utama Anda --}}
    {{-- Pastikan Tailwind JIT mode aktif untuk animasi custom dan properti seperti animation-delay --}}
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

        @keyframes pulseGlow {

            0%,
            100% {
                box-shadow: 0 0 15px 5px rgba(59, 130, 246, 0.4), 0 0 5px 2px rgba(59, 130, 246, 0.3);
            }

            50% {
                box-shadow: 0 0 25px 10px rgba(59, 130, 246, 0.6), 0 0 10px 5px rgba(59, 130, 246, 0.5);
            }
        }

        .animate-fadeInDown {
            animation: fadeInDown 0.8s ease-out forwards;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animation-delay-300 {
            animation-delay: 0.3s;
            opacity: 0;
            /* Start hidden before animation */
        }

        .animation-delay-600 {
            animation-delay: 0.6s;
            opacity: 0;
            /* Start hidden before animation */
        }

        .animation-delay-900 {
            animation-delay: 0.9s;
            opacity: 0;
            /* Start hidden before animation */
        }
    </style>

    <section
        class="bg-center bg-no-repeat bg-cover bg-[url('https://www.umy.ac.id/wp-content/uploads/2024/10/Gedung-AR-Fachruddin-A-dan-B-1-scaled.jpg')] bg-slate-900 bg-blend-multiply min-h-screen flex items-center relative overflow-hidden">
        {{-- Optional: Tambahkan efek overlay gradien atau partikel di sini jika diinginkan --}}
        {{-- <div class="absolute inset-0 bg-gradient-to-br from-black/30 via-transparent to-black/30"></div> --}}

        <div class="z-10 w-full max-w-screen-xl px-4 py-24 mx-auto text-center lg:py-56">
            <h1
                class="mb-6 text-4xl font-extrabold leading-tight tracking-tight text-transparent md:text-5xl lg:text-7xl bg-clip-text bg-gradient-to-r from-sky-300 via-cyan-300 to-purple-400 animate-fadeInDown drop-shadow-lg">
                Kami Mengoptimalkan Audit Proses TI untuk Masa Depan yang Lebih Aman
            </h1>
            <p
                class="mb-10 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48 animate-fadeInUp animation-delay-300">
                Di sini, kami fokus pada audit dan pengawasan proses teknologi informasi yang dapat meningkatkan
                keamanan, efisiensi, dan kepatuhan untuk mendukung pertumbuhan bisnis jangka panjang.
            </p>

            <div
                class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0 animate-fadeInUp animation-delay-600">
                <a href="{{ route('audit.index') }}"
                    class="group relative inline-flex items-center justify-center px-6 py-3.5 text-base font-bold text-center text-white
                          rounded-lg transition-all duration-500 ease-in-out
                          bg-gradient-to-br from-cyan-500 via-blue-600 to-purple-700
                          hover:from-cyan-600 hover:via-blue-700 hover:to-purple-800
                          focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800
                          overflow-hidden transform hover:scale-105 hover:shadow-2xl hover:shadow-cyan-500/50">

                    {{-- Efek kilau saat hover (opsional, bisa lebih disempurnakan) --}}
                    <span
                        class="absolute top-0 left-0 w-0 h-full transition-all duration-500 ease-out opacity-50 A bg-white/20 group-hover:w-full"></span>

                    <span class="relative">Get started</span> {{-- Teks harus relatif agar tetap di atas efek kilau --}}
                    <svg class="relative w-4 h-4 transition-transform duration-300 ms-2 rtl:rotate-180 group-hover:translate-x-1"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- Opsional: Elemen dekoratif futuristik di latar belakang --}}
        {{-- <div class="absolute bottom-0 left-0 z-0 w-full h-1/3 bg-gradient-to-t from-slate-900 via-slate-900/80 to-transparent opacity-70"></div> --}}
        {{-- <div class="absolute bg-purple-500 rounded-full top-10 -left-20 w-72 h-72 mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div> --}}
        {{-- <div class="absolute rounded-full bottom-10 -right-20 w-72 h-72 bg-cyan-500 mix-blend-multiply filter blur-3xl opacity-30 animate-pulse animation-delay-300"></div> --}}

    </section>
</x-app-layout>

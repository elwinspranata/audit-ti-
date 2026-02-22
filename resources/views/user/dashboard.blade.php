<x-app-layout>
    <style>
        @keyframes fadeInDown {
            0% { opacity: 0; transform: translateY(-30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInDown { animation: fadeInDown 0.8s ease-out forwards; }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }
        .animation-delay-300 { animation-delay: 0.3s; opacity: 0; }
        .animation-delay-600 { animation-delay: 0.6s; opacity: 0; }
    </style>

    <div class="min-h-screen py-8 bg-gray-100">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            {{-- Welcome Banner --}}
            <div class="relative p-8 mb-8 overflow-hidden text-white bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-700 rounded-2xl animate-fadeInDown">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid)" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                    <p class="mt-2 text-lg text-blue-100">Kelola audit TI Anda dan pantau perkembangan assessment dengan mudah.</p>
                </div>
            </div>

            {{-- Quick Actions Grid --}}
            <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3 animate-fadeInUp animation-delay-300">

                {{-- Design Factors Card --}}
                <a href="{{ route('design-factors.index') }}" class="block p-6 transition-all duration-300 bg-white shadow-md rounded-xl hover:shadow-xl hover:-translate-y-1 group">
                    <div class="flex items-center mb-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg group-hover:bg-blue-200">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Design Factors</h3>
                    <p class="mt-1 text-sm text-gray-500">Kalkulator COBIT Relative Importance</p>
                </a>

                {{-- My Assessments Card --}}
                <a href="{{ route('user.assessments.index') }}" class="block p-6 transition-all duration-300 bg-white shadow-md rounded-xl hover:shadow-xl hover:-translate-y-1 group">
                    <div class="flex items-center mb-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg group-hover:bg-green-200">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">My Assessments</h3>
                    <p class="mt-1 text-sm text-gray-500">Lihat dan kelola assessment Anda</p>
                </a>

                {{-- Progress Card --}}
                <a href="{{ route('user.progress.index') }}" class="block p-6 transition-all duration-300 bg-white shadow-md rounded-xl hover:shadow-xl hover:-translate-y-1 group">
                    <div class="flex items-center mb-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg group-hover:bg-purple-200">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Progress</h3>
                    <p class="mt-1 text-sm text-gray-500">Pantau perkembangan audit Anda</p>
                </a>

            </div>

            {{-- Info Section --}}
            <div class="p-6 bg-white shadow-md rounded-xl animate-fadeInUp animation-delay-600">
                <h2 class="mb-4 text-xl font-semibold text-gray-800">Panduan Cepat</h2>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="flex items-start p-4 rounded-lg bg-blue-50">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white bg-blue-600 rounded-full shrink-0">1</span>
                        <div>
                            <h4 class="font-medium text-gray-800">Mulai Design Factor</h4>
                            <p class="mt-1 text-sm text-gray-600">Isi kalkulator COBIT Design Factor untuk menentukan relative importance dari setiap governance objective.</p>
                        </div>
                    </div>
                    <div class="flex items-start p-4 rounded-lg bg-green-50">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white bg-green-600 rounded-full shrink-0">2</span>
                        <div>
                            <h4 class="font-medium text-gray-800">Buat Assessment</h4>
                            <p class="mt-1 text-sm text-gray-600">Buat assessment baru dan jawab kuesioner audit TI sesuai dengan kebutuhan organisasi Anda.</p>
                        </div>
                    </div>
                    <div class="flex items-start p-4 rounded-lg bg-purple-50">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white bg-purple-600 rounded-full shrink-0">3</span>
                        <div>
                            <h4 class="font-medium text-gray-800">Pantau Progress</h4>
                            <p class="mt-1 text-sm text-gray-600">Periksa perkembangan assessment Anda dan lihat hasil audit yang sudah divalidasi.</p>
                        </div>
                    </div>
                    <div class="flex items-start p-4 rounded-lg bg-amber-50">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white rounded-full bg-amber-600 shrink-0">4</span>
                        <div>
                            <h4 class="font-medium text-gray-800">Lihat Laporan</h4>
                            <p class="mt-1 text-sm text-gray-600">Setelah assessment selesai diverifikasi, unduh laporan audit resmi dalam format PDF.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

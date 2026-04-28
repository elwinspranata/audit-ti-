<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kebijakan Layanan - Audit TI</title>
    <meta name="description" content="Kebijakan Layanan Audit Teknologi Informasi menggunakan kerangka kerja COBIT 2019." />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="relative min-h-screen bg-slate-950 text-slate-200">
    <!-- Gradient Background Elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-600/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-600/20 rounded-full blur-[120px]"></div>
    </div>

    <nav class="sticky top-0 z-50 w-full border-b border-slate-800 bg-slate-950/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center font-bold text-white shadow-lg shadow-blue-500/20">A</div>
                        <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400">Audit TI</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-white hover:text-blue-400 transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-500 shadow-lg shadow-blue-500/25 transition-all active:scale-95">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
        <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-1000">
            <div class="text-center space-y-4">
                <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-white">
                    Kebijakan <span class="text-blue-500">Layanan</span>
                </h1>
                <p class="text-white text-lg opacity-90">Informasi terkait tata kelola dan operasional audit teknologi informasi.</p>
            </div>

            <div class="glass-card rounded-3xl p-8 sm:p-12 shadow-2xl space-y-8 leading-relaxed text-white">
                
                <section class="space-y-4">
                    <h2 class="text-xl font-bold text-white flex items-center space-x-3">
                        <span class="w-1.5 h-6 bg-blue-500 rounded-full"></span>
                        <span>Kerangka Kerja & Tujuan</span>
                    </h2>
                    <p>
                        Layanan audit teknologi informasi dilaksanakan menggunakan kerangka kerja <strong>COBIT 2019</strong> sebagai acuan dalam melakukan evaluasi tata kelola, manajemen risiko, pengendalian, dan efektivitas proses teknologi informasi organisasi. Pelaksanaan audit bertujuan memberikan penilaian independen terhadap tingkat kematangan (maturity), kapabilitas proses, serta rekomendasi perbaikan berdasarkan praktik terbaik yang relevan.
                    </p>
                </section>

                <section class="space-y-4">
                    <h2 class="text-xl font-bold text-white flex items-center space-x-3">
                        <span class="w-1.5 h-6 bg-blue-500 rounded-full"></span>
                        <span>Ruang Lingkup & Kerja Sama</span>
                    </h2>
                    <p>
                        Klien memahami bahwa layanan audit mencakup aktivitas asesmen, wawancara, telaah dokumen, observasi, dan analisis kontrol sesuai ruang lingkup yang disepakati pada awal penugasan. Keberhasilan pelaksanaan audit bergantung pada ketersediaan akses informasi, dokumen pendukung, dan kerja sama dari pihak klien selama proses audit berlangsung.
                    </p>
                </section>

                <section class="space-y-4">
                    <h2 class="text-xl font-bold text-white flex items-center space-x-3">
                        <span class="w-1.5 h-6 bg-blue-500 rounded-full"></span>
                        <span>Kerahasiaan Data</span>
                    </h2>
                    <p>
                        Seluruh data, informasi, dan dokumen yang diperoleh selama proses audit akan diperlakukan secara rahasia dan hanya digunakan untuk kepentingan penugasan audit. Hasil audit berupa temuan, analisis, dan rekomendasi disusun berdasarkan bukti yang tersedia pada saat audit dilakukan dan mencerminkan kondisi organisasi pada periode penilaian tersebut.
                    </p>
                </section>

                <section class="space-y-4">
                    <h2 class="text-xl font-bold text-white flex items-center space-x-3">
                        <span class="w-1.5 h-6 bg-blue-500 rounded-full"></span>
                        <span>Batasan Tanggung Jawab</span>
                    </h2>
                    <p>
                        Klien memahami bahwa audit berbasis COBIT 2019 merupakan layanan penilaian dan pemberian rekomendasi, bukan jaminan bahwa organisasi bebas dari seluruh risiko operasional, keamanan, maupun kepatuhan. Implementasi rekomendasi hasil audit sepenuhnya menjadi tanggung jawab klien, kecuali terdapat perjanjian lanjutan untuk layanan konsultasi implementasi.
                    </p>
                </section>

                <section class="space-y-4">
                    <h2 class="text-xl font-bold text-white flex items-center space-x-3">
                        <span class="w-1.5 h-6 bg-blue-500 rounded-full"></span>
                        <span>Ketentuan Umum</span>
                    </h2>
                    <p>
                        Biaya, jadwal pelaksanaan, deliverables, dan batasan tanggung jawab akan mengacu pada proposal atau perjanjian kerja sama yang disepakati bersama. Dengan menggunakan layanan ini, klien dianggap telah memahami dan menyetujui seluruh syarat dan ketentuan yang berlaku.
                    </p>
                </section>

            </div>

            <div class="text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center text-sm font-medium text-blue-500 hover:text-blue-400 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Halaman Masuk
                </a>
            </div>
        </div>
    </main>

    <footer class="py-12 border-t border-slate-800/50 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-slate-500 text-sm">&copy; {{ date('Y') }} Audit TI. Seluruh Hak Cipta Dilindungi.</p>
        </div>
    </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Menunggu Persetujuan - Audit Proses TI</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">

    <main class="grid min-h-screen place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8 dark:bg-slate-900">
        <div class="w-full max-w-lg text-center p-8 bg-white dark:bg-slate-800/70 rounded-2xl shadow-xl backdrop-blur-md">
            {{-- Ikon --}}
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-blue-100 dark:bg-sky-500/20">
                <svg class="h-8 w-8 text-blue-600 dark:text-sky-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            {{-- Judul --}}
            <h1 class="mt-6 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl dark:text-white">
                Pendaftaran Berhasil!
            </h1>

            {{-- Pesan Informasi --}}
            <p class="mt-4 text-base leading-7 text-gray-600 dark:text-gray-300">
                Akun Anda telah berhasil dibuat. Saat ini, akun Anda sedang dalam status **menunggu persetujuan** dari Admin.
            </p>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Anda akan bisa login setelah akun Anda disetujui.
            </p>

            {{-- Tombol Aksi --}}
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="{{ route('login') }}" class="rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    Kembali ke Halaman Login
                </a>
            </div>
        </div>
    </main>

</body>
</html>

{{-- resources/views/admin/progress/index.blade.php --}}

<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="p-3 shadow-lg rounded-xl bg-gradient-to-br from-blue-500 to-sky-500">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
            </div>
            <h2
                class="text-2xl font-bold text-transparent bg-gradient-to-r from-blue-600 to-sky-500 bg-clip-text animate-slideInLeft">
                {{ __('Progress Audit') }}
            </h2>
        </div>
    </x-slot>

    {{-- CSS Animasi & Styling --}}
    <style>
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInDown {
            animation: fadeInDown 0.6s ease-out forwards;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }
    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div
                class="p-6 bg-white shadow-xl sm:p-8 dark:bg-slate-800/70 dark:backdrop-blur-md dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-blue-700/30 animate-fadeInUp">
                <h3 class="mb-8 text-2xl font-bold tracking-tight text-gray-800 dark:text-sky-300">
                    Daftar Progress User
                </h3>

                @if (session('success'))
                    <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 border rounded-lg dark:bg-green-700/20 dark:text-green-300 border-green-600/30 animate-fadeInDown"
                        role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">
                    Menampilkan progress penyelesaian kuesioner oleh setiap user. Total pertanyaan saat ini:
                    <strong>{{ $totalQuestions }}</strong>.
                </p>

                <div class="overflow-x-auto shadow-lg rounded-xl dark:border dark:border-slate-700/80">
                    <table class="min-w-full">
                        <thead class="dark:bg-slate-700/80">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase border-b-2 dark:text-sky-300 dark:border-slate-600">
                                    Pengguna</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase border-b-2 dark:text-sky-300 dark:border-slate-600">
                                    Progress</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase border-b-2 dark:text-sky-300 dark:border-slate-600">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800">
                            @forelse ($users as $user)
                                <tr class="transition-colors duration-150 dark:hover:bg-slate-700/60">
                                    <td
                                        class="px-6 py-4 text-sm text-gray-800 border-b dark:text-sky-100 whitespace-nowrap dark:border-slate-700">
                                        <div class="flex flex-col">
                                            <span class="font-semibold">{{ $user->name }}</span>
                                            <span
                                                class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</span>
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-700 border-b dark:text-gray-200 whitespace-nowrap dark:border-slate-700">
                                        {{-- Progress Bar dengan Tailwind CSS --}}
                                        <div class="flex items-center gap-4">
                                            <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2.5">
                                                <div class="bg-gradient-to-r from-sky-500 to-blue-500 h-2.5 rounded-full"
                                                    style="width: {{ round($user->progress) }}%"></div>
                                            </div>
                                            <span
                                                class="font-semibold text-sky-300">{{ round($user->progress) }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 space-x-4 text-sm font-medium whitespace-nowrap">
                                        <a href="{{ route('admin.progress.show', $user) }}"
                                            class="font-semibold transition-colors duration-150 text-sky-500 hover:text-sky-400"
                                            title="Lihat Detail Progress {{ $user->name }}">
                                            Lihat Detail
                                        </a>


                                        <a href="{{ route('admin.progress.downloadPDF', $user) }}"
                                            class="font-semibold transition-colors duration-150 text-emerald-600 hover:text-emerald-500 dark:text-emerald-400 dark:hover:text-emerald-300"
                                            title="Export Laporan PDF untuk {{ $user->name }}">
                                            Export PDF
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        class="px-6 py-12 text-sm text-center text-gray-500 dark:text-slate-400 whitespace-nowrap">
                                        Tidak ada data user untuk ditampilkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination (Laravel 10+ defaultnya sudah menggunakan style Tailwind) --}}
                {{-- <div class="mt-6">
                    {{ $users->links() }}
                </div> --}}
            </div>
        </div>
    </div>
</x-admin-layout>

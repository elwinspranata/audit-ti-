<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Capability Level Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Filter Section --}}
                    <form action="{{ route('admin.report.index') }}" method="GET" class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            <div class="md:col-span-4">
                                <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih User (Unit/Organisasi)</label>
                                <select id="user_id" name="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">-- Pilih User --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ (isset($selectedUser) && $selectedUser->id == $user->id) ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-3">
                                <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dari Tanggal</label>
                                <input type="date" id="start_date" name="start_date" value="{{ $startDate ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>
                            <div class="md:col-span-3">
                                <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sampai Tanggal</label>
                                <input type="date" id="end_date" name="end_date" value="{{ $endDate ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>
                            <div class="md:col-span-2">
                                <button type="submit" class="w-full px-5 py-2.5 text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Tampilkan
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Logic Tampilan: Jika user dipilih -> Tampilkan Chart/Laporan. Jika TIDAK -> Tampilkan Tabel List User --}}
                    
                    @if(isset($selectedUser))
                        {{-- TAMPILAN LAPORAN (CHART + TABEL) --}}
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                Laporan Capability Level: <span class="font-bold text-blue-600">{{ $selectedUser->name }}</span>
                            </h3>

                            {{-- Export Buttons --}}
                            <div class="flex gap-2 mb-6">
                                <a href="{{ route('admin.report.export', ['user_id' => $selectedUser->id, 'type' => 'pdf', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Download PDF
                                </a>
                                <a href="{{ route('admin.report.export', ['user_id' => $selectedUser->id, 'type' => 'excel', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Download Excel
                                </a>
                                <a href="{{ route('admin.report.export', ['user_id' => $selectedUser->id, 'type' => 'csv', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Download CSV
                                </a>
                                {{-- Tombol Kembali ke Daftar User --}}
                                <a href="{{ route('admin.report.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Kembali ke Daftar
                                </a>
                            </div>

                            {{-- Chart Section --}}
                            <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <canvas id="capabilityChart" style="max-height: 400px;"></canvas>
                            </div>

                            {{-- Data Table --}}
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">COBIT Process</th>
                                            <th scope="col" class="px-6 py-3">Capability Level Achieved</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reportData as $data)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $data['process'] }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-1 font-semibold leading-tight text-white bg-blue-500 rounded-full dark:bg-blue-700">
                                                        Level {{ $data['level'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Chart JS Script --}}
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            const ctx = document.getElementById('capabilityChart').getContext('2d');
                            const chartData = @json($chartData);

                            new Chart(ctx, {
                                type: 'bar',
                                data: chartData,
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            max: 5,
                                            title: {
                                                display: true,
                                                text: 'Capability Level'
                                            },
                                            ticks: {
                                                stepSize: 1
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                        },
                                        title: {
                                            display: true,
                                            text: 'Capability Level per Process'
                                        }
                                    }
                                }
                            });
                        </script>
                    
                    @else
                        {{-- TAMPILAN DAFTAR PROGRESS USER (Jika belum pilih user) --}}
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 animate-fadeInUp">
                             <h3 class="mb-2 text-xl font-bold tracking-tight text-gray-800 dark:text-sky-300">
                                Daftar Progress Audit User
                            </h3>
                            <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">
                                Pilih user untuk melihat Laporan Capability Level atau klik Detail untuk melihat rincian jawaban. Total Pertanyaan: <strong>{{ $totalQuestions }}</strong>.
                            </p>

                             <div class="overflow-x-auto shadow-lg rounded-xl dark:border dark:border-slate-700/80">
                                <table class="min-w-full">
                                    <thead class="dark:bg-slate-700/80">
                                        <tr>
                                            <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase border-b-2 dark:text-sky-300 dark:border-slate-600">
                                                Pengguna
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase border-b-2 dark:text-sky-300 dark:border-slate-600">
                                                Progress
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase border-b-2 dark:text-sky-300 dark:border-slate-600">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-slate-800">
                                        @forelse ($usersForTable as $u)
                                            <tr class="transition-colors duration-150 dark:hover:bg-slate-700/60">
                                                <td class="px-6 py-4 text-sm text-gray-800 border-b dark:text-sky-100 whitespace-nowrap dark:border-slate-700">
                                                    <div class="flex flex-col">
                                                        <span class="font-semibold">{{ $u->name }}</span>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $u->email }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-700 border-b dark:text-gray-200 whitespace-nowrap dark:border-slate-700">
                                                     <div class="flex items-center gap-4">
                                                        <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2.5">
                                                            <div class="bg-gradient-to-r from-sky-500 to-blue-500 h-2.5 rounded-full"
                                                                style="width: {{ round($u->progress) }}%"></div>
                                                        </div>
                                                        <span class="font-semibold text-sky-300">{{ round($u->progress) }}%</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 space-x-2 text-sm font-medium whitespace-nowrap border-b dark:border-slate-700">
                                                    {{-- Lihat Detail Progress (Ke halaman Progress detail yang lama) --}}
                                                    <a href="{{ route('admin.progress.show', $u) }}"
                                                        class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-500 transition-colors duration-150"
                                                        title="Lihat Detail Jawaban">
                                                        Detail
                                                    </a>

                                                    {{-- Lihat Laporan (Set filter user_id ke URL ini) --}}
                                                    <a href="{{ route('admin.report.index', ['user_id' => $u->id]) }}"
                                                        class="inline-flex items-center px-3 py-1.5 bg-emerald-600 text-white rounded-md hover:bg-emerald-500 transition-colors duration-150"
                                                        title="Lihat Laporan Capability">
                                                        Laporan
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-6 py-12 text-sm text-center text-gray-500 dark:text-slate-400 whitespace-nowrap">
                                                    Tidak ada data user.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            {{-- Pagination --}}
                            <div class="mt-4">
                                {{ $usersForTable->links() }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="p-3 shadow-lg rounded-xl bg-gradient-to-br from-blue-500 to-sky-500">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-7H5m14 14H5">
                    </path>
                </svg>
            </div>
            <h2
                class="text-2xl font-bold text-transparent bg-gradient-to-r from-blue-600 to-sky-500 bg-clip-text animate-slideInLeft">
                {{ __('Manajemen Permintaan Ulang') }}
            </h2>
        </div>
    </x-slot>

    {{-- CSS Animasi & Styling --}}
    <style>
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .animate-fadeInDown {
            animation: fadeInDown .6s ease-out forwards
        }

        .animate-fadeInUp {
            animation: fadeInUp .6s ease-out forwards
        }

        .custom-select-dark {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2360a5fa' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right .5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none
        }
    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div
                class="p-6 bg-white shadow-xl sm:p-8 dark:bg-slate-800/70 dark:backdrop-blur-md dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-blue-700/30 animate-fadeInUp">
                <h3 class="mb-8 text-2xl font-bold tracking-tight text-gray-800 dark:text-sky-300">Daftar Permintaan
                </h3>

                @if (session('success'))
                    <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 border rounded-lg dark:bg-green-700/20 dark:text-green-300 border-green-600/30"
                        role="alert">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 border rounded-lg dark:bg-red-700/20 dark:text-red-300 border-red-600/30"
                        role="alert">{{ session('error') }}</div>
                @endif

                {{-- Filter Status --}}
                <div class="mb-6">
                    <form method="GET" action="{{ route('resubmissions.index') }}" class="flex items-center gap-3">
                        <label for="status_filter" class="text-sm font-semibold text-gray-700 dark:text-sky-200">Filter
                            Status:</label>
                        <select name="status" id="status_filter"
                            class="block w-auto px-4 py-2 text-sm bg-white border border-gray-300 rounded-lg shadow-sm custom-select-dark dark:bg-slate-700/80 dark:border-slate-600 focus:outline-none focus:ring-2 focus:ring-sky-500"
                            onchange="this.form.submit()">
                            <option value="all" @selected($currentStatus == 'all')>Semua</option>
                            <option value="pending" @selected($currentStatus == 'pending')>Pending</option>
                            <option value="approved" @selected($currentStatus == 'approved')>Approved</option>
                            <option value="rejected" @selected($currentStatus == 'rejected')>Rejected</option>
                            <option value="completed" @selected($currentStatus == 'completed')>Completed</option>
                        </select>
                    </form>
                </div>

                <div class="overflow-x-auto shadow-lg rounded-xl dark:border dark:border-slate-700/80">
                    <table class="min-w-full">
                        <thead class="dark:bg-slate-700/80">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase border-b-2 dark:text-sky-300 dark:border-slate-600">
                                    Pengguna</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase border-b-2 dark:text-sky-300 dark:border-slate-600">
                                    Level & Kategori</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase border-b-2 dark:text-sky-300 dark:border-slate-600">
                                    Tgl. Request</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase border-b-2 dark:text-sky-300 dark:border-slate-600">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase border-b-2 dark:text-sky-300 dark:border-slate-600">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800">
                            @forelse ($requests as $req)
                                <tr class="transition-colors duration-150 dark:hover:bg-slate-700/60">
                                    <td
                                        class="px-6 py-4 text-sm text-gray-800 border-b dark:text-sky-100 whitespace-nowrap dark:border-slate-700">
                                        {{ $req->user->name ?? 'N/A' }}</td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-700 border-b dark:text-gray-200 whitespace-nowrap dark:border-slate-700">
                                        {{ $req->level->nama_level ?? 'N/A' }}
                                        <span
                                            class="block text-xs text-gray-500 dark:text-gray-400">{{ $req->level->kategori->nama ?? 'N/A' }}</span>
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-600 border-b dark:text-gray-300 whitespace-nowrap dark:border-slate-700">
                                        {{ $req->requested_at->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 border-b whitespace-nowrap dark:border-slate-700">
                                        <span
                                            class="inline-flex px-3 py-1 text-xs font-semibold leading-5 border rounded-full
                                            {{ $req->status == 'pending' ? 'text-amber-700 bg-amber-100 dark:bg-amber-500/20 dark:text-amber-300 border-amber-500/30' : '' }}
                                            {{ $req->status == 'approved' ? 'text-emerald-700 bg-emerald-100 dark:bg-emerald-500/20 dark:text-emerald-300 border-emerald-500/30' : '' }}
                                            {{ $req->status == 'rejected' ? 'text-red-700 bg-red-100 dark:bg-red-500/20 dark:text-red-300 border-red-500/30' : '' }}
                                            {{ $req->status == 'completed' ? 'text-sky-700 bg-sky-100 dark:bg-sky-500/20 dark:text-sky-300 border-sky-500/30' : '' }}">
                                            {{ ucfirst($req->status) }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 space-x-4 text-sm font-medium border-b whitespace-nowrap dark:border-slate-700">
                                        @if ($req->status == 'pending')
                                            <form action="{{ route('resubmissions.approve', $req->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="font-semibold transition-colors duration-150 text-emerald-600 hover:text-emerald-500 dark:text-emerald-400 dark:hover:text-emerald-300">Approve</button>
                                            </form>
                                            <button type="button"
                                                onclick="openRejectModal({{ $req->id }}, '{{ addslashes($req->user->name) }}', '{{ addslashes($req->level->nama_level) }}')"
                                                class="font-semibold text-red-600 transition-colors duration-150 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300">
                                                Reject
                                            </button>
                                        @else
                                            <span class="text-gray-400 dark:text-slate-500">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="px-6 py-12 text-sm text-center text-gray-500 dark:text-slate-400">Tidak
                                        ada permintaan yang cocok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $requests->links() }}</div>
            </div>
        </div>
    </div>

    {{-- Modal untuk Reject dengan Catatan --}}
    <div id="rejectModal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-slate-900/80 backdrop-blur-sm">
        <div
            class="w-full max-w-md p-6 mx-4 bg-white shadow-2xl dark:bg-gradient-to-br dark:from-slate-800 dark:to-blue-950/90 rounded-xl dark:border dark:border-sky-700/50">
            <h3 class="mb-5 text-xl font-bold text-gray-800 dark:text-sky-300">Tolak Permintaan</h3>
            <form id="rejectForm" method="POST" action="">
                @csrf
                <p class="mb-4 text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                    Anda akan menolak permintaan dari <strong id="rejectUserName"
                        class="font-semibold text-sky-300"></strong> untuk level <strong id="rejectLevelName"
                        class="font-semibold text-sky-300"></strong>.
                </p>
                <div>
                    <label for="admin_notes"
                        class="block mb-1 text-sm font-semibold text-gray-700 dark:text-sky-200">Catatan
                        (Opsional):</label>
                    <textarea name="admin_notes" id="admin_notes" rows="3"
                        class="block w-full mt-1 text-sm transition-colors duration-150 border-gray-300 rounded-lg shadow-sm dark:border-slate-600 dark:bg-slate-700/50 dark:text-gray-100 focus:border-sky-500 focus:ring-sky-500"></textarea>
                </div>
                <div class="flex justify-end mt-8 space-x-4">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-5 py-2 text-sm font-medium text-gray-800 bg-gray-200 rounded-lg shadow-sm dark:text-gray-200 dark:bg-slate-600 hover:bg-gray-300 dark:hover:bg-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-500">Batal</button>
                    <button type="submit"
                        class="px-5 py-2 text-sm font-medium text-white bg-red-600 rounded-lg shadow-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Tolak
                        Permintaan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const rejectModal = document.getElementById('rejectModal');
        const rejectForm = document.getElementById('rejectForm');
        const rejectUserName = document.getElementById('rejectUserName');
        const rejectLevelName = document.getElementById('rejectLevelName');

        function openRejectModal(requestId, userName, levelName) {
            // Membuat URL template menggunakan helper route() dari Blade
            let urlTemplate = "{{ route('resubmissions.reject', ['resubmissionRequest' => ':id']) }}";
            // Mengganti placeholder :id dengan requestId yang sebenarnya
            let actionUrl = urlTemplate.replace(':id', requestId);

            if (rejectForm) {
                rejectForm.action = actionUrl;
            }
            if (rejectUserName) rejectUserName.textContent = userName;
            if (rejectLevelName) rejectLevelName.textContent = levelName;
            if (rejectModal) rejectModal.classList.remove('hidden');
        }

        function closeRejectModal() {
            if (rejectModal) rejectModal.classList.add('hidden');
        }
    </script>
</x-admin-layout>

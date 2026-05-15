<x-admin-layout>
    <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white bg-clip-text text-transparent bg-gradient-to-r from-sky-400 via-sky-300 to-cyan-400">
                    Jenis Layanan
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola deskripsi layanan yang ditampilkan di halaman pricing</p>
            </div>
            <a href="{{ route('admin.service-types.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Layanan
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-400/10 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-400/10 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-white/80 backdrop-blur-md dark:bg-slate-800/80 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl overflow-hidden">
            @if($serviceTypes->count() > 0)
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 dark:text-gray-400 uppercase bg-gray-50 dark:bg-slate-900/50">
                        <tr>
                            <th class="px-6 py-4">Urutan</th>
                            <th class="px-6 py-4">Label</th>
                            <th class="px-6 py-4">Judul</th>
                            <th class="px-6 py-4">Fitur</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @foreach($serviceTypes as $service)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                                    {{ $service->sort_order }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-400/10 text-indigo-600 dark:text-indigo-300 text-xs font-bold">
                                        {{ $service->label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-800 dark:text-gray-200 font-medium max-w-xs truncate">
                                    {{ $service->title }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    {{ is_array($service->features) ? count($service->features) : 0 }} fitur
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.service-types.toggle-active', $service) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold transition-colors {{ $service->is_active ? 'bg-green-100 dark:bg-green-400/10 text-green-700 dark:text-green-300 hover:bg-green-200' : 'bg-red-100 dark:bg-red-400/10 text-red-700 dark:text-red-300 hover:bg-red-200' }}">
                                            {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.service-types.edit', $service) }}"
                                           class="inline-flex items-center p-2 text-sky-600 dark:text-sky-400 bg-sky-50 dark:bg-sky-400/10 rounded-lg hover:bg-sky-100 dark:hover:bg-sky-400/20 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('admin.service-types.destroy', $service) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center p-2 text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-400/10 rounded-lg hover:bg-red-100 dark:hover:bg-red-400/20 transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-16 text-gray-400 dark:text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <p class="text-lg font-medium">Belum ada jenis layanan</p>
                    <p class="mt-1">Klik "Tambah Layanan" untuk menambahkan jenis layanan baru.</p>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>

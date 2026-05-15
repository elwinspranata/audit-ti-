<x-admin-layout>
    <div class="py-12 mx-auto max-w-4xl sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('admin.service-types.index') }}" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-sky-500 dark:hover:text-sky-400 transition-colors mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Daftar Layanan
            </a>
            <h2 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-sky-400 via-sky-300 to-cyan-400">
                Edit: {{ $serviceType->title }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Ubah deskripsi layanan</p>
        </div>

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-400/10 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.service-types.update', $serviceType) }}" method="POST" id="serviceForm">
            @csrf
            @method('PUT')
            @include('admin.service-types._form', ['serviceType' => $serviceType])
        </form>
    </div>
</x-admin-layout>

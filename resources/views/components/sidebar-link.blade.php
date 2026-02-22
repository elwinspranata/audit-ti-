@props(['active'])

@php
    // Kelas dasar yang berlaku untuk semua link sidebar
    $baseClasses =
        'flex items-center px-4 py-2 text-sm font-medium rounded-md group transition-all duration-200 ease-in-out';

    // Kelas spesifik untuk link yang AKTIF
    $activeClasses =
        'text-white shadow-lg shadow-blue-500/50 bg-gradient-to-r from-sky-500 to-blue-600 transform hover:scale-105';

    // Kelas spesifik untuk link yang TIDAK AKTIF
    $inactiveClasses =
        'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white';

    // Gabungkan kelas dasar dengan kelas aktif atau tidak aktif
    $classes = $baseClasses . ' ' . ($active ?? false ? $activeClasses : $inactiveClasses);
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

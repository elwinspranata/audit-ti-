<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Package::create([
            'name' => 'Paket Assessment DF',
            'price' => 5000000,
            'level' => 1,
            'description' => "Akses Audit Dasar\nLaporan Standar\nSupport Email",
            'duration_days' => 30,
        ]);

        \App\Models\Package::create([
            'name' => 'Audit Internal',
            'price' => 20000000,
            'level' => 2,
            'description' => "Akses Semua Modul Audit\nLaporan Lengkap (PDF)\nPrioritas Support",
            'duration_days' => 90,
        ]);

        \App\Models\Package::create([
            'name' => 'Paket External',
            'price' => 50000000,
            'level' => 3,
            'description' => "Akses Full Unlimited\nKonsultasi Audit\nLaporan Kustom",
            'duration_days' => 365,
        ]);
    }
}

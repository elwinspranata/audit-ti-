<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Level;
use App\Models\Jawaban;
use App\Models\Kategori;
use App\Models\CobitItem;
use App\Models\Quisioner;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminUserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            PackageSeeder::class,
            CobitDataSeeder::class,
            CouponSeeder::class,
        ]);

        // // Seeder untuk CobitItem
        // CobitItem::create([
        //     'nama_item' => 'Governance',
        //     'deskripsi' => 'This is the description of Governance item.',
        // ]);

        // CobitItem::create([
        //     'nama_item' => 'Management',
        //     'deskripsi' => 'This is the description of Management item.',
        // ]);

        // // Seeder untuk Kategori
        // Kategori::create([
        //     'nama' => 'Category 1',
        //     'cobit_item_id' => 1, // CobitItem ID untuk Governance
        // ]);

        // Kategori::create([
        //     'nama' => 'Category 2',
        //     'cobit_item_id' => 1, // CobitItem ID untuk Governance
        // ]);

        // Kategori::create([
        //     'nama' => 'Category 3',
        //     'cobit_item_id' => 2, // CobitItem ID untuk Management
        // ]);

        // // Seeder untuk Level
        // // Menambahkan data level pertama dengan level_number
        // Level::create([
        //     'nama_level' => 'Level 1',
        //     'kategori_id' => 1, // Pastikan kategori_id ada di tabel kategori
        //     'level_number' => 1, // Menambahkan level_number
        // ]);

        // Level::create([
        //     'nama_level' => 'Level 2',
        //     'kategori_id' => 1, // Pastikan kategori_id ada di tabel kategori
        //     'level_number' => 2, // Menambahkan level_number
        // ]);

        // Level::create([
        //     'nama_level' => 'Level 1',
        //     'kategori_id' => 2, // Pastikan kategori_id ada di tabel kategori
        //     'level_number' => 1, // Menambahkan level_number
        // ]);

        // Level::create([
        //     'nama_level' => 'Level 2',
        //     'kategori_id' => 2, // Pastikan kategori_id ada di tabel kategori
        //     'level_number' => 2, // Menambahkan level_number
        // ]);

        // // Seeder untuk Quisioner
        // Quisioner::create([
        //     'pertanyaan' => 'What is your opinion on Governance?',
        //     'level_id' => 1, // Level ID untuk Level 1
        // ]);

        // Quisioner::create([
        //     'pertanyaan' => 'How do you rate Management in your organization?',
        //     'level_id' => 1, // Level ID untuk Level 1
        // ]);

        // Quisioner::create([
        //     'pertanyaan' => 'Do you believe in the importance of Strategy?',
        //     'level_id' => 2, // Level ID untuk Level 2
        // ]);

        // Quisioner::create([
        //     'pertanyaan' => 'Do you find it easy to manage resources?',
        //     'level_id' => 2, // Level ID untuk Level 2
        // ]);


    }
}

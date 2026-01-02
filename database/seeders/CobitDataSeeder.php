<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CobitItem;
use App\Models\Kategori;
use App\Models\Level;
use App\Models\Quisioner;
use Illuminate\Support\Facades\DB;

class CobitDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Nonaktifkan pengecekan foreign key untuk sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel untuk menghindari duplikasi data saat seeder dijalankan ulang
        CobitItem::truncate();
        Kategori::truncate();
        Level::truncate();
        Quisioner::truncate();

        // Data yang akan di-seed
        $data = [
            [
                'nama_item' => 'EDM01',
                'deskripsi' => 'Ensured Governance Framework Setting and Maintenance. Provide a consistent approach integrated and aligned with the enterprise governance approach.',
                'required_level' => 3,
                'is_visible' => true,
                'kategoris' => [
                    [
                        'nama' => 'EDM01.01 - Evaluate the Governance System',
                        'levels' => [
                            ['level_number' => 1, 'nama_level' => 'Level 1: Initial', 'pertanyaan' => ['Is the governance system evaluated regularly?']],
                            ['level_number' => 2, 'nama_level' => 'Level 2: Managed', 'pertanyaan' => ['Is the governance system documented and communicated?']],
                        ]
                    ],
                ]
            ],
            [
                'nama_item' => 'APO01',
                'deskripsi' => 'Managed I&T Management Framework. This process ensures that the I&T management framework is aligned with the enterprise’s overall governance framework.',
                'required_level' => 1,
                'is_visible' => true,
                'kategoris' => [
                    [
                        'nama' => 'APO01.01 - Define the Management Framework',
                        'levels' => [
                            ['level_number' => 1, 'nama_level' => 'Level 1: Initial/Ad Hoc', 'pertanyaan' => ['Pertanyaan untuk APO01.01 Level 1.']],
                            ['level_number' => 2, 'nama_level' => 'Level 2: Managed', 'pertanyaan' => ['Pertanyaan untuk APO01.01 Level 2.']],
                            ['level_number' => 3, 'nama_level' => 'Level 3: Established', 'pertanyaan' => ['Pertanyaan untuk APO01.01 Level 3.']],
                            ['level_number' => 4, 'nama_level' => 'Level 4: Predictable', 'pertanyaan' => ['Pertanyaan untuk APO01.01 Level 4.']],
                            ['level_number' => 5, 'nama_level' => 'Level 5: Optimizing', 'pertanyaan' => ['Pertanyaan untuk APO01.01 Level 5.']],
                        ]
                    ],
                ]
            ],
            [
                'nama_item' => 'APO02',
                'deskripsi' => 'Managed Strategy. Provide a holistic view of the current business and I&T environment, the future direction, and the initiatives required to migrate to the desired future environment.',
                'required_level' => 2,
                'is_visible' => true,
                'kategoris' => [
                    [
                        'nama' => 'APO02.01 - Understand Enterprise Strategy',
                        'levels' => [
                            ['level_number' => 2, 'nama_level' => 'Level 2: Managed', 'pertanyaan' => ['Is the enterprise strategy understood by I&T?']],
                        ]
                    ],
                ]
            ],
            [
                'nama_item' => 'BAI01',
                'deskripsi' => 'Managed Programs and Projects. Manage all programs and projects from the investment portfolio in alignment with enterprise strategy.',
                'required_level' => 3,
                'is_visible' => true,
                'kategoris' => [
                    [
                        'nama' => 'BAI01.01 - Maintain a Standard Approach to Program/Project Management',
                        'levels' => [
                            ['level_number' => 3, 'nama_level' => 'Level 3: Established', 'pertanyaan' => ['Is there a standard approach for project management?']],
                        ]
                    ],
                ]
            ],
            [
                'nama_item' => 'BAI03',
                'deskripsi' => 'Managed Solutions Identification and Build. This process ensures that business requirements are translated into effective and efficient solutions.',
                'required_level' => 1,
                'is_visible' => true,
                'kategoris' => [
                    [
                        'nama' => 'BAI03.01 - Design High-Level Solutions',
                        'levels' => [
                            ['level_number' => 1, 'nama_level' => 'Level 1: Initial', 'pertanyaan' => ['Apakah desain solusi tingkat tinggi sudah dibuat berdasarkan kebutuhan bisnis?']],
                            ['level_number' => 2, 'nama_level' => 'Level 2: Managed', 'pertanyaan' => ['Apakah desain solusi yang detail dikembangkan dan didokumentasikan?']],
                        ]
                    ],
                ]
            ],
            [
                'nama_item' => 'DSS01',
                'deskripsi' => 'Managed Operations. Coordinate and execute the activities and operational procedures required to deliver internal and outsourced I&T services.',
                'required_level' => 2,
                'is_visible' => true,
                'kategoris' => [
                    [
                        'nama' => 'DSS01.01 - Perform Operational Procedures',
                        'levels' => [
                            ['level_number' => 2, 'nama_level' => 'Level 2: Managed', 'pertanyaan' => ['Are operational procedures performed correctly?']],
                        ]
                    ],
                ]
            ],
            [
                'nama_item' => 'MEA01',
                'deskripsi' => 'Managed Performance and Conformance Monitoring. Collect, validate and evaluate business, IT and process goals and metrics.',
                'required_level' => 3,
                'is_visible' => true,
                'kategoris' => [
                    [
                        'nama' => 'MEA01.01 - Establish a Monitoring Approach',
                        'levels' => [
                            ['level_number' => 3, 'nama_level' => 'Level 3: Established', 'pertanyaan' => ['Is there a structured monitoring approach?']],
                        ]
                    ],
                ]
            ],

        ];

        // Looping untuk memasukkan data
        foreach ($data as $itemData) {
            // Buat CobitItem
            $cobitItem = CobitItem::create([
                'nama_item' => $itemData['nama_item'],
                'deskripsi' => $itemData['deskripsi'],
                'required_level' => $itemData['required_level'],
                'is_visible' => $itemData['is_visible'],
            ]);

            foreach ($itemData['kategoris'] as $kategoriData) {
                // Buat Kategori yang berelasi dengan CobitItem
                $kategori = $cobitItem->kategoris()->create([
                    'nama' => $kategoriData['nama'],
                ]);

                foreach ($kategoriData['levels'] as $levelData) {
                    // Buat Level yang berelasi dengan Kategori
                    $level = $kategori->levels()->create([
                        'level_number' => $levelData['level_number'],
                        'nama_level' => $levelData['nama_level'],
                    ]);

                    foreach ($levelData['pertanyaan'] as $pertanyaan) {
                        // Buat Quisioner yang berelasi dengan Level
                        $level->quisioners()->create([
                            'pertanyaan' => $pertanyaan,
                        ]);
                    }
                }
            }
        }

        // Aktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

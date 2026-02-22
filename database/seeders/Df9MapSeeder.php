<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Df9Map;

class Df9MapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mappings = [
            // EDM
            ['objective_code' => 'EDM01', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'EDM02', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'EDM03', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'EDM04', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'EDM05', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],

            // APO
            ['objective_code' => 'APO01', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'APO02', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'APO03', 'agile' => 1.0, 'devops' => 2.0, 'traditional' => 1.0],
            ['objective_code' => 'APO04', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'APO05', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'APO06', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'APO07', 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
            ['objective_code' => 'APO08', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'APO09', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'APO10', 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
            ['objective_code' => 'APO11', 'agile' => 1.5, 'devops' => 1.5, 'traditional' => 1.0],
            ['objective_code' => 'APO12', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'APO13', 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
            ['objective_code' => 'APO14', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],

            // BAI
            ['objective_code' => 'BAI01', 'agile' => 2.0, 'devops' => 1.5, 'traditional' => 1.0],
            ['objective_code' => 'BAI02', 'agile' => 3.5, 'devops' => 2.0, 'traditional' => 1.0],
            ['objective_code' => 'BAI03', 'agile' => 1.0, 'devops' => 3.0, 'traditional' => 1.0],
            ['objective_code' => 'BAI04', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'BAI05', 'agile' => 2.5, 'devops' => 1.5, 'traditional' => 1.0],
            ['objective_code' => 'BAI06', 'agile' => 3.5, 'devops' => 2.0, 'traditional' => 1.0],
            ['objective_code' => 'BAI07', 'agile' => 2.5, 'devops' => 2.5, 'traditional' => 1.0],
            ['objective_code' => 'BAI08', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'BAI09', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'BAI10', 'agile' => 1.5, 'devops' => 2.0, 'traditional' => 1.0],
            ['objective_code' => 'BAI11', 'agile' => 2.5, 'devops' => 1.0, 'traditional' => 1.0],

            // DSS
            ['objective_code' => 'DSS01', 'agile' => 1.0, 'devops' => 2.5, 'traditional' => 1.0],
            ['objective_code' => 'DSS02', 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
            ['objective_code' => 'DSS03', 'agile' => 1.0, 'devops' => 1.5, 'traditional' => 1.0],
            ['objective_code' => 'DSS04', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'DSS05', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'DSS06', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],

            // MEA
            ['objective_code' => 'MEA01', 'agile' => 1.5, 'devops' => 1.5, 'traditional' => 1.0],
            ['objective_code' => 'MEA02', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'MEA03', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
            ['objective_code' => 'MEA04', 'agile' => 1.0, 'devops' => 1.0, 'traditional' => 1.0],
        ];

        foreach ($mappings as $mapping) {
            Df9Map::create($mapping);
        }
    }
}

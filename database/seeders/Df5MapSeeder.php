<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Df5Map;

class Df5MapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Values extracted from DF5map table (image 3)
     */
    public function run(): void
    {
        $df5MapData = [
            ['objective_code' => 'EDM01', 'high_value' => 3.0, 'normal_value' => 1.0],
            ['objective_code' => 'EDM02', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'EDM03', 'high_value' => 4.0, 'normal_value' => 1.0],
            ['objective_code' => 'EDM04', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'EDM05', 'high_value' => 2.0, 'normal_value' => 1.0],
            ['objective_code' => 'APO01', 'high_value' => 3.0, 'normal_value' => 1.0],
            ['objective_code' => 'APO02', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'APO03', 'high_value' => 3.0, 'normal_value' => 1.0],
            ['objective_code' => 'APO04', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'APO05', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'APO06', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'APO07', 'high_value' => 2.0, 'normal_value' => 1.0],
            ['objective_code' => 'APO08', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'APO09', 'high_value' => 2.0, 'normal_value' => 1.0],
            ['objective_code' => 'APO10', 'high_value' => 3.0, 'normal_value' => 1.0],
            ['objective_code' => 'APO11', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'APO12', 'high_value' => 2.0, 'normal_value' => 1.0],
            ['objective_code' => 'APO13', 'high_value' => 4.0, 'normal_value' => 1.0],
            ['objective_code' => 'APO14', 'high_value' => 3.0, 'normal_value' => 1.0],
            ['objective_code' => 'BAI01', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'BAI02', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'BAI03', 'high_value' => 2.0, 'normal_value' => 1.0],
            ['objective_code' => 'BAI04', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'BAI05', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'BAI06', 'high_value' => 3.0, 'normal_value' => 1.0],
            ['objective_code' => 'BAI07', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'BAI08', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'BAI09', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'BAI10', 'high_value' => 3.0, 'normal_value' => 1.0],
            ['objective_code' => 'BAI11', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'DSS01', 'high_value' => 1.0, 'normal_value' => 1.0],
            ['objective_code' => 'DSS02', 'high_value' => 3.0, 'normal_value' => 1.0],
            ['objective_code' => 'DSS03', 'high_value' => 2.0, 'normal_value' => 1.0],
            ['objective_code' => 'DSS04', 'high_value' => 4.0, 'normal_value' => 1.0],
            ['objective_code' => 'DSS05', 'high_value' => 4.0, 'normal_value' => 1.0],
            ['objective_code' => 'DSS06', 'high_value' => 3.0, 'normal_value' => 1.0],
            ['objective_code' => 'MEA01', 'high_value' => 3.0, 'normal_value' => 1.0],
            ['objective_code' => 'MEA02', 'high_value' => 2.0, 'normal_value' => 1.0],
            ['objective_code' => 'MEA03', 'high_value' => 3.0, 'normal_value' => 1.0],
            ['objective_code' => 'MEA04', 'high_value' => 3.0, 'normal_value' => 1.0],
        ];

        foreach ($df5MapData as $data) {
            Df5Map::updateOrCreate(
                ['objective_code' => $data['objective_code']],
                $data
            );
        }
    }
}

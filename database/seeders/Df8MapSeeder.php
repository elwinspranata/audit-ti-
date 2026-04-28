<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Df8Map;

class Df8MapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $objectives = [
            'EDM01',
            'EDM02',
            'EDM03',
            'EDM04',
            'EDM05',
            'APO01',
            'APO02',
            'APO03',
            'APO04',
            'APO05',
            'APO06',
            'APO07',
            'APO08',
            'APO09',
            'APO10',
            'APO11',
            'APO12',
            'APO13',
            'APO14',
            'BAI01',
            'BAI02',
            'BAI03',
            'BAI04',
            'BAI05',
            'BAI06',
            'BAI07',
            'BAI08',
            'BAI09',
            'BAI10',
            'BAI11',
            'DSS01',
            'DSS02',
            'DSS03',
            'DSS04',
            'DSS05',
            'DSS06',
            'MEA01',
            'MEA02',
            'MEA03',
            'MEA04'
        ];

        foreach ($objectives as $code) {
            $outsourcing = 1.0;
            $cloud = 1.0;
            $insourcing = 1.0;

            if ($code === 'EDM03') {
                $cloud = 2.0;
            } elseif ($code === 'APO09' || $code === 'APO10') {
                $outsourcing = 4.0;
                $cloud = 4.0;
            } elseif ($code === 'APO12') {
                $outsourcing = 2.0;
                $cloud = 2.0;
            } elseif ($code === 'MEA01') {
                $outsourcing = 3.0;
                $cloud = 3.0;
            }

            Df8Map::updateOrCreate(
                ['objective_code' => $code],
                [
                    'outsourcing' => $outsourcing,
                    'cloud' => $cloud,
                    'insourcing' => $insourcing,
                ]
            );
        }
    }
}

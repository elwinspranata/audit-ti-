<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Df10MapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['objective_code' => 'EDM01', 'first_mover' => 3.5, 'follower' => 2.5, 'slow_adopter' => 1.5],
            ['objective_code' => 'EDM02', 'first_mover' => 4.0, 'follower' => 2.5, 'slow_adopter' => 1.5],
            ['objective_code' => 'EDM03', 'first_mover' => 1.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'EDM04', 'first_mover' => 2.5, 'follower' => 2.0, 'slow_adopter' => 1.5],
            ['objective_code' => 'EDM05', 'first_mover' => 1.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'APO01', 'first_mover' => 2.5, 'follower' => 1.5, 'slow_adopter' => 1.0],
            ['objective_code' => 'APO02', 'first_mover' => 4.0, 'follower' => 3.0, 'slow_adopter' => 1.5],
            ['objective_code' => 'APO03', 'first_mover' => 2.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'APO04', 'first_mover' => 4.0, 'follower' => 3.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'APO05', 'first_mover' => 4.0, 'follower' => 2.5, 'slow_adopter' => 1.0],
            ['objective_code' => 'APO06', 'first_mover' => 1.0, 'follower' => 1.5, 'slow_adopter' => 1.0],
            ['objective_code' => 'APO07', 'first_mover' => 2.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'APO08', 'first_mover' => 3.0, 'follower' => 1.5, 'slow_adopter' => 1.0],
            ['objective_code' => 'APO09', 'first_mover' => 1.5, 'follower' => 1.5, 'slow_adopter' => 1.0],
            ['objective_code' => 'APO10', 'first_mover' => 2.5, 'follower' => 1.5, 'slow_adopter' => 1.0],
            ['objective_code' => 'APO11', 'first_mover' => 1.5, 'follower' => 1.5, 'slow_adopter' => 1.0],
            ['objective_code' => 'APO12', 'first_mover' => 2.0, 'follower' => 1.5, 'slow_adopter' => 1.0],
            ['objective_code' => 'APO13', 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'APO14', 'first_mover' => 2.5, 'follower' => 2.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'BAI01', 'first_mover' => 4.0, 'follower' => 3.0, 'slow_adopter' => 1.5],
            ['objective_code' => 'BAI02', 'first_mover' => 3.5, 'follower' => 2.5, 'slow_adopter' => 1.0],
            ['objective_code' => 'BAI03', 'first_mover' => 4.0, 'follower' => 2.5, 'slow_adopter' => 1.0],
            ['objective_code' => 'BAI04', 'first_mover' => 1.5, 'follower' => 1.5, 'slow_adopter' => 1.0],
            ['objective_code' => 'BAI05', 'first_mover' => 3.0, 'follower' => 2.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'BAI06', 'first_mover' => 2.5, 'follower' => 2.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'BAI07', 'first_mover' => 3.5, 'follower' => 2.5, 'slow_adopter' => 1.0],
            ['objective_code' => 'BAI08', 'first_mover' => 1.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'BAI09', 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'BAI10', 'first_mover' => 1.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'BAI11', 'first_mover' => 3.5, 'follower' => 2.5, 'slow_adopter' => 1.0],
            ['objective_code' => 'DSS01', 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'DSS02', 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'DSS03', 'first_mover' => 1.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'DSS04', 'first_mover' => 1.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'DSS05', 'first_mover' => 1.5, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'DSS06', 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'MEA01', 'first_mover' => 3.0, 'follower' => 2.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'MEA02', 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'MEA03', 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
            ['objective_code' => 'MEA04', 'first_mover' => 1.0, 'follower' => 1.0, 'slow_adopter' => 1.0],
        ];

        DB::table('df10_map')->insert($data);
    }
}

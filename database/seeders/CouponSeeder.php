<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::create([
            'code' => 'DISKON5',
            'type' => 'percentage',
            'value' => 5,
            'is_active' => true,
            'usage_limit' => 100,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(1),
        ]);

        Coupon::create([
            'code' => 'AUDIT10',
            'type' => 'percentage',
            'value' => 10,
            'is_active' => true,
            'usage_limit' => 50,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(1),
        ]);

        Coupon::create([
            'code' => 'HEMAT50RB',
            'type' => 'fixed',
            'value' => 50000,
            'is_active' => true,
            'usage_limit' => 10,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(1),
        ]);
    }
}

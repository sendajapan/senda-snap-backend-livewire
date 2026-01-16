<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        // Create default vendor (AUTOCRAFT JAPAN LTD)
        Vendor::firstOrCreate(
            ['email' => 'info@autocraftjapan.com'],
            [
                'name' => 'AUTOCRAFT JAPAN LTD',
                'phone' => '03-5826-7885',
                'address' => '〒110-0015 Tokyo, Taito City, Higashiueno, 3 Chome−18−7 上野駅前ビル 8F',
                'website' => 'https://autocraftjapan.com',
                'status' => 'active',
            ]
        );

        // more vendors (total 9)
        Vendor::factory()->count(9)->create();
    }
}

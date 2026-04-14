<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        // If there is already at least one vendor, do not seed or modify vendor data.
        // This keeps existing vendor records intact when running seeders on a live database.
        if (Vendor::query()->exists()) {
            return;
        }

        // Create default vendor (AUTOCRAFT JAPAN LTD)
        Vendor::firstOrCreate(
            ['email' => 'info@autocraftjapan.com'],
            [
                'name' => 'AUTOCRAFT JAPAN LTD',
                'phone' => '03-5826-7885',
                'address' => '〒110-0015 Tokyo, Taito City, Higashiueno, 3 Chome-18-7 上野駅前ビル 8F',
                'website' => 'https://autocraftjapan.com',
                'status' => 'active',
                // External vehicle database configuration
                'external_db_host' => env('REMOTE_DB_HOST', 'senda.us'),
                'external_db_port' => env('REMOTE_DB_PORT', '3306'),
                'external_db_database' => env('REMOTE_DB_DATABASE', 'avis_03oct'),
                'external_db_username' => env('REMOTE_DB_USERNAME', 'sendajapan1'),
                'external_db_password' => env('REMOTE_DB_PASSWORD', 'sulaiman007'),
                'external_image_path' => '/home/kono/public_html/autocraft/avisnew/images/veh_images/',
                'external_image_base_url' => 'https://senda.us/autocraft/avisnew/images/veh_images/',
            ]
        );
    }
}

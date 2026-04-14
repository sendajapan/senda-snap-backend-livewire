<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            VendorSeeder::class,          // 100 vendors (including AUTOCRAFT JAPAN LTD)
            UserSeeder::class,
            PortSeeder::class,            // 100 ports
            ShipLineSeeder::class,        // Ship lines from JSON
            TaskSeeder::class,
        ]);
    }
}

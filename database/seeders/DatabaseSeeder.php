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
            ShippingCompanySeeder::class, // 100 shipping companies
            TaskSeeder::class,
        ]);
    }
}

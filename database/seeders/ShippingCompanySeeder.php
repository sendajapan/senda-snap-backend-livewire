<?php

namespace Database\Seeders;

use App\Models\ShippingCompany;
use Illuminate\Database\Seeder;

class ShippingCompanySeeder extends Seeder
{
    public function run(): void
    {
        // Create 100 shipping companies
        ShippingCompany::factory()->count(100)->create();
    }
}

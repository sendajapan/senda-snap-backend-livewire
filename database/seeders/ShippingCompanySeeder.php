<?php

namespace Database\Seeders;

use App\Models\ShippingCompany;
use App\Models\User;
use Illuminate\Database\Seeder;

class ShippingCompanySeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('seeders/tbl_companies.json');

        if (! file_exists($jsonPath)) {
            $this->command?->warn('tbl_companies.json not found. Skipping ShippingCompanySeeder JSON import.');

            return;
        }

        $content = file_get_contents($jsonPath);

        if ($content === false) {
            $this->command?->error('Unable to read tbl_companies.json. Skipping ShippingCompanySeeder JSON import.');

            return;
        }

        $companies = json_decode($content, true);

        if (! is_array($companies)) {
            $this->command?->error('Failed to decode tbl_companies.json. Skipping ShippingCompanySeeder JSON import.');

            return;
        }

        $validTypes = ['Transporter', 'Shipping Line', 'Workshop', 'PROVIDER', 'EXPENSE', 'COURIER'];
        $validStatuses = ['Active', 'Inactive'];

        $imported = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($companies as $company) {
            $name = isset($company['company_name']) ? trim((string) $company['company_name']) : '';
            $type = isset($company['company_type']) ? trim((string) $company['company_type']) : '';
            $status = isset($company['company_status']) ? trim((string) $company['company_status']) : 'Active';

            if ($name === '' || ! in_array($type, $validTypes, true) || ! in_array($status, $validStatuses, true)) {
                $skipped++;

                continue;
            }

            $companyNameJp = isset($company['company_name_jp']) && $company['company_name_jp'] !== '' ? $company['company_name_jp'] : null;

            $perM3 = isset($company['per_m3']) ? (int) $company['per_m3'] : null;
            if ($perM3 === 0) {
                $perM3 = null;
            }

            $perContainer = isset($company['per_container']) ? (int) $company['per_container'] : null;
            if ($perContainer === 0) {
                $perContainer = null;
            }

            $zip = isset($company['zip']) && trim((string) $company['zip']) !== '' ? trim((string) $company['zip']) : null;
            $countryName = isset($company['country_name']) && trim((string) $company['country_name']) !== '' ? trim((string) $company['country_name']) : null;
            $state = isset($company['state']) && trim((string) $company['state']) !== '' ? trim((string) $company['state']) : null;
            $city = isset($company['city']) && trim((string) $company['city']) !== '' ? trim((string) $company['city']) : null;
            $address = isset($company['address']) && trim((string) $company['address']) !== '' ? trim((string) $company['address']) : null;

            // Map added_by -> created_by (use null if 0 or user does not exist)
            $addedById = isset($company['added_by']) ? (int) $company['added_by'] : 0;
            $createdBy = null;

            if ($addedById > 0) {
                $user = User::find($addedById);
                if ($user !== null) {
                    $createdBy = $user->id;
                }
            }

            $data = [
                'company_type' => $type,
                'company_status' => $status,
                'company_name_jp' => $companyNameJp,
                'per_m3' => $perM3,
                'per_container' => $perContainer,
                'zip' => $zip,
                'country_name' => $countryName,
                'state' => $state,
                'city' => $city,
                'address' => $address,
                'created_by' => $createdBy,
            ];

            $sc = ShippingCompany::updateOrCreate(
                ['company_name' => $name],
                $data,
            );

            if ($sc->wasRecentlyCreated) {
                $imported++;
            } else {
                $updated++;
            }
        }

        $this->command?->info("Shipping companies imported: {$imported}, updated: {$updated}, skipped: {$skipped}");
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder is idempotent - it will only create users if they don't already exist.
     */
    public function run(): void
    {
        // Get Autocraft vendor
        $autocraftVendor = Vendor::where('email', 'info@autocraftjapan.com')->first();

        if ($autocraftVendor) {
            // Update all existing users to be under Autocraft vendor (if they don't have a vendor)
            User::whereNull('vendor_id')->update(['vendor_id' => $autocraftVendor->id]);
        }

        // Create specific admin user (only if doesn't exist)
        $admin = User::firstOrCreate(
            ['email' => 'sulaiman@sendasnap.com'],
            [
                'name' => 'Sulaiman',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'vendor_id' => $autocraftVendor?->id,
                'phone' => '+819019735910',
                'avatar' => '',
                'avis_id' => '',
            ]
        );

        // Create specific manager users (only if don't exist)
        User::firstOrCreate(
            ['email' => 'acj.shiroyama@gmail.com'],
            [
                'name' => 'Shiroyama',
                'password' => Hash::make('acjl7861'),
                'role' => 'manager',
                'vendor_id' => $autocraftVendor?->id,
                'phone' => '+819015505716',
                'avatar' => '',
                'avis_id' => '',
            ]
        );

        User::firstOrCreate(
            ['email' => 'zafar@kar-men.com'],
            [
                'name' => 'Zafar',
                'password' => Hash::make('0898'),
                'role' => 'manager',
                'vendor_id' => $autocraftVendor?->id,
                'phone' => '+1234567891',
                'avatar' => '',
                'avis_id' => '',
            ]
        );

        // Create specific employee users (only if don't exist)
        User::firstOrCreate(
            ['email' => 'acj.document@gmail.com'],
            [
                'name' => 'Kasahara',
                'password' => Hash::make('kasahara'),
                'role' => 'employee',
                'vendor_id' => $autocraftVendor?->id,
                'phone' => '+1234567892',
                'avatar' => '',
                'avis_id' => '',
            ]
        );

        User::firstOrCreate(
            ['email' => 'acjl.information@gmail.com'],
            [
                'name' => 'Akunova Alisa',
                'password' => Hash::make('password'),
                'role' => 'employee',
                'vendor_id' => $autocraftVendor?->id,
                'phone' => '+1234567893',
                'avatar' => '',
                'avis_id' => '',
            ]
        );

        User::firstOrCreate(
            ['email' => 'edo100@gmail.com'],
            [
                'name' => 'Valentine',
                'password' => Hash::make('password'),
                'role' => 'employee',
                'vendor_id' => $autocraftVendor?->id,
                'phone' => '+1234567893',
                'avatar' => '',
                'avis_id' => '',
            ]
        );

        // Create additional employee users under Autocraft vendor
        if ($autocraftVendor) {
            User::firstOrCreate(
                ['email' => 'acj.morita@gmail.com'],
                [
                    'name' => 'Sho Morita San',
                    'password' => Hash::make('morita2025'),
                    'role' => 'employee',
                    'vendor_id' => $autocraftVendor->id,
                    'phone' => '',
                    'avatar' => '',
                    'avis_id' => '',
                ]
            );

            User::firstOrCreate(
                ['email' => 'acj.cucho@gmail.com'],
                [
                    'name' => 'Cucho San',
                    'password' => Hash::make('cucho2025'),
                    'role' => 'employee',
                    'vendor_id' => $autocraftVendor->id,
                    'phone' => '',
                    'avatar' => '',
                    'avis_id' => '',
                ]
            );

            User::firstOrCreate(
                ['email' => 'acj.niyatov@gmail.com'],
                [
                    'name' => 'Niyatov San',
                    'password' => Hash::make('niyatov2025'),
                    'role' => 'employee',
                    'vendor_id' => $autocraftVendor->id,
                    'phone' => '',
                    'avatar' => '',
                    'avis_id' => '',
                ]
            );
        }

        // Generate a personal access token for the admin for API testing (only if token doesn't exist)
        $existingToken = $admin->tokens()->where('name', 'seeded-ui-token')->first();
        if (!$existingToken) {
            $token = $admin->createToken('seeded-ui-token')->plainTextToken;
            file_put_contents(storage_path('app/seeded_token.txt'), $token);
        }
    }
}

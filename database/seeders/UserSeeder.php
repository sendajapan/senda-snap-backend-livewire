<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific admin user
        $admin = User::create([
            'name' => 'Sulaiman',
            'email' => 'sulaiman@sendasnap.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+1234567890',
            'avis_id' => '',
        ]);

        // Create specific manager user
        $manager = User::create([
            'name' => 'Shiroyama',
            'email' => 'acj.shiroyama@gmail.com',
            'password' => Hash::make('acjl7861'),
            'role' => 'manager',
            'phone' => '+1234567891',
            'avis_id' => '',
        ]);

        $manager1 = User::create([
            'name' => 'Zafar',
            'email' => 'zafar@kar-men.com',
            'password' => Hash::make('0898'),
            'role' => 'manager',
            'phone' => '+1234567891',
            'avis_id' => '',
        ]);

        // Create specific employee users
        $employee1 = User::create([
            'name' => 'Kasahara',
            'email' => 'acj.document@gmail.com',
            'password' => Hash::make('kasahara'),
            'role' => 'employee',
            'phone' => '+1234567892',
            'avis_id' => '',
        ]);

        $employee2 = User::create([
            'name' => 'Akunova Alisa',
            'email' => 'acjl.infomation@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'phone' => '+1234567893',
            'avis_id' => '',
        ]);

        $employee3 = User::create([
            'name' => 'Valentine',
            'email' => 'edo100@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'phone' => '+1234567893',
            'avis_id' => '',
        ]);

        // Generate a personal access token for the admin for API testing
        $token = $admin->createToken('seeded-ui-token')->plainTextToken;
        file_put_contents(storage_path('app/seeded_token.txt'), $token);
    }
}

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
            'phone' => '+819019735910',
            'avatar' => 'avatars/aUZFZnTfL6GbtJ0M7EnDrWfopA6u48MoOim7tiNu.jpg',
            'avis_id' => '',
        ]);

        // Create specific manager user
        User::create([
            'name' => 'Shiroyama',
            'email' => 'acj.shiroyama@gmail.com',
            'password' => Hash::make('acjl7861'),
            'role' => 'manager',
            'phone' => '+819015505716',
            'avatar' => 'avatars/V22VLgZiw1NyCCUYvJhD9AvsJKjHgsjDPsLQza2W.png',
            'avis_id' => '',
        ]);

        User::create([
            'name' => 'Zafar',
            'email' => 'zafar@kar-men.com',
            'password' => Hash::make('0898'),
            'role' => 'manager',
            'phone' => '+1234567891',
            'avatar' => 'avatars/7nqcDM16dlEngdZiYgec3WmPUNqNaEj1HbZwMzGL.jpg',
            'avis_id' => '',
        ]);

        // Create specific employee users
        User::create([
            'name' => 'Kasahara',
            'email' => 'acj.document@gmail.com',
            'password' => Hash::make('kasahara'),
            'role' => 'employee',
            'phone' => '+1234567892',
            'avatar' => 'avatars/dndoo6bGnZNhnWVkzhvh1KfgnImkaAqCsBlwNG9C.webp',
            'avis_id' => '',
        ]);

        User::create([
            'name' => 'Akunova Alisa',
            'email' => 'acjl.information@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'phone' => '+1234567893',
            'avatar' => 'avatars/F5HMzs9YoRWmDSCUm9d0tda1jShgOzb4eEC7Ytk3.png',
            'avis_id' => '',
        ]);

        User::create([
            'name' => 'Valentine',
            'email' => 'edo100@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'phone' => '+1234567893',
            'avatar' => 'avatars/4NkFo0WFOGuGUnocQ0EiJIxvRmv0bxA2sSga0gRx.png',
            'avis_id' => '',
        ]);

        // Generate a personal access token for the admin for API testing
        $token = $admin->createToken('seeded-ui-token')->plainTextToken;
        file_put_contents(storage_path('app/seeded_token.txt'), $token);
    }
}

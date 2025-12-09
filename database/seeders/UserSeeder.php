<?php

namespace Database\Seeders;

use App\Models\User;
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
        // Create specific admin user (only if doesn't exist)
        $admin = User::firstOrCreate(
            ['email' => 'sulaiman@sendasnap.com'],
            [
                'name' => 'Sulaiman',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+819019735910',
                'avatar' => 'avatars/aUZFZnTfL6GbtJ0M7EnDrWfopA6u48MoOim7tiNu.jpg',
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
                'phone' => '+819015505716',
                'avatar' => 'avatars/V22VLgZiw1NyCCUYvJhD9AvsJKjHgsjDPsLQza2W.png',
                'avis_id' => '',
            ]
        );

        User::firstOrCreate(
            ['email' => 'zafar@kar-men.com'],
            [
                'name' => 'Zafar',
                'password' => Hash::make('0898'),
                'role' => 'manager',
                'phone' => '+1234567891',
                'avatar' => 'avatars/7nqcDM16dlEngdZiYgec3WmPUNqNaEj1HbZwMzGL.jpg',
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
                'phone' => '+1234567892',
                'avatar' => 'avatars/dndoo6bGnZNhnWVkzhvh1KfgnImkaAqCsBlwNG9C.webp',
                'avis_id' => '',
            ]
        );

        User::firstOrCreate(
            ['email' => 'acjl.information@gmail.com'],
            [
                'name' => 'Akunova Alisa',
                'password' => Hash::make('password'),
                'role' => 'employee',
                'phone' => '+1234567893',
                'avatar' => 'avatars/F5HMzs9YoRWmDSCUm9d0tda1jShgOzb4eEC7Ytk3.png',
                'avis_id' => '',
            ]
        );

        User::firstOrCreate(
            ['email' => 'edo100@gmail.com'],
            [
                'name' => 'Valentine',
                'password' => Hash::make('password'),
                'role' => 'employee',
                'phone' => '+1234567893',
                'avatar' => 'avatars/4NkFo0WFOGuGUnocQ0EiJIxvRmv0bxA2sSga0gRx.png',
                'avis_id' => '',
            ]
        );

        // Generate a personal access token for the admin for API testing (only if token doesn't exist)
        $existingToken = $admin->tokens()->where('name', 'seeded-ui-token')->first();
        if (! $existingToken) {
            $token = $admin->createToken('seeded-ui-token')->plainTextToken;
            file_put_contents(storage_path('app/seeded_token.txt'), $token);
        }
    }
}

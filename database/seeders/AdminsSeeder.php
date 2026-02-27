<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = now();

        $admin = User::updateOrCreate(
            ['email' => 'adminds@yopmail.com'],
            [
                'first_name' => 'Admin',
                'password' => Hash::make('Dots@123'),
                'remember_token' => null,
                'email_verified_at' => $timestamp,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]
        );

        // Assign Admin role
        $admin->assignRole('Admin');
    }
}

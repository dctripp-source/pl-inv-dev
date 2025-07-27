<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Admin za fond
        User::create([
            'name' => 'Administrator Fonda',
            'email' => 'admin@fond.ba',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);
        
        // Test admin
        User::create([
            'name' => 'Test Administrator',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        
        // Demo admin
        User::create([
            'name' => 'Demo Admin',
            'email' => 'demo@platforma.ba',
            'password' => Hash::make('demo123'),
            'email_verified_at' => now(),
        ]);
    }
}
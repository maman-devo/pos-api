<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat Akun Admin
        User::create([
            'name' => 'Admin POS',
            'email' => 'admin@pos.com',
            'password' => Hash::make('password'), // passwordnya: password
            'role' => 'admin',
        ]);

        // Membuat Akun Kasir
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir1@pos.com',
            'password' => Hash::make('password'), // passwordnya: password
            'role' => 'cashier',
        ]);
    }
}
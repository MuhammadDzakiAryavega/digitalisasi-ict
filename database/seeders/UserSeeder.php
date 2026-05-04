<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Admin ICT',
            'email' => 'admin@ict.com',
            'password' => Hash::make('password123'), // Ganti sesuai keinginan
            'nik' => '1234567890123456',
            'alamat' => 'Kantor Unit ICT',
            'no_telepon' => '08123456789',
            'is_admin' => 1, // Set sebagai Admin
        ]);

        // 2. Buat Akun Pengguna Biasa
        User::create([
            'name' => 'Arya Vega',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password123'),
            'nik' => '3210987654321098',
            'alamat' => 'Jl. Kampus No. 10',
            'no_telepon' => '08987654321',
            'is_admin' => 0, // Set sebagai Pengguna Biasa
        ]);
    }
}
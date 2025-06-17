<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin Filament',
                'email' => 'admin@filament.test',
                'password' => Hash::make('1234'), // Ganti sesuai kebutuhan
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambah user lain jika perlu
        ]);
    }
}

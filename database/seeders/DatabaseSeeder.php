<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RestaurantSeeder::class,
            MenuSeeder::class,
            RestaurantPolygonSeeder::class,
            SuperAdminSeeder::class,
            PaymentMethodSeeder::class,
            RestaurantPaymentMethodSeeder::class,

            // Seeder lain jika ada
        ]);
    }
}

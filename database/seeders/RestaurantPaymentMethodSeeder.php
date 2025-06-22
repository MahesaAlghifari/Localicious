<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RestaurantPaymentMethod;

class RestaurantPaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Restaurant 1
            ['restaurant_id' => 1, 'payment_method_id' => 1],
            ['restaurant_id' => 1, 'payment_method_id' => 2],
            ['restaurant_id' => 1, 'payment_method_id' => 3],
            ['restaurant_id' => 1, 'payment_method_id' => 4],
            ['restaurant_id' => 1, 'payment_method_id' => 5],
            ['restaurant_id' => 1, 'payment_method_id' => 6],
            ['restaurant_id' => 1, 'payment_method_id' => 7],
            ['restaurant_id' => 1, 'payment_method_id' => 8],
            ['restaurant_id' => 1, 'payment_method_id' => 9],

            // Restaurant 2
            ['restaurant_id' => 2, 'payment_method_id' => 1],
            ['restaurant_id' => 2, 'payment_method_id' => 2],
            ['restaurant_id' => 2, 'payment_method_id' => 3],
            ['restaurant_id' => 2, 'payment_method_id' => 4],
            ['restaurant_id' => 2, 'payment_method_id' => 5],
            ['restaurant_id' => 2, 'payment_method_id' => 6],
            ['restaurant_id' => 2, 'payment_method_id' => 7],
            ['restaurant_id' => 2, 'payment_method_id' => 8],
            ['restaurant_id' => 2, 'payment_method_id' => 9],

            // Restaurant 3
            ['restaurant_id' => 3, 'payment_method_id' => 1],
            ['restaurant_id' => 3, 'payment_method_id' => 2],
            ['restaurant_id' => 3, 'payment_method_id' => 3],
            ['restaurant_id' => 3, 'payment_method_id' => 4],
            ['restaurant_id' => 3, 'payment_method_id' => 5],
            ['restaurant_id' => 3, 'payment_method_id' => 6],
            ['restaurant_id' => 3, 'payment_method_id' => 7],
            ['restaurant_id' => 3, 'payment_method_id' => 8],
            ['restaurant_id' => 3, 'payment_method_id' => 9],
        ];

        foreach ($data as $item) {
            RestaurantPaymentMethod::updateOrCreate($item, $item);
        }
    }
}

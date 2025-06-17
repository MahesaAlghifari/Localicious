<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        Restaurant::insert([
            [
                'name' => 'IBI Kesatuan',
                'address' => 'Jl. Ranggagading No.1, Bogor Tengah',
                'province' => 'Jawa Barat',
                'city' => 'Bogor',
                'mon_open' => '08:00',
                'mon_close' => '18:00',
                'tue_open' => '08:00',
                'tue_close' => '18:00',
                'wed_open' => '08:00',
                'wed_close' => '18:00',
                'thu_open' => '08:00',
                'thu_close' => '18:00',
                'fri_open' => '08:00',
                'fri_close' => '18:00',
                'sat_open' => '09:00',
                'sat_close' => '15:00',
                'sun_open' => null,
                'sun_close' => null,
                'image_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRid4CQ5ampa4BqxhAbwpR0eAwzK-Q7bBseSw&s',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Momo Coffee and Kitchen',
                'address' => 'Jl. MH. Thamrin No.23, Sentul City',
                'province' => 'Jawa Barat',
                'city' => 'Bogor',
                'mon_open' => '10:00',
                'mon_close' => '22:00',
                'tue_open' => '10:00',
                'tue_close' => '22:00',
                'wed_open' => '10:00',
                'wed_close' => '22:00',
                'thu_open' => '10:00',
                'thu_close' => '22:00',
                'fri_open' => '10:00',
                'fri_close' => '22:00',
                'sat_open' => '10:00',
                'sat_close' => '23:00',
                'sun_open' => '10:00',
                'sun_close' => '23:00',
                'image_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcROUtnZN9wQz2_CHcYTrYS2FOTHhrMYErct4g&s',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'The Cilebut Royal Roastery',
                'address' => 'Jl. Raya Cilebut No.5',
                'province' => 'Jawa Barat',
                'city' => 'Bogor',
                'mon_open' => '00:00',
                'mon_close' => '23:59',
                'tue_open' => '00:00',
                'tue_close' => '23:59',
                'wed_open' => '00:00',
                'wed_close' => '23:59',
                'thu_open' => '00:00',
                'thu_close' => '23:59',
                'fri_open' => '00:00',
                'fri_close' => '23:59',
                'sat_open' => '00:00',
                'sat_close' => '23:59',
                'sun_open' => '00:00',
                'sun_close' => '23:59',
                'image_url' => 'https://img.freepik.com/premium-vector/coffee-vintage-logo-design-isnpiration-coffee-shop_427676-94.jpg?semt=ais_hybrid&w=740',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

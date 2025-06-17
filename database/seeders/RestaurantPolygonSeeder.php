<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RestaurantPolygon;

class RestaurantPolygonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Area Cilebut (restaurant_id: 3)
        RestaurantPolygon::create([
            'restaurant_id' => 3,
            'name' => 'Area Cilebut',
            'coordinates' => [
                [106.801481, -6.527653],
                [106.8014, -6.527909],
                [106.801516, -6.528029],
                [106.801623, -6.528071],
                [106.80243, -6.528167],
                [106.802441, -6.527708],
                [106.801481, -6.527653],
            ],
        ]);

        // Area IBI Kesatuan (restaurant_id: 1)
        RestaurantPolygon::create([
            'restaurant_id' => 1,
            'name' => 'Area IBI Kesatuan',
            'coordinates' => [
                [106.798795, -6.606506],
                [106.799750, -6.605909],
                [106.800219, -6.606415],
                [106.799943, -6.606722],
                [106.798795, -6.606506],
            ],
        ]);

        // Area Momo Coffee and Kitchen (restaurant_id: 2)
        RestaurantPolygon::create([
            'restaurant_id' => 2,
            'name' => 'Area Momo Coffee',
            'coordinates' => [
                [106.80184, -6.52798],
                [106.80214, -6.52798],
                [106.80214, -6.52768],
                [106.80184, -6.52768],
                [106.80184, -6.52798],
            ],
        ]);
    }
}

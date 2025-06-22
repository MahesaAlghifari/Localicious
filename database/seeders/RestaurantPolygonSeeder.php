<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RestaurantPolygon;

class RestaurantPolygonSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        RestaurantPolygon::create([
            'restaurant_id' => 3,
            'name' => 'Area Cilebut',
            'coordinates' => [
                [
                    [106.801508, -6.527573],
                    [106.801417, -6.527920],
                    [106.801659, -6.528080],
                    [106.802426, -6.528144],
                    [106.802442, -6.527728],
                    [106.801508, -6.527573],
                ]
            ],
        ]);

        RestaurantPolygon::create([
            'restaurant_id' => 1,
            'name' => 'Area IBI Kesatuan',
            'coordinates' => [
                [
                    [106.798778, -6.606526],
                    [106.799497, -6.606073],
                    [106.799669, -6.606286],
                    [106.799991, -6.606079],
                    [106.800324, -6.606547],
                    [106.799487, -6.607102],
                    [106.799057, -6.606825],
                    [106.798778, -6.606526],
                ]
            ],
        ]);

        RestaurantPolygon::create([
            'restaurant_id' => 2,
            'name' => 'Area Momo Coffee',
            'coordinates' => [
                [
                    [106.861900, -6.571320],
                    [106.862051, -6.571256],
                    [106.862099, -6.571347],
                    [106.861981, -6.571411],
                    [106.861900, -6.571320],
                ]
            ],
        ]);
    }
}

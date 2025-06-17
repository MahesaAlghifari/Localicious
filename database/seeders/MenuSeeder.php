<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['appetizer', 'main', 'dessert', 'drink'];
        $sizes = ['small', 'medium', 'large'];
        $spiceLevels = ['low', 'medium', 'high'];

        // Keyword untuk gambar dari Unsplash
        $keywords = ['food', 'coffee', 'cake', 'drink', 'noodle', 'burger', 'rice'];

        // Ganti 1 dengan ID restoran yang tersedia
        $restaurantId = 1;

        for ($i = 0; $i < 10; $i++) {
            $keyword = $keywords[array_rand($keywords)];
            $randomSig = Str::random(6);
            $unsplashUrl = "https://images.unsplash.com/photo-1580418089636-871abb16468f?q=80&w=1935&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D";

            Menu::create([
                'restaurant_id' => $restaurantId,
                'item_name'     => ucfirst($keyword),
                'description'   => 'Menu special dari bahan ' . $keyword,
                'price'         => rand(15000, 80000),
                'size'          => $sizes[array_rand($sizes)],
                'spice_level'   => $spiceLevels[array_rand($spiceLevels)],
                'category'      => $categories[array_rand($categories)],
                'quantity'      => rand(1, 20),
                'is_active'     => true,
                'image_url'     => $unsplashUrl,
            ]);
        }
    }
}

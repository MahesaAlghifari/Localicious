<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        return response()->json(Restaurant::all(), 200);
    }

    public function show(Restaurant $restaurant)
    {
        return response()->json($restaurant, 200);
    }

    public function store(Request $request)
    {
        $data = $this->validateRestaurant($request);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $filename = basename($path);
            $data['image_url'] = env('APP_URL') . '/storage/images/' . $filename;
        }

        $restaurant = Restaurant::create($data);

        return response()->json($restaurant, 201);
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $data = $this->validateRestaurant($request);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $filename = basename($path);
            $data['image_url'] = env('APP_URL') . '/storage/images/' . $filename;
        }

        $restaurant->update($data);

        return response()->json($restaurant, 200);
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return response()->json(null, 204);
    }

    private function validateRestaurant(Request $request): array
    {
        return $request->validate([
            'name'        => 'required|string|max:255',
            'address'     => 'required|string',
            'province'    => 'required|string',
            'city'        => 'required|string',
            'description' => 'nullable|string',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'mon_open'    => 'nullable|date_format:H:i:s',
            'mon_close'   => 'nullable|date_format:H:i:s',
            'tue_open'    => 'nullable|date_format:H:i:s',
            'tue_close'   => 'nullable|date_format:H:i:s',
            'wed_open'    => 'nullable|date_format:H:i:s',
            'wed_close'   => 'nullable|date_format:H:i:s',
            'thu_open'    => 'nullable|date_format:H:i:s',
            'thu_close'   => 'nullable|date_format:H:i:s',
            'fri_open'    => 'nullable|date_format:H:i:s',
            'fri_close'   => 'nullable|date_format:H:i:s',
            'sat_open'    => 'nullable|date_format:H:i:s',
            'sat_close'   => 'nullable|date_format:H:i:s',
            'sun_open'    => 'nullable|date_format:H:i:s',
            'sun_close'   => 'nullable|date_format:H:i:s',
            'image_url'       => 'nullable|image|max:2048' // ini menggantikan image_url
        ]);
    }
}

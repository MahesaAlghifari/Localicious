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
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'address'     => 'required|string',
            'description' => 'nullable|string',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
        ]);

        $restaurant = Restaurant::create($data);

        return response()->json($restaurant, 201);
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $data = $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'address'     => 'sometimes|required|string',
            'description' => 'nullable|string',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
        ]);

        $restaurant->update($data);

        return response()->json($restaurant, 200);
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return response()->json(null, 204);
    }
}

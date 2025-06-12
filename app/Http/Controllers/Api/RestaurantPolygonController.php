<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RestaurantPolygon;
use Illuminate\Http\Request;

class RestaurantPolygonController extends Controller
{
    // GET /api/restaurant-polygons
    public function index()
    {
        $polygons = RestaurantPolygon::with('restaurant')->get();
        return response()->json($polygons, 200);
    }

    // GET /api/restaurant-polygons/{restaurant_polygon}
    public function show(RestaurantPolygon $restaurant_polygon)
    {
        return response()->json(
            $restaurant_polygon->load('restaurant'),
            200
        );
    }

    // POST /api/restaurant-polygons
    public function store(Request $request)
    {
        $data = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'name'          => 'nullable|string|max:255',
            'coordinates'   => 'required|json',
        ]);

        $polygon = RestaurantPolygon::create($data);

        return response()->json(
            $polygon->load('restaurant'),
            201
        );
    }

    // PUT/PATCH /api/restaurant-polygons/{restaurant_polygon}
    public function update(Request $request, RestaurantPolygon $restaurant_polygon)
    {
        $data = $request->validate([
            'restaurant_id' => 'sometimes|required|exists:restaurants,id',
            'name'          => 'nullable|string|max:255',
            'coordinates'   => 'sometimes|required|json',
        ]);

        $restaurant_polygon->update($data);

        return response()->json(
            $restaurant_polygon->load('restaurant'),
            200
        );
    }

    // DELETE /api/restaurant-polygons/{restaurant_polygon}
    public function destroy(RestaurantPolygon $restaurant_polygon)
    {
        $restaurant_polygon->delete();
        return response()->json(null, 204);
    }
}

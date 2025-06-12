<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        return response()->json(Menu::with('restaurant')->get(), 200);
    }

    public function show(Menu $menu)
    {
        return response()->json($menu->load('restaurant'), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'item_name'     => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric',
            'size'          => 'required|in:small,medium,large',
            'spice_level'   => 'required|in:low,medium,high',
            'category'      => 'required|in:appetizer,main,dessert,drink',
            'quantity'      => 'required|integer|min:0',
            'is_active'     => 'sometimes|boolean',
            'image_url'     => 'nullable|url',
        ]);

        $menu = Menu::create($data);

        return response()->json($menu->load('restaurant'), 201);
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'restaurant_id' => 'sometimes|required|exists:restaurants,id',
            'item_name'     => 'sometimes|required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'sometimes|required|numeric',
            'size'          => 'sometimes|required|in:small,medium,large',
            'spice_level'   => 'sometimes|required|in:low,medium,high',
            'category'      => 'sometimes|required|in:appetizer,main,dessert,drink',
            'quantity'      => 'sometimes|required|integer|min:0',
            'is_active'     => 'sometimes|boolean',
            'image_url'     => 'nullable|url',
        ]);

        $menu->update($data);

        return response()->json($menu->load('restaurant'), 200);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response()->json(null, 204);
    }
}

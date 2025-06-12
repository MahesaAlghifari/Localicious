<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RestaurantAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RestaurantAdminController extends Controller
{
    public function index()
    {
        // Bisa paginasi atau all()
        return response()->json(RestaurantAdmin::with('restaurant')->get(), 200);
    }

    public function show(RestaurantAdmin $restaurantAdmin)
    {
        return response()->json($restaurantAdmin->load('restaurant'), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:restaurant_admins,email',
            'password'      => 'required|string|min:6',
            'phone_number'  => 'nullable|string',
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        // Hash password sebelum simpan
        $data['password'] = Hash::make($data['password']);

        $admin = RestaurantAdmin::create($data);

        return response()->json($admin->load('restaurant'), 201);
    }

    public function update(Request $request, RestaurantAdmin $restaurantAdmin)
    {
        $data = $request->validate([
            'full_name'     => 'sometimes|required|string|max:255',
            'email'         => "sometimes|required|email|unique:restaurant_admins,email,{$restaurantAdmin->id}",
            'password'      => 'sometimes|nullable|string|min:6',
            'phone_number'  => 'nullable|string',
            'restaurant_id' => 'sometimes|required|exists:restaurants,id',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $restaurantAdmin->update($data);

        return response()->json($restaurantAdmin->load('restaurant'), 200);
    }

    public function destroy(RestaurantAdmin $restaurantAdmin)
    {
        $restaurantAdmin->delete();
        return response()->json(null, 204);
    }
}

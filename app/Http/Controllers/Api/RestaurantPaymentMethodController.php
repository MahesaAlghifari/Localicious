<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\RestaurantPaymentMethod;
use Illuminate\Http\Request;

class RestaurantPaymentMethodController extends Controller
{
   public function index()
{
    try {
        return RestaurantPaymentMethod::with(['restaurant', 'paymentMethod'])->get();
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    public function store(Request $request)
    {
        $data = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'payment_methods' => 'required|array|min:1',
            'payment_methods.*.payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $result = [];

        foreach ($data['payment_methods'] as $item) {
            $result[] = RestaurantPaymentMethod::create([
                'restaurant_id' => $data['restaurant_id'],
                'payment_method_id' => $item['payment_method_id'],
            ]);
        }

        return response()->json($result, 201);
    }

    // Tambahkan di RestaurantPaymentMethodController
    public function getByRestaurant($restaurantId)
    {
        return RestaurantPaymentMethod::with('paymentMethod')
            ->where('restaurant_id', $restaurantId)
            ->get()
            ->pluck('paymentMethod'); // hanya kirim info metode pembayarannya
    }

    public function destroy($id)
    {
        $method = RestaurantPaymentMethod::findOrFail($id);
        $method->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}

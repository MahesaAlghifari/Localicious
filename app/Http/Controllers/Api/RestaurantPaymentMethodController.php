<?php

namespace App\Http\Controllers\Api;

use App\Models\RestaurantPaymentMethod;
use Illuminate\Http\Request;

class RestaurantPaymentMethodController extends Controller
{
    public function index()
    {
        return RestaurantPaymentMethod::with(['restaurant', 'paymentMethod'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        return RestaurantPaymentMethod::create($data);
    }

    public function destroy($id)
    {
        $method = RestaurantPaymentMethod::findOrFail($id);
        $method->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RestaurantPaymentAccount;
use Illuminate\Http\Request;

class RestaurantPaymentAccountController extends Controller
{
    // GET /api/restaurant-payment-accounts
    public function index()
    {
        $accounts = RestaurantPaymentAccount::with('restaurant')->get();
        return response()->json($accounts, 200);
    }

    // GET /api/restaurant-payment-accounts/{account}
    public function show(RestaurantPaymentAccount $restaurantPaymentAccount)
    {
        return response()->json(
            $restaurantPaymentAccount->load('restaurant'),
            200
        );
    }

    // POST /api/restaurant-payment-accounts
    public function store(Request $request)
    {
        $data = $request->validate([
            'restaurant_id'    => 'required|exists:restaurants,id',
            'account_type'     => 'required|in:virtual_account,ewallet',
            'payment_provider' => 'required|in:midtrans',
            'account_number'   => 'required|string|max:255',
            'is_active'        => 'sometimes|boolean',
        ]);

        $account = RestaurantPaymentAccount::create($data);

        return response()->json(
            $account->load('restaurant'),
            201
        );
    }

    // PUT/PATCH /api/restaurant-payment-accounts/{account}
    public function update(Request $request, RestaurantPaymentAccount $restaurantPaymentAccount)
    {
        $data = $request->validate([
            'restaurant_id'    => 'sometimes|required|exists:restaurants,id',
            'account_type'     => 'sometimes|required|in:virtual_account,ewallet',
            'payment_provider' => 'sometimes|required|in:midtrans',
            'account_number'   => 'sometimes|required|string|max:255',
            'is_active'        => 'sometimes|boolean',
        ]);

        $restaurantPaymentAccount->update($data);

        return response()->json(
            $restaurantPaymentAccount->load('restaurant'),
            200
        );
    }

    // DELETE /api/restaurant-payment-accounts/{account}
    public function destroy(RestaurantPaymentAccount $restaurantPaymentAccount)
    {
        $restaurantPaymentAccount->delete();
        return response()->json(null, 204);
    }
}

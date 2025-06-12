<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // GET /api/orders
    public function index()
    {
        $orders = Order::with(['customer', 'restaurant', 'items'])->get();
        return response()->json($orders, 200);
    }

    // GET /api/orders/{order}
    public function show(Order $order)
    {
        $order->load(['customer', 'restaurant', 'items']);
        return response()->json($order, 200);
    }

    // POST /api/orders
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id'   => 'required|exists:customers,id',
            'restaurant_id' => 'required|exists:restaurants,id',
            'total_amount'  => 'required|numeric',
            'status'        => 'required|in:pending,processing,completed,cancelled',
            'scheduled_at'  => 'nullable|date',
            'payment_method'=> 'nullable|string',
            'notes'         => 'nullable|string',
        ]);

        $order = Order::create($data);

        return response()->json($order->load(['customer', 'restaurant']), 201);
    }

    // PUT/PATCH /api/orders/{order}
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_id'   => 'sometimes|required|exists:customers,id',
            'restaurant_id' => 'sometimes|required|exists:restaurants,id',
            'total_amount'  => 'sometimes|required|numeric',
            'status'        => 'sometimes|required|in:pending,processing,completed,cancelled',
            'scheduled_at'  => 'nullable|date',
            'payment_method'=> 'nullable|string',
            'notes'         => 'nullable|string',
        ]);

        $order->update($data);

        return response()->json($order->load(['customer', 'restaurant', 'items']), 200);
    }

    // DELETE /api/orders/{order}
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}

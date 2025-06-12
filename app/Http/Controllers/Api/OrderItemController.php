<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    // GET /api/order-items
    public function index()
    {
        $items = OrderItem::with(['order', 'menu'])->get();
        return response()->json($items, 200);
    }

    // GET /api/order-items/{order_item}
    public function show(OrderItem $order_item)
    {
        return response()->json(
            $order_item->load(['order', 'menu']),
            200
        );
    }

    // POST /api/order-items
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id'   => 'required|exists:orders,id',
            'menu_id'    => 'required|exists:menus,id',
            'quantity'   => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'subtotal'   => 'required|numeric|min:0',
        ]);

        $item = OrderItem::create($data);

        return response()->json(
            $item->load(['order', 'menu']),
            201
        );
    }

    // PUT/PATCH /api/order-items/{order_item}
    public function update(Request $request, OrderItem $order_item)
    {
        $data = $request->validate([
            'order_id'   => 'sometimes|required|exists:orders,id',
            'menu_id'    => 'sometimes|required|exists:menus,id',
            'quantity'   => 'sometimes|required|integer|min:1',
            'unit_price' => 'sometimes|required|numeric|min:0',
            'subtotal'   => 'sometimes|required|numeric|min:0',
        ]);

        $order_item->update($data);

        return response()->json(
            $order_item->load(['order', 'menu']),
            200
        );
    }

    // DELETE /api/order-items/{order_item}
    public function destroy(OrderItem $order_item)
    {
        $order_item->delete();
        return response()->json(null, 204);
    }
}

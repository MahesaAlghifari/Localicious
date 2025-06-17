<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Menu;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Menampilkan semua order item dengan relasi order & menu.
     */
    public function index()
    {
        $items = OrderItem::with(['order', 'menu'])->paginate(20);
        return response()->json($items, 200);
    }

    /**
     * Menampilkan detail satu order item.
     */
    public function show(OrderItem $orderItem)
    {
        return response()->json(
            $orderItem->load(['order', 'menu']),
            200
        );
    }

    /**
     * Menyimpan order item baru.
     */ public function store(Request $request)
    {
        $data = $request->validate([
            'order_id'  => 'nullable|exists:orders,id',
            'user_id'   => 'required|exists:users,id',
            'restaurant_id' => 'required|exists:restaurants,id',
            'menu_id'   => 'required|exists:menus,id',
            'quantity'  => 'required|integer|min:1',
        ]);

        // ✅ Buat order baru jika belum ada
        if (empty($data['order_id'])) {
            $order = \App\Models\Order::create([
                'user_id'        => $data['user_id'],
                'restaurant_id'  => $data['restaurant_id'],
                'status'         => 'pending',
                'total_amount'   => 0,
            ]);
            $data['order_id'] = $order->id;
        } else {
            $order = \App\Models\Order::findOrFail($data['order_id']);
        }

        // 💰 Hitung harga
        $menu = Menu::findOrFail($data['menu_id']);
        $unitPrice = $menu->price;
        $subtotal  = $unitPrice * $data['quantity'];

        // ➕ Simpan item
        $item = OrderItem::create([
            'order_id'    => $data['order_id'],
            'menu_id'     => $data['menu_id'],
            'quantity'    => $data['quantity'],
            'unit_price'  => $unitPrice,
            'subtotal'    => $subtotal,
        ]);

        // 🔄 Hitung ulang total
        $order->recalculateTotal();

        return response()->json($item->load(['order', 'menu']), 201);
    }


    /**
     * Memperbarui jumlah pada order item.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $unitPrice = $orderItem->menu->price;
        $subtotal = $unitPrice * $data['quantity'];

        $orderItem->update([
            'quantity'   => $data['quantity'],
            'unit_price' => $unitPrice,
            'subtotal'   => $subtotal,
        ]);

        if ($orderItem->order) {
            $orderItem->order->recalculateTotal();
        }

        return response()->json(
            $orderItem->load(['order', 'menu']),
            200
        );
    }

    /**
     * Menghapus order item.
     */
    public function destroy(OrderItem $orderItem)
    {
        $order = $orderItem->order;
        $orderItem->delete();

        if ($order) {
            $order->recalculateTotal();
        }

        return response()->json(null, 204);
    }
}

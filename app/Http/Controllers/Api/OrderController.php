<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * GET /api/orders
     * Menampilkan semua order beserta relasinya
     */
    public function index()
    {
        return response()->json(
            Order::with(['user', 'restaurant', 'items.menu'])
                ->latest()
                ->paginate(20)
        );
    }

    /**
     * POST /api/orders
     * Membuat order baru beserta order items
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'            => 'required|exists:users,id',
            'restaurant_id'      => 'required|exists:restaurants,id',
            'scheduled_at'       => 'nullable|date',
            'payment_method'     => 'nullable|string',
            'notes'              => 'nullable|string',
            'items'              => 'required|array|min:1',
            'items.*.menu_id'    => 'required|exists:menus,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Buat order kosong dulu
            $order = Order::create([
                'user_id'        => $data['user_id'],
                'restaurant_id'  => $data['restaurant_id'],
                'scheduled_at'   => $data['scheduled_at'] ?? null,
                'payment_method' => $data['payment_method'] ?? null,
                'notes'          => $data['notes'] ?? null,
                'status'         => 'pending',
                'total_amount'   => 0, // akan dihitung setelah order item ditambahkan
            ]);

            // Ambil semua menu sekaligus (1 query)
            $menuIds = collect($data['items'])->pluck('menu_id')->unique();
            $menus = Menu::whereIn('id', $menuIds)->get()->keyBy('id');

            $total = 0;

            // Tambahkan order items
            foreach ($data['items'] as $item) {
                $menu = $menus[$item['menu_id']] ?? null;

                if (!$menu) {
                    throw new \Exception("Menu ID {$item['menu_id']} not found.");
                }

                $quantity = $item['quantity'];
                $price    = $menu->price;
                $subtotal = $quantity * $price;

                $order->items()->create([
                    'menu_id'    => $menu->id,
                    'quantity'   => $quantity,
                    'unit_price' => $price,
                    'subtotal'   => $subtotal,
                ]);

                $total += $subtotal;
            }

            // Update total order
            $order->update(['total_amount' => $total]);

            DB::commit();

            return response()->json(
                $order->load(['user', 'restaurant', 'items.menu']),
                201
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return response()->json([
                'error'   => 'Failed to create order',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET /api/orders/{order}
     * Menampilkan detail order
     */
    public function show(Order $order)
    {
        return response()->json(
            $order->load(['user', 'restaurant', 'items.menu']),
            200
        );
    }

    /**
     * PUT /api/orders/{order}
     * Update data order (hanya metadata, bukan item)
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status'         => 'sometimes|in:pending,processing,completed,cancelled',
            'scheduled_at'   => 'nullable|date',
            'payment_method' => 'nullable|string',
            'notes'          => 'nullable|string',
        ]);

        $order->update($data);

        return response()->json(
            $order->load(['user', 'restaurant', 'items.menu']),
            200
        );
    }

    /**
     * DELETE /api/orders/{order}
     * Hapus order beserta itemnya
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json(null, 204);
    }
}

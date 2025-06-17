<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; // ⬅️ Tambahkan baris ini

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\PaymentMethod; // ⬅️ tambahkan ini


class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Generate Snap Token berdasarkan Order ID
     */
    public function getSnapToken(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        // Ambil order dan user
        $order = Order::with('user')->findOrFail($request->order_id);

        if (! $order->user || ! $order->user) {
            return response()->json(['message' => 'user information incomplete'], 422);
        }

        // Ambil metode pembayaran aktif dari admin
        $enabledMethods = PaymentMethod::where('is_active', true)->pluck('code')->toArray();

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $order->id . '-' . time(), // atau pakai UUID
                'gross_amount' => (int) $order->total_amount,
            ],
            'user_details' => [
                'first_name' => $order->user->name ?? 'Guest',
                'email' => $order->user->email ?? 'guest@example.com',
            ],
            'enabled_payments' => $enabledMethods, // <-- disesuaikan dengan admin
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken,
            'midtrans_order_id' => 'ORDER-' . $order->id
        ]);
    }

    /**
     * Handle Notifikasi Callback dari Midtrans
     */
    public function handleCallback(Request $request)
    {
        // Validasi Signature
        $expectedSignature = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                env('MIDTRANS_SERVER_KEY')
        );

        if ($expectedSignature !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Ambil order_id dari format "ORDER-{id}"
        $numericOrderId = (int) str_replace('ORDER-', '', $request->order_id);
        $order = Order::find($numericOrderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update status order
        $status = $request->transaction_status;
        if ($status === 'settlement') {
            $order->status = 'completed';
            $order->payment_method = 'midtrans';
        } elseif ($status === 'pending') {
            $order->status = 'pending';
        } elseif ($status === 'cancel' || $status === 'expire') {
            $order->status = 'cancelled';
        }
        $order->save();

        // Simpan detail pembayaran ke tabel 'payments'
        $payment = new Payment([
            'transaction_id'     => $request->transaction_id,
            'payment_type'       => $request->payment_type,
            'transaction_status' => $request->transaction_status,
            'fraud_status'       => $request->fraud_status ?? null,
            'amount'             => $request->gross_amount,
            'bank'               => $request->va_numbers[0]['bank'] ?? null,
            'va_number'          => $request->va_numbers[0]['va_number'] ?? null,
        ]);

        $order->payment()->save($payment);

        return response()->json(['message' => 'Callback handled']);
    }
}

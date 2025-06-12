<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // GET /api/payments
    public function index()
    {
        $payments = Payment::with(['order'])->get();
        return response()->json($payments, 200);
    }

    // GET /api/payments/{payment}
    public function show(Payment $payment)
    {
        return response()->json(
            $payment->load('order'),
            200
        );
    }

    // POST /api/payments
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id'     => 'required|exists:orders,id',
            'amount'       => 'required|numeric|min:0',
            'method'       => 'nullable|string|max:100',
            'status'       => 'required|in:pending,paid,failed',
            'reference_id' => 'nullable|string|max:255',
        ]);

        $payment = Payment::create($data);

        return response()->json(
            $payment->load('order'),
            201
        );
    }

    // PUT/PATCH /api/payments/{payment}
    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'order_id'     => 'sometimes|required|exists:orders,id',
            'amount'       => 'sometimes|required|numeric|min:0',
            'method'       => 'nullable|string|max:100',
            'status'       => 'sometimes|required|in:pending,paid,failed',
            'reference_id' => 'nullable|string|max:255',
        ]);

        $payment->update($data);

        return response()->json(
            $payment->load('order'),
            200
        );
    }

    // DELETE /api/payments/{payment}
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json(null, 204);
    }
}

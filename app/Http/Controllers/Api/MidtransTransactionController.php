<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MidtransTransaction;
use Illuminate\Http\Request;

class MidtransTransactionController extends Controller
{
    // GET /api/midtrans-transactions
    public function index()
    {
        $txs = MidtransTransaction::with(['payment', 'paymentAccount'])->get();
        return response()->json($txs, 200);
    }

    // GET /api/midtrans-transactions/{id}
    public function show(MidtransTransaction $midtransTransaction)
    {
        return response()->json(
            $midtransTransaction->load(['payment', 'paymentAccount']),
            200
        );
    }

    // POST /api/midtrans-transactions
    public function store(Request $request)
    {
        $data = $request->validate([
            'payment_id'         => 'required|exists:payments,id',
            'payment_account_id' => 'required|exists:restaurant_payment_accounts,id',
            'midtrans_order_id'  => 'required|string|max:255',
            'transaction_id'     => 'required|string|max:255',
            'va_number'          => 'nullable|string|max:255',
            'payment_url'        => 'nullable|url',
            'qr_string'          => 'nullable|string',
            'fraud_status'       => 'nullable|string|max:50',
            'status_url'         => 'nullable|url',
        ]);

        $tx = MidtransTransaction::create($data);

        return response()->json(
            $tx->load(['payment', 'paymentAccount']),
            201
        );
    }

    // PUT/PATCH /api/midtrans-transactions/{id}
    public function update(Request $request, MidtransTransaction $midtransTransaction)
    {
        $data = $request->validate([
            'payment_id'         => 'sometimes|required|exists:payments,id',
            'payment_account_id' => 'sometimes|required|exists:restaurant_payment_accounts,id',
            'midtrans_order_id'  => 'sometimes|required|string|max:255',
            'transaction_id'     => 'sometimes|required|string|max:255',
            'va_number'          => 'nullable|string|max:255',
            'payment_url'        => 'nullable|url',
            'qr_string'          => 'nullable|string',
            'fraud_status'       => 'nullable|string|max:50',
            'status_url'         => 'nullable|url',
        ]);

        $midtransTransaction->update($data);

        return response()->json(
            $midtransTransaction->load(['payment', 'paymentAccount']),
            200
        );
    }

    // DELETE /api/midtrans-transactions/{id}
    public function destroy(MidtransTransaction $midtransTransaction)
    {
        $midtransTransaction->delete();
        return response()->json(null, 204);
    }
}

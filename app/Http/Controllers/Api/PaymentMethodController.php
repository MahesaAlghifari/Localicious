<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    // Ambil semua metode pembayaran
    public function index()
    {
        return PaymentMethod::all();
    }

    // Tambah metode pembayaran baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:payment_methods,code',
            'is_active' => 'required|boolean',
        ]);

        $method = PaymentMethod::create($data);

        return response()->json($method, 201);
    }

    // Tampilkan 1 metode berdasarkan ID
    public function show($id)
    {
        $method = PaymentMethod::findOrFail($id);
        return response()->json($method);
    }

    // Update metode pembayaran
    public function update(Request $request, $id)
    {
        $method = PaymentMethod::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|required|string|max:100|unique:payment_methods,code,' . $id,
            'is_active' => 'sometimes|required|boolean',
        ]);

        $method->update($data);

        return response()->json($method);
    }

    // Hapus metode pembayaran
    public function destroy($id)
    {
        $method = PaymentMethod::findOrFail($id);
        $method->delete();

        return response()->json(['message' => 'Metode pembayaran dihapus']);
    }
}

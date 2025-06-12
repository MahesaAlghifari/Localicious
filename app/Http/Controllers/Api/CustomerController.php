<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // GET /api/customers
    public function index()
    {
        return response()->json(Customer::all(), 200);
    }

    // GET /api/customers/{customer}
    public function show(Customer $customer)
    {
        return response()->json($customer, 200);
    }

    // POST /api/customers
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email|unique:customers,email',
            'password'     => 'required|string|min:6|confirmed',
            'phone_number' => 'nullable|string',
            'gender'       => 'nullable|in:male,female,other',
        ]);

        $data['password'] = Hash::make($data['password']);

        $customer = Customer::create($data);

        return response()->json($customer, 201);
    }

    // PUT/PATCH /api/customers/{customer}
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'full_name'    => 'sometimes|required|string|max:255',
            'email'        => "sometimes|required|email|unique:customers,email,{$customer->id}",
            'password'     => 'sometimes|nullable|string|min:6|confirmed',
            'phone_number' => 'nullable|string',
            'gender'       => 'nullable|in:male,female,other',
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $customer->update($data);

        return response()->json($customer, 200);
    }

    // DELETE /api/customers/{customer}
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }
}

<!-- === [5] app/Http/Controllers/Api/CustomerController.php === -->

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// app/Http/Controllers/Api/CustomerController.php

class CustomerController extends Controller
{
    /** GET /api/customers */
    public function index()
    {
        return Customer::with('user')->paginate(10);
    }

    /** POST /api/customers */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:6|confirmed',
            'phone_number'  => 'nullable|string|max:20',
            'gender'        => 'nullable|in:male,female,other',
        ]);

        // 1. buat user-nya dulu
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'customer',
        ]);

        // 2. buat profil customer-nya
        $customer = Customer::create([
            'user_id'      => $user->id,
            'phone_number' => $data['phone_number'] ?? null,
            'gender'       => $data['gender'] ?? null,
        ]);

        return response()->json([
            'message'  => 'Customer created',
            'customer' => $customer->load('user'),
        ], 201);
    }

    /** GET /api/customers/{customer} */
    public function show(Customer $customer)
    {
        return $customer->load('user');
    }

    /** PUT /api/customers/{customer} */
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name'          => 'sometimes|required|string|max:255',
            'email'         => 'sometimes|required|email|unique:users,email,' . $customer->user_id,
            'password'      => 'nullable|string|min:6|confirmed',
            'phone_number'  => 'nullable|string|max:20',
            'gender'        => 'nullable|in:male,female,other',
        ]);

        // update user
        $customer->user->update([
            'name'  => $data['name']  ?? $customer->user->name,
            'email' => $data['email'] ?? $customer->user->email,
            'password' => isset($data['password'])
                ? Hash::make($data['password'])
                : $customer->user->password,
        ]);

        // update profile
        $customer->update([
            'phone_number' => $data['phone_number'] ?? $customer->phone_number,
            'gender'       => $data['gender']       ?? $customer->gender,
        ]);

        return response()->json([
            'message'  => 'Customer updated',
            'customer' => $customer->load('user'),
        ]);
    }

    /** DELETE /api/customers/{customer} */
    public function destroy(Customer $customer)
    {
        $customer->user()->delete();   // cascade delete user
        $customer->delete();

        return response()->json(['message' => 'Customer deleted']);
    }
}

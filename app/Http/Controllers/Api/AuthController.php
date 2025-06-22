<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah',
            ], 401);
        }

        if ($user->role !== 'customer') {
            return response()->json([
                'message' => 'Akun bukan customer',
            ], 403);
        }

        return response()->json([
            'message'  => 'Login berhasil',
            'user'     => $user,
            'customer' => $user->customer ?? null, // jika relasi customer ada
        ]);
    }
}

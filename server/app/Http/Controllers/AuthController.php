<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

/**
 * @unauthenticated
 */
    public function login(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['message' => 'Login successful', 'token' => $token]);
    }

/**
 * @unauthenticated
 */
    public function register(AuthRequest $request)
    {
        try {
            $credentials = $request->validated();
            $user = User::create([
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['message' => 'User registered successfully', 'token' => $token], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}

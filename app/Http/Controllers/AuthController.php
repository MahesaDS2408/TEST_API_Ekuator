<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|max:255',
            'role' => 'required|in:admin,customer',
        ]);
    
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => ($request->role == 'admin') ? (1) : (2),
            ]);
    
            return response()->json(['message' => 'User registered successfully'], 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'An error occurred while registering user'], 500);
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|max:255',
            // 'role' => 'required|in:admin,customer',
        ]);
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // if ($user->role !== $request->role) {
            //     return response()->json(['message' => 'Unauthorized'], 401);
            // }
            $token = $user->createToken('AuthToken')->accessToken;
    
            // return response()->json(['token' => $token], 200);
            return response()->json([ 
                'success' => true , 
                'token' => $token, 
                'user' => $user, 
            ], 200 );
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
    public function logout(Request $request)
    {
        // return $request->user();
        // if ($request->user()) {
        //     Auth::logout();
            $request->user()->token()->revoke();
            return response()->json(['message' => 'User logged out successfully'], 200);
        // } else {
        //     return response()->json(['message' => 'User not authenticated'], 401);
        // }
        
    }
}

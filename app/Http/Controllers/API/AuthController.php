<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);
    
        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Return response
        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
{
    // Validation
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    // Attempt login
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = $request->user();
   
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['access_token' => $token,
        'token_type' => 'Bearer',], 200);
    } else {
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}

    
}

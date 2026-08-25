<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function update(LoginRequest $request){
        if (
            !Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ])
        ) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
        if (Auth::user()->role !== 'user') {
            Auth::logout();
            return response()->json([
                'message' => 'You are not authorized as user.'
            ], 403);
        }
        $user = Auth::user();
        $token = $user->createToken('user-token')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ],200);
    }

    public function store(RegisterRequest $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('user-token')->plainTextToken;
        return response()->json([
            'message' => 'Registration successful',
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }

    public function destroy(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout successful'
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            "email" => "required|email",
            "password" => "required|string|min:6",
        ]);

        $user = User::where("email", $validated["email"])->first();
        if (!$user || !Hash::check($validated["password"], $user->password)) {
            return response()->json([
                "status" => "error",
                "message" => "Invalid credentials"
            ], 401);
        }

        // optional: single session
        $user->tokens()->delete();

        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "status" => "success",
            "data" => [
                "token_type" => "Bearer",
                "access_token" => $token,
                "user" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "role" => $user->role,
                ]
            ]
        ]);
    }

    public function profile(Request $request)
    {
        $u = $request->user();
        return response()->json([
            "status" => "success",
            "data" => [
                "id" => $u->id,
                "name" => $u->name,
                "email" => $u->email,
                "role" => $u->role,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "status" => "success",
            "message" => "Logged out"
        ]);
    }
}
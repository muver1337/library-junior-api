<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validation = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
            'role'     => ['required', 'in:admin,author'],
        ]);

        $user = User::where('email', $validation['email'])->first();

        if (! $user || ! password_verify($validation['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        if ($user->role !== $validation['role']) {
            return response()->json(['message' => 'Access denied for this role.'], 403);
        }

        $token = $user->createToken($validation['role'].'-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => $user,
            'role'  => $validation['role'],
        ]);
    }
}


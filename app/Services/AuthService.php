<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (
            !$user ||
            !Hash::check($data['password'], $user->password)
        ) {
            throw ValidationException::withMessages([
                'email' => ['Invalid email or password'],
            ]);
        }
        $user->tokens()->where('name', $user->role . '-token')->delete();

        $token = $user->createToken($user->role . '-token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
            'role' => $user->role,
        ];
    }

    public function getUserProfile($user)
    {
        return $user;
    }

    public function updateUserProfile($user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'] ?? 'author',
                'bio' => $data['bio'] ?? null,
            ]);

            $token = $user->createToken($user->role . '-token')->plainTextToken;

            return [
                'token' => $token,
                'user' => $user,
            ];
        });
    }
}

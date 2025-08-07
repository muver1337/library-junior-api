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

        if (!$user || !Hash::check($data['password'], $user->password)) {
//        if (!$user || $data['password'] !== $user->password) {
            throw ValidationException::withMessages([
                'email' => ['Invalid email or password.'],
            ]);
        }

        $role = $user->role;

        $token = $user->createToken($role . '-token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
            'role' => $role,
        ];
    }

    public function getUserProfile($user)
    {
        $user->load('user');
        return $user->user ?? $user;
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

//            $author = null;
//            if ($user->role === 'author') {
//                $author = ::create([
//                    'user_id' => $user->id,
//                    'bio' => $data['bio'] ?? null,
//                    'role' => 'author',
//                ]);
//            }

            $token = $user->createToken($user->role . '-token')->plainTextToken;

            return [
                'token' => $token,
                'user' => $user,
                'author' => $author,
            ];
        });
    }
}

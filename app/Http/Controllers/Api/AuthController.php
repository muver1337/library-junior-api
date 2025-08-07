<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    protected AuthService $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    public function login(LoginRequest $request)
    {
        return $this->auth->login($request->validated());

    }

    public function getProfile(Request $request)
    {
        return response()->json($this->auth->getUserProfile($request->user()));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $updatedUser = $this->auth->updateUserProfile($user, $request->validated());

        return response()->json($updatedUser);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'bio' => 'nullable|string',
        ]);

        return response()->json($this->auth->register($data), 201);
    }
}

<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    protected AuthService $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    public function loginAdmin(LoginRequest $request)
    {
        return $this->auth->login($request->validated(), 'admin');
    }

    public function loginAuthor(LoginRequest $request)
    {
        return $this->auth->login($request->validated(), 'author');
    }

    public function show(Request $request)
    {
        return $this->auth->getUserProfile($request->user());
    }

    public function update(UpdateProfileRequest $request)
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

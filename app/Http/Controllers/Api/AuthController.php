<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
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

    public function login(LoginRequest $request)
    {
        return response()->json(
            $this->auth->login($request->validated())
        );
    }

    public function show(Request $request)
    {
        return response()->json(
            $this->auth->getUserProfile($request->user())
        );
    }

    public function update(UpdateProfileRequest $request)
    {
        return response()->json(
            $this->auth->updateUserProfile($request->user(), $request->validated())
        );
    }
}

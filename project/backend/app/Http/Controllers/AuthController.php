<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $this->authService->register($request->validated());

        return response()->json([
            'user' => $data['user'],
            'access_token' => $data['access_token'],
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->authService->login($request->validated());

        return response()->json([
            'user' => $data['user'],
            'access_token' => $data['access_token'],
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(): JsonResponse
    {
        // Получаем пользователя через Sanctum guard
        $user = auth()->guard('sanctum')->user();

        if ($user) {
            $this->authService->logout($user);
        }

        return response()->json([
            'message' => 'Успешный выход',
        ]);
    }


    public function profile(): JsonResponse
    {
        $user = auth()->guard('sanctum')->user();
        $userData = $this->authService->getProfile($user);

        return response()->json([
            'user' => $userData,
        ]);
    }
}

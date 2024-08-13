<?php

namespace App\Http\Controllers;

use App\Constants\HttpStatus;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Authenticate user and return token.
     *
     * @param  \App\Http\Requests\AuthLoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $user = $this->authService->authenticate($credentials);

        if ($user) {
            return response()->json($user);
        }

        return response()->json(['message' => 'Usuário ou senha incorretos.'], HttpStatus::HTTP_UNAUTHORIZED);
    }
}

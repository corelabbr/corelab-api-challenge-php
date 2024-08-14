<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Response;

/**
 * @group Authentication endpoints
 *
 * Authentication endpoints
 */
class AuthController extends Controller
{
    /**
     * Login
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    #[Response(content: '{"token": "string"}', status: 200, description: 'Success')]
    #[Response(content: '{"message": "string"}', status: 401, description: 'Unauthorized')]
    #[Response(content: '{"message": "string"}', status: 422, description: 'Validation error')]
    #[Response(content: '{"message": "string"}', status: 500, description: 'Server error')]
    public function login(LoginRequest $request): JsonResponse
    {
        if (!auth()->attempt($request->validated())) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        return response()->json([
            'token' => auth()->user()->createToken(),
            'user' => [
                'email' => auth()->user()->email,
                'name' => auth()->user()->name
            ]
        ]);
    }

    /**
     * Register
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    #[Response(content: '{"token": "string"}', status: 200, description: 'Success')]
    #[Response(content: '{"message": "string"}', status: 401, description: 'Unauthorized')]
    #[Response(content: '{"message": "string"}', status: 422, description: 'Validation error')]
    #[Response(content: '{"message": "string"}', status: 500, description: 'Server error')]
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return response()->json([
            'token' => $user->createToken(),
            'user' => [
                'email' => $user->email,
                'name' => $user->name
            ]
        ]);
    }

    /**
     * Get user data
     *
     * @return JsonResponse
     */
    #[Response(content: '{"user": {"email": "string", "name": "string"}}', status: 200, description: 'Success')]
    #[Response(content: '{"message": "string"}', status: 401, description: 'Unauthorized')]
    #[Response(content: '{"message": "string"}', status: 500, description: 'Server error')]
    public function me(): JsonResponse
    {
        return response()->json([
            'user' => [
                'email' => auth()->user()->email,
                'name' => auth()->user()->name
            ]
        ]);
    }
}

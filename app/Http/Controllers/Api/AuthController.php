<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Tag(
 *     name="Authenticação",
 *     description="Endpoints para Autenticação"
 * )
 */
class AuthController extends Controller
{
    protected AuthService $authService;

    /**
     * AuthController constructor
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Registra um novo usuário.
     *
     * @OA\Post(
     *     path="/api/register",
     *     operationId="registerUser",
     *     tags={"Autenticação"},
     *     summary="Registra um novo usuário",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuário registrado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="user",
     *                 ref="#/components/schemas/User"
     *             ),
     *             @OA\Property(property="token", type="string", example="1|laravel_sanctum_mFOCwcm6...")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Erro de validação")
     * )
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return response()->json([
            'user'  => new UserResource($result['user']),
            'token' => $result['token'],
        ], 201);
    }

    /**
     * Loga usuário e cria um token.
     *
     * @OA\Post(
     *     path="/api/login",
     *     operationId="loginUser",
     *     tags={"Autenticação"},
     *     summary="Loga um usuário",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login bem-sucedido",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="user",
     *                 ref="#/components/schemas/User"
     *             ),
     *             @OA\Property(property="token", type="string", example="1|laravel_sanctum_mFOCwcm6...")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Credenciais inválidas")
     * )
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());

        return response()->json([
            'user'  => new UserResource($result['user']),
            'token' => $result['token'],
        ]);
    }

    /**
     * Desloga usuário (revoga o token).
     *
     * @OA\Post(
     *     path="/api/logout",
     *     operationId="logoutUser",
     *     tags={"Autenticação"},
     *     summary="Desloga um usuário",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout bem-sucedido",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Deslogado com sucesso")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autenticado")
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json([
            'message' => 'Deslogado com sucesso',
        ]);
    }

    /**
     * Obtenha o usuário autenticado.
     *
     * @OA\Get(
     *     path="/api/user",
     *     operationId="getAuthUser",
     *     tags={"Autenticação"},
     *     summary="Obtenha informações do usuário autenticado",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Informações do usuário recuperadas com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autenticado")
     * )
     *
     * @param Request $request
     * @return UserResource
     */
    public function user(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}

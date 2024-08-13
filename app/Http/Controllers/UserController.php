<?php

namespace App\Http\Controllers;

use App\Constants\HttpStatus;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private UserServiceInterface $userService;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserServiceInterface  $userService
     * @return void
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();
        return response()->json($users);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());
        return response()->json($user, HttpStatus::HTTP_CREATED);
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id_user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id_user): JsonResponse
    {
        $user = $this->userService->getUserById($id_user);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], HttpStatus::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  int  $id_user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id_user): JsonResponse
    {
        $user = $this->userService->updateUser($id_user, $request->validated());
        return response()->json($user, HttpStatus::HTTP_OK);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id_user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id_user): JsonResponse
    {
        $deleted = $this->userService->deleteUser($id_user);
        if ($deleted) {
            return response()->json(null, HttpStatus::HTTP_NO_CONTENT);
        }
        return response()->json(['message' => 'User not found'], HttpStatus::HTTP_NOT_FOUND);
    }
}

<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected UserRepositoryInterface $userRepository;

    /**
     * AuthService constructor
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Registra um novo usuário.
     *
     * @param array $data
     * @return array
     */
    public function register(array $data): array
    {
        $user = $this->userRepository->create($data);

        $token = $this->userRepository->createToken($user);

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    /**
     * Loga um usuário.
     *
     * @param array $credentials
     * @return array
     * @throws ValidationException
     */
    public function login(array $credentials): array
    {
        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        $user = $this->userRepository->findByEmail($credentials['email']);

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['Usuário não encontrado.'],
            ]);
        }

        $token = $this->userRepository->createToken($user);

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    /**
     * Desloga um usuário.
     *
     * @param User $user
     * @return bool
     */
    public function logout(User $user): bool
    {
        return $this->userRepository->deleteTokens($user->id);
    }
}

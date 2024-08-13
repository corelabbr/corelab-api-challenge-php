<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    /**
     * Authenticate user and return token.
     *
     * @param  array  $credentials
     * @return array
     */
    public function authenticate(array $credentials): ?array
    {
        $user = User::where('login', $credentials['login'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken('CoreNotes')->plainTextToken;
            $user['token'] = $token;
            return [
                'id_user' => $user->id_user,
                'name' => $user->name,
                'login' => $user->login,
                'token' => $token
            ];
        }

        return null;
    }
}

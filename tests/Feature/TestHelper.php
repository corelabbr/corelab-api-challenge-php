<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait TestHelper
{
    /**
     * Create a user and retrieve an authentication token.
     *
     * @return string
     */
    protected function getAuthToken(): string
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $loginResponse = $this->post('/api/login', [
            'login' => $user->login,
            'password' => 'password'
        ]);

        $loginResponse->assertStatus(200);

        return $loginResponse->json('token');
    }
}

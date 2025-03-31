<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Auth;

use Tests\AuthTestTrait;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use AuthTestTrait;

    public function test_user_can_login_with_correct_credentials(): void
    {
        // Cria usuário
        $user = $this->createMember();

        // Define senha conhecida
        $user->password = bcrypt('password123');
        $user->save();

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'profile',
                    'created_at',
                    'updated_at',
                ],
                'token',
            ]);
    }

    public function test_user_cannot_login_with_incorrect_password(): void
    {
        $user = $this->createMember();

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'senhaincorreta',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_user_cannot_login_with_nonexistent_email(): void
    {
        $response = $this->postJson('/api/login', [
            'email'    => 'nonexistent@email.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_authenticated_user_can_get_profile(): void
    {
        $user = $this->createMember();

        $response = $this->actingAs($user)
            ->getJson('/api/user');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                ],
            ]);
    }

    public function test_unauthenticated_user_cannot_access_profile(): void
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
    }
}

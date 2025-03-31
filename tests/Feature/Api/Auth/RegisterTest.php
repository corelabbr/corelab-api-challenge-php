<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Auth;

use App\Models\Profile;
use Tests\AuthTestTrait;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use AuthTestTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->createProfiles();
    }

    public function test_user_can_register()
    {
        $userData = [
            'name'                  => 'Joãozinho',
            'email'                 => 'joao@email.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(201)
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

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'name'  => $userData['name'],
        ]);

        // Verifica se o usuário recebeu o perfil padrão (member)
        $defaultProfileType = Profile::where('type', 'member')->first()->id;
        $this->assertDatabaseHas('users', [
            'email'      => $userData['email'],
            'profile_id' => $defaultProfileType,
        ]);
    }

    public function test_user_cannot_register_with_existing_email(): void
    {
        // Criar um usuário primeiro
        $existingUser = $this->createMember();

        $userData = [
            'name'                  => 'Another User',
            'email'                 => $existingUser->email,
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_user_cannot_register_with_empty_name(): void
    {
        $invalidData = [
            'name'                  => '',
            'email'                 => 'joao@email.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_user_cannot_register_with_invalid_email(): void
    {
        $invalidData = [
            'name'                  => 'Joãozinho',
            'email'                 => 'email-invalido',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_user_cannot_register_with_invalid_password(): void
    {
        $invalidData = [
            'name'                  => 'Joãozinho',
            'email'                 => 'joao@email.com',
            'password'              => 'senha',
            'password_confirmation' => 'senha-incorreta',
        ];

        $response = $this->postJson('/api/register', $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }
}

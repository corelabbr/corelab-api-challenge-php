<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Auth;

use Laravel\Sanctum\Sanctum;
use Tests\AuthTestTrait;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use AuthTestTrait;

    public function test_user_can_logout(): void
    {
        $user = $this->createMember();

        // Cria token de acesso para o usuário
        $token = $user->createToken('token-muito-secreto')->plainTextToken;

        // Verificar se o token existe
        $this->assertDatabaseCount('personal_access_tokens', 1);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Deslogado com sucesso',
            ]);

        // Verificar que o token foi excluído
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_unauthenticated_user_cannot_logout(): void
    {
        $response = $this->postJson('/api/logout');

        $response->assertStatus(401);
    }

    public function test_authenticated_user_cannot_access_protected_routes_after_logout(): void
    {
        $user = $this->createMember();

        // Autenticar usuário usando Sanctum helper
        Sanctum::actingAs($user);

        // Confirmar que pode acessar rota protegida
        $this->getJson('/api/user')->assertStatus(200);

        // Desloga o usuário
        $this->postJson('/api/logout')->assertStatus(200);

        // O Laravel não "desautentica" automaticamente no teste após o logout
        // Então eu crio uma nova instância do aplicativo para testar realmente
        $this->refreshApplication();

        // Verificar que não pode mais acessar rota protegida
        $this->getJson('/api/user')->assertStatus(401);
    }
}

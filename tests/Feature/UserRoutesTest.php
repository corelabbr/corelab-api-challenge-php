<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRoutesTest extends TestCase
{
    use RefreshDatabase, TestHelper;

    private string $authToken;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authToken = $this->getAuthToken();
    }

    /** @test */
    public function it_can_list_all_users()
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->authToken",
        ])->get('/api/users');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_store_a_new_user()
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->authToken",
        ])->post('/api/users', [
            'login' => 'newuser@example.com',
            'password' => 'password',
            'name' => 'New User',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'login' => 'newuser@example.com',
                'name' => 'New User',
            ]);
    }

    /** @test */
    public function it_can_show_a_user()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->authToken",
        ])->get("/api/users/{$user->id_user}");

        $response->assertStatus(200)
            ->assertJson([
                'id_user' => $user->id_user,
                'login' => $user->login,
                'name' => $user->name,
            ]);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->authToken",
        ])->put("/api/users/{$user->id_user}", [
            'login' => 'updateduser@example.com',
            'password' => 'newpassword',
            'name' => 'Updated User',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'id_user' => $user->id_user,
                'login' => 'updateduser@example.com',
                'name' => 'Updated User',
            ]);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->authToken",
        ])->delete("/api/users/{$user->id_user}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', ['id_user' => $user->id_user]);
    }
}

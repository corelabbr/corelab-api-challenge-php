<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $seed;

    public function test_registration_succeeds() 
    {
        $response = $this->postJson('api/v1/user/register', [
            'name' => 'jose',
            'email' => 'validd@email.com',
            'password' => 'password',
            'c_password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    public function test_login_succeeds() 
    {
        $password = 'password'; 
        $user = User::factory()->create([
            'password' => bcrypt($password) 
        ]);

        $response = $this->postJson('api/v1/user/login', [
            'email' => $user['email'],
            'password' => $password
        ]);

        $response->assertStatus(200);
    }

    public function test_login_fails() 
    {
        $response = $this->postJson('api/v1/user/login', [
            'email' => 'test@gmail.com',
            'password' => 'password'
        ]);

        $response->assertStatus(401);
        $response->assertJson(['Sem autorização']);
    }
}
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    /**
     * Testing for denied access without proper user token
     */
    public function test_access_denied(): void
    {
        $response = $this->get('/api/todo', ['Accept' => 'application/json']);
        $response->assertStatus(401);
    }

    /**
     * Testing for improper header check
     */
    public function test_header_check_fail(): void
    {
        $response = $this->get('/api/todo', ['Accept' => 'application/xml']);
        $response->assertStatus(406);
    }
}

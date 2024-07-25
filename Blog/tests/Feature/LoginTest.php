<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    public $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_login_success()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'user',
                'access_token',
                'token_type'
            ])
            ->assertJson(['status' => 'success']);
    }

    public function test_login_failure()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(403)
            ->assertJson([
                ['message' => 'Credentials does not match our records']
            ]);
    }

    public function test_register_success()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'user',
                'access_token',
                'token_type'
            ])
            ->assertJson(['status' => 'success']);
    }

    public function test_register_failure()
    {
        $response = $this->postJson('/api/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'different'
        ]);

        $response->assertStatus(422);
    }

    public function test_logout()
    {
        $token = auth()->login($this->user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Successfully logged out']);
    }
}

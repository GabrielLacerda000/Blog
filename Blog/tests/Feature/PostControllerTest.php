<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Cria um usuário para autenticação
        $this->user = User::factory()->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    protected function headers()
    {
        return [
            'Authorization' => "Bearer {$this->token}",
        ];
    }

    public function testIndex()
    {
        Post::factory()->count(3)->create();

        $response = $this->getJson('/api/posts', $this->headers());

        $response->assertStatus(200);

        $this->assertCount(3, $response->json('data'));
    }

    public function testStore()
    {
        $postData = [
            'title' => 'New Post',
            'content' => 'Content of the new post',
            'tag_id' => 2,
        ];

        $response = $this->postJson('/api/posts', $postData, $this->headers());

        $response->assertStatus(201);

        $this->assertDatabaseHas('posts', $postData);
    }

    public function testShow()
    {
        $post = Post::factory()->create();

        $response = $this->getJson("/api/posts/{$post->id}", $this->headers());

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
            ],
        ]);
    }

    public function testUpdate()
    {
        $post = Post::factory()->create();

        $updateData = [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
        ];

        $response = $this->putJson("/api/posts/{$post->id}", $updateData, $this->headers());

        $response->assertStatus(200);

        $this->assertDatabaseHas('posts', $updateData);
    }

    public function testDestroy()
    {
        
        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/posts/{$post->id}", $this->headers());

        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}

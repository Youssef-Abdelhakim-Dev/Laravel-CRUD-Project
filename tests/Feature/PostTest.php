<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase; // Resets DB for each test

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create and authenticate a user for all tests
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function posts_index_page_loads()
    {
        $response = $this->get(route('posts.index'));
        $response->assertStatus(200);
        $response->assertViewIs('posts.index'); // Optional: check view
    }

    /** @test */
    public function can_create_a_post()
    {
        $postData = [
            'title' => 'Test Post',
            'content' => 'This is the content of the test post.',
        ];

        $response = $this->post(route('posts.store'), $postData);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'content' => 'This is the content of the test post.',
        ]);
    }

    /** @test */
    public function can_edit_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->get(route('posts.edit', $post->id));
        $response->assertStatus(200);
        $response->assertViewIs('posts.edit'); // Optional: check view
    }

    /** @test */
    public function can_update_a_post()
    {
        $post = Post::factory()->create([
            'title' => 'Old Title',
            'content' => 'Old content',
        ]);

        $updateData = [
            'title' => 'Updated Title',
            'content' => 'Updated content',
        ];

        $response = $this->put(route('posts.update', $post->id), $updateData);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'content' => 'Updated content',
        ]);
    }

    /** @test */
    public function can_delete_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->delete(route('posts.destroy', $post->id));

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}

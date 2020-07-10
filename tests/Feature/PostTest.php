<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\BlogPost;
use App\Comment;

class PostTest extends TestCase
{
    use RefreshDatabase;

    private function createDummyBlogPost($userId = null): BlogPost
    {
        return factory(BlogPost::class)->create([
            'user_id' => $userId ?? $this->user()->id,
        ]);
    }

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSee('No blog posts yet! :(');
    }

    public function testSeeOneBlogPostWhenThereIsOneWithNoComments()
    {
        // Arrange
        $post = $this->createDummyBlogPost();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response
            ->assertSee($post->title)
            ->assertSee("No comments yet :(");

        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title
        ]);
    }

    public function testSeeOneBlogPostWithComments()
    {
        // Arrange
        $numberOfComments = 3;
        $post = $this->createDummyBlogPost();
        factory(Comment::class, $numberOfComments)->create([
            'blog_post_id' => $post->id
        ]);

        // Act
        $response = $this->get('/posts');

        // Assert
        $response
            ->assertSee($post->title)
            ->assertSee($numberOfComments . " comments");

        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title
        ]);
    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'nome do post teste',
            'content' => 'conteudo do post teste'
        ];

        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status', 'Blog post was created!');
    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals(
            $messages['title'][0],
            'The title must be at least 5 characters.'
        );
        $this->assertEquals(
            $messages['content'][0],
            'The content must be at least 10 characters.'
        );
    }

    public function testUpdateValid()
    {
        // Arrange
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);
        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);

        $params = [
            'title' => 'nome do post testeeeee',
            'content' => 'conteudo do post testeeeee'
        ];

        $this->actingAs($user)
            ->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status', 'Blog post was updated!');

        $this->assertDatabaseMissing('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);
        $this->assertDatabaseHas('blog_posts', [
            'title' => $params['title'],
            'content' => $params['content']
        ]);
    }

    public function testDeleteValid()
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);

        $this->actingAs($user)
            ->delete("/posts/{$post->id}",)
            ->assertStatus(302)
            ->assertSessionHas('status', 'Blog post was deleted!');

        $this->assertSoftDeleted('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);
    }
}

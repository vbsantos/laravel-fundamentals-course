<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\BlogPost;
use App\Comment;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSee('No blog posts yet! :(');
    }

    public function testSeeOneBlogPostWhenThereIsOneWithNoComments()
    {
        // Arrange
        $post = factory(BlogPost::class)->create();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSee($post->title);
        $response->assertSee("No comments yet :(");
        $response->assertSee("Edit");
        $response->assertSee("Delete");

        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title
        ]);
    }

    public function testSeeOneBlogPostWithComments()
    {
        // Arrange
        $numberOfComments = 3;
        $post = factory(BlogPost::class)->create();
        factory(Comment::class, $numberOfComments)->create([
            'blog_post_id' => $post->id
        ]);

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSee($post->title);
        $response->assertSee($numberOfComments . " comments");
        $response->assertSee("Edit");
        $response->assertSee("Delete");

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
        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status', 'Blog post was created!');
    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];
        $this->post('/posts', $params)
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
        $post = factory(BlogPost::class)->create();
        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);

        $params = [
            'title' => 'nome do post testeeeee',
            'content' => 'conteudo do post testeeeee'
        ];

        $this->put("/posts/{$post->id}", $params)
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
        $post = factory(BlogPost::class)->create();

        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);

        $this->delete("/posts/{$post->id}",)
            ->assertStatus(302)
            ->assertSessionHas('status', 'Blog post was deleted!');

        $this->assertDatabaseMissing('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);
    }
}

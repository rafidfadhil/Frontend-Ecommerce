<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Topic;
use App\Models\Article;
use App\Models\UserType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminArticleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @RefreshDatabase
     * Fungsi untuk membuat UserType dan User Supplier
     *
     * @return User
     */
    private function createAdminUser()
    {
        // Membuat UserType
        UserType::insert([
            ['id' => 1, 'name' => 'Admin'],
        ]);

        // Membuat pengguna Reseller
        return User::factory()->create([
            'user_type_id' => 1, // ID for admin
        ]);
    }

    public function testUsersTableExists()
    {
        $this->assertTrue(Schema::hasTable('users'), 'The users table does not exist.');
    }
    
    public function test_view_article_index()
    {
        // Ensure that the user with ID 1 exists in the database
        $user = $this->createAdminUser();

        // Membuat topic dan artikel
        $topic = Topic::create(['name' => 'Test Topic', 'slug' => 'test-topic']);
        Article::create([
            'topic_id' => $topic->id,
            'title' => 'Test Article',
            'body' => 'Test Content',
            'content' => 'Test Content',
        ]);

        // Act: Simulate logging in as the user with ID 1 and make a GET request to the index route
        $response = $this->actingAs($user)->get('/admin/articles');

        // Assert: Check if the view is correct and contains the articles
        $response->assertStatus(200);
        $response->assertViewIs('admin.articles.index');
        $response->assertViewHas('articles');
        $response->assertViewHas('title', 'Articles');

        // Assert that the articles are paginated and using existing data
        $viewArticles = $response->viewData('articles');
        $this->assertNotEmpty($viewArticles);
        $this->assertTrue($viewArticles->total() > 0);
    }

    public function test_view_article_create_form()
    {
            // Ensure that the user with ID 1 exists in the database
        $user = $this->createAdminUser();

        // Create some topics to be displayed in the form
        $topic = Topic::create(['name' => 'Test Topic', 'slug' => 'test-topic']);

        // Act: Simulate logging in as the user with ID 1 and make a GET request to the create route
        $response = $this->actingAs($user)->get('/admin/articles/create');

        // Assert: Check if the view is correct and contains the form for creating a new article
        $response->assertStatus(200);
        $response->assertViewIs('admin.articles.create');
        $response->assertViewHas('title', 'Create New Article');
        $response->assertViewHas('topics');

        // Assert that the topics are passed to the view and are not empty
        $viewTopics = $response->viewData('topics');
        $this->assertNotEmpty($viewTopics);
        $this->assertCount(1, $viewTopics);

    }

    public function test_store_article()
    {
        // Ensure that the user with ID 1 exists in the database
        $user = $this->createAdminUser();

        // Create a topic to associate with the article
        $topic = Topic::create([
            'name' => 'Test Topic',
            'slug' => 'test-topic',
        ]);

        // Article data to be sent with the POST request
        $articleData = [
            'title' => 'Test Article',
            'slug' => 'test-article',
            'body' => 'This is a test article.',
            'topic_id' => $topic->id,
        ];

        // Act: Simulate logging in as the user with ID 1 and make a POST request to store the article
        $response = $this->actingAs($user)->post('/admin/articles', $articleData);

        // Assert: Check if the article was stored successfully and redirected to the index route
        $response->assertStatus(302); // Assuming a redirect after successful creation
        $response->assertRedirect('/admin/articles');
        $response->assertSessionHas('success', 'New article has been created!');

        // Assert that the article exists in the database
        $this->assertDatabaseHas('articles', $articleData);
    }

    public function test_show_article()
    {
        $user = $this->createAdminUser();
        
        $topic = Topic::create([
            'name' => 'Test Topic',
            'slug' => 'test-topic',
        ]);
        // Create an article
        $article = Article::create([
            'title' => 'Test Article',
            'slug' => 'test-article',
            'body' => 'Test Content',
            'topic_id' => $topic->id,
        ]);

        // Act: Make a GET request to show the article
        $response = $this->actingAs($user)->get("/admin/articles/{$article->slug}");

        // Assert: Check if the view is correct and contains the article data
        $response->assertStatus(200);
        $response->assertViewIs('admin.articles.show');
        $response->assertViewHas('title', 'Show Article');
        $response->assertViewHas('article');
        $response->assertSeeText('Test Article'); // Ensure the article title is displayed
        $response->assertSeeText('Test Content'); // Ensure the article content is displayed
    }

    public function test_update_article()
    {
        $user = $this->createAdminUser();
        // Create a topic to associate with the article
        $topic = Topic::create([
            'name' => 'Test Topic',
            'slug' => 'test-topic',
        ]);

        // Create an article
        $article = Article::create([
            'title' => 'Test Article',
            'slug' => 'test-article',
            'body' => 'Test Content',
            'topic_id' => $topic->id,
        ]);

        // Updated article data
        $updatedData = [
            'title' => 'Updated Article Title',
            'slug' => 'updated-article-slug',
            'body' => 'Updated Article Content',
            'topic_id' => $topic->id,
        ];

        // Act: Make a PUT request to update the article
        $response = $this->actingAs($user)->put("/admin/articles/{$article->slug}", $updatedData);

        // Assert: Check if the article was updated successfully and redirected to the index route
        $response->assertStatus(302); // Assuming a redirect after successful update
        $response->assertRedirect('/admin/articles');
        $response->assertSessionHas('success', 'Article has been updated!');

        // Assert that the article exists in the database with updated data
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Updated Article Title',
            'slug' => 'updated-article-slug',
            'body' => 'Updated Article Content',
            'topic_id' => $topic->id,
        ]);
    }

    public function test_destroy_article()
    {
        $user = $this->createAdminUser();
        // Create a topic to associate with the article
        $topic = Topic::create([
            'name' => 'Test Topic',
            'slug' => 'test-topic',
        ]);

        // Create an article
        $article = Article::create([
            'title' => 'Test Article',
            'slug' => 'test-article',
            'body' => 'Test Content',
            'topic_id' => $topic->id,
        ]);

        // Act: Make a DELETE request to delete the article
        $response = $this->actingAs($user)->delete("/admin/articles/{$article->slug}");

        // Assert: Check if the article was deleted successfully and redirected to the index route
        $response->assertStatus(302); // Assuming a redirect after successful deletion
        $response->assertRedirect('/admin/articles');
        $response->assertSessionHas('success', 'Article has been deleted!');

        // Assert that the article does not exist in the database
        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }




}

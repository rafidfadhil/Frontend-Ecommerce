<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Topic;
use App\Models\UserType;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTopicTest extends TestCase
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
    
    public function test_view_topic_index()
    {
        // Ensure that the user with ID 1 exists in the database
        $user = $this->createAdminUser();

        // Membuat topic
        Topic::create(['name' => 'Test Topic', 'slug' => 'test-topic']);

        // Act: Simulate logging in as the user with ID 1 and make a GET request to the index route
        $response = $this->actingAs($user)->get('/admin/topics');

        // Assert: Check if the view is correct and contains the topics
        $response->assertStatus(200);
        $response->assertViewIs('admin.topics.index');
        $response->assertViewHas('topics');
        $response->assertViewHas('title', 'Topics');

        // Assert that the topics paginated
        $viewTopics = $response->viewData('topics');
        $this->assertNotEmpty($viewTopics);
        $this->assertTrue($viewTopics->total() > 0);
    }

    public function test_view_topic_create_form()
    {
        // Ensure that the user with ID 1 exists in the database
        $user = $this->createAdminUser();

        // Act: Simulate logging in as the user with ID 1 and make a GET request to the create route
        $response = $this->actingAs($user)->get('/admin/topics/create');

        // Assert: Check if the view is correct and contains the form for creating a new article
        $response->assertStatus(200);
        $response->assertViewIs('admin.topics.create');
        $response->assertViewHas('title', 'Create New Topic');

    }

    public function test_store_topic()
    {
        // Ensure that the user with ID 1 exists in the database
        $user = $this->createAdminUser();

        // Create a topic to associate with the article
        $topic = [
            'name' => 'Test Topic',
            'slug' => 'test-topic',
        ];

        // Act: Simulate logging in as the user with ID 1 and make a POST request to store the article
        $response = $this->actingAs($user)->post('/admin/topics', $topic);

        // Assert: Check if the article was stored successfully and redirected to the index route
        $response->assertStatus(302); // Assuming a redirect after successful creation
        $response->assertRedirect('/admin/topics');
        $response->assertSessionHas('success', 'New topic has been created!');

        // Assert that the article exists in the database
        $this->assertDatabaseHas('topics', $topic);
    }

    public function test_edit_topic_view()
    {
        $user = $this->createAdminUser();
        // Create a topic instance (assuming it has an 'id' column)
        $topic = Topic::create([
            'name' => 'Test Topic',
            'slug' => 'test-topic'
        ]);

        // Act: Make a GET request to edit the topic
        $response = $this->actingAs($user)->get("/admin/topics/{$topic->slug}/edit");

        // Assert: Check if the view is correct and contains the expected data
        $response->assertStatus(200);
        $response->assertViewIs('admin.topics.edit');
        $response->assertViewHas('title', 'Edit Topic');
        $response->assertViewHas('topic', $topic);
    }

    public function test_update_topic()
    {
        $user = $this->createAdminUser();
        // Create a topic to associate with the article
        $topic = Topic::create([
            'name' => 'Test Topic',
            'slug' => 'test-topic',
        ]);

        $updatedTopic = [
            'name' => 'Updated topic',
            'slug' => 'updated-topic'
        ];

        // Act: Make a PUT request to update the article
        $response = $this->actingAs($user)->put("/admin/topics/{$topic->slug}", $updatedTopic);

        // Assert: Check if the article was updated successfully and redirected to the index route
        $response->assertStatus(302); // Assuming a redirect after successful update
        $response->assertRedirect('/admin/topics');
        $response->assertSessionHas('success', 'Topic has been updated!');

        $this->assertDatabaseHas('topics', [
            'name' => 'Updated topic',
            'slug' => 'updated-topic',
        ]);
    }

    public function test_destroy_topic()
    {
        $user = $this->createAdminUser();
        // Create a topic
        $topic = Topic::create([
            'name' => 'Test Topic',
            'slug' => 'test-topic',
        ]);

        // Act: Make a DELETE request to delete the topic
        $response = $this->actingAs($user)->delete("/admin/topics/{$topic->slug}");

        // Assert: Check if the topic was deleted successfully and redirected to the index route
        $response->assertStatus(302); // Assuming a redirect after successful deletion
        $response->assertRedirect('/admin/topics');
        $response->assertSessionHas('success', 'Topic has been deleted!');

        // Assert that the topic does not exist in the database
        $this->assertDatabaseMissing('topics', ['id' => $topic->id]);
    }
}

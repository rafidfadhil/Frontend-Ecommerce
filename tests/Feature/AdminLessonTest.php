<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lesson;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminLessonTest extends TestCase
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

    public function test_view_lesson_index()
    {
        // Ensure that the user with ID 1 exists in the database
        $user = $this->createAdminUser();

        // Membuat course dan artikel
        $course = Course::create([
            'name' => 'Test Course', 
            'description' => 'test course'
        ]);

        Lesson::create([
            'title' => 'Test Lesson',
            'url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'course_id' => $course->id
        ]);

        // Act: Simulate logging in as the user with ID 1 and make a GET request to the index route
        $response = $this->actingAs($user)->get('/admin/lessons');

        // Assert: Check if the view is correct and contains the lessons
        $response->assertStatus(200);
        $response->assertViewIs('admin.lessons.index');
        $response->assertViewHas('lessons');
        $response->assertViewHas('title', 'Lessons');

        // Assert that the lessons are paginated and using existing data
        $viewArticles = $response->viewData('lessons');
        $this->assertNotEmpty($viewArticles);
        $this->assertTrue($viewArticles->total() > 0);
    }

    public function test_view_lesson_create_form()
    {
            // Ensure that the user with ID 1 exists in the database
        $user = $this->createAdminUser();

        // Create some lessons to be displayed in the form
        Course::create([
            'name' => 'Test Course', 
            'description' => 'test description'
        ]);

        // Act: Simulate logging in as the user with ID 1 and make a GET request to the create route
        $response = $this->actingAs($user)->get('/admin/lessons/create');

        // Assert: Check if the view is correct and contains the form for creating a new lesson
        $response->assertStatus(200);
        $response->assertViewIs('admin.lessons.create');
        $response->assertViewHas('title', 'Create New Lesson');
        $response->assertViewHas('courses');

        // Assert that the lessons are passed to the view and are not empty
        $viewCourses = $response->viewData('courses');
        $this->assertNotEmpty($viewCourses);
        $this->assertCount(1, $viewCourses);

    }

    public function test_store_lesson()
    {
        // Ensure that the user with ID 1 exists in the database
        $user = $this->createAdminUser();

        // Create a course to associate with the lesson
        $course = Course::create([
            'name' => 'Test Course',
            'description' => 'test course',
        ]);

        // Lesson data to be sent with the POST request
        $lessonData = [
            'title' => 'Test Lesson',
            'url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'course_id' => $course->id,
        ];

        // Act: Simulate logging in as the user with ID 1 and make a POST request to store the lesson
        $response = $this->actingAs($user)->post('/admin/lessons', $lessonData);

        // Assert: Check if the lesson was stored successfully and redirected to the index route
        $response->assertStatus(302); // Assuming a redirect after successful creation
        $response->assertRedirect('/admin/lessons');
        $response->assertSessionHas('success', 'New lesson has been created!');

        // Assert that the lesson exists in the database
        $this->assertDatabaseHas('lessons', $lessonData);
    }

    public function test_show_lesson()
    {
        $user = $this->createAdminUser();
        
        $course = Course::create([
            'name' => 'Test Course',
            'description' => 'test-course',
        ]);
        // Create an lesson
        $lesson = Lesson::create([
            'title' => 'Test Lesson',
            'url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'course_id' => $course->id,
        ]);

        // Act: Make a GET request to show the lesson
        $response = $this->actingAs($user)->get("/admin/lessons/{$lesson->id}");

        // Assert: Check if the view is correct and contains the lesson data
        $response->assertStatus(200);
        $response->assertViewIs('admin.lessons.show');
        $response->assertViewHas('title', 'Preview Video');
        $response->assertViewHas('lesson');
        $response->assertSeeText('Test Lesson'); // Ensure the lesson title is displayed
    }

    public function test_update_article()
    {
        $user = $this->createAdminUser();
        // Create a course to associate with the lesson
        $course = Course::create([
            'name' => 'Test Course',
            'description' => 'test-course',
        ]);

        // Create an lesson
        $lesson = Lesson::create([
            'title' => 'Test Lesson',
            'url' => "https://www.youtube.com/embed/dSH4dyCQVas?si=gwQNedSQgiyyFpKO",
            'course_id' => $course->id,
        ]);

        // Updated lesson data
        $updatedData = [
            'title' => 'Updated Lesson Title',
            'url' => 'https://www.youtube.com/embed/loA8bKZvSmw?si=cfarOI65M2GRt8w2',
            'course_id' => $course->id,
        ];

        // Act: Make a PUT request to update the lesson
        $response = $this->actingAs($user)->put("/admin/lessons/{$lesson->id}", $updatedData);

        // Assert: Check if the lesson was updated successfully and redirected to the index route
        $response->assertStatus(302); // Assuming a redirect after successful update
        $response->assertRedirect('/admin/lessons');
        $response->assertSessionHas('success', 'Lesson has been updated!');

        // Assert that the lesson exists in the database with updated data
        $this->assertDatabaseHas('lessons', [
            'id' => $lesson->id,
            'title' => 'Updated Lesson Title',
            'url' => 'https://www.youtube.com/embed/loA8bKZvSmw?si=cfarOI65M2GRt8w2',
            'course_id' => $course->id,
        ]);
    }

    public function test_destroy_article()
    {
        $user = $this->createAdminUser();
        // Create a course to associate with the lesson
        $course = Course::create([
            'name' => 'Test Course',
            'description' => 'test course',
        ]);

        // Create an lesson
        $lesson = Lesson::create([
            'title' => 'Test Lesson',
            'url' => 'Test Content',
            'course_id' => $course->id,
        ]);

        // Act: Make a DELETE request to delete the lesson
        $response = $this->actingAs($user)->delete("/admin/lessons/{$lesson->id}");

        // Assert: Check if the lesson was deleted successfully and redirected to the index route
        $response->assertStatus(302); // Assuming a redirect after successful deletion
        $response->assertRedirect('/admin/lessons');
        $response->assertSessionHas('success', 'Lesson has been deleted!');

        // Assert that the lesson does not exist in the database
        $this->assertDatabaseMissing('lessons', ['id' => $lesson->id]);
    }
}

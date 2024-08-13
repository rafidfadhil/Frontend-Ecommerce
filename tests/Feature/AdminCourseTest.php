<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\UserType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCourseTest extends TestCase
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
    
    public function test_view_course_index()
    {
        // Ensure that the user with ID 1 exists in the database
        $user = $this->createAdminUser();

        // Membuat course
        Course::create([
            'name' => 'Test Course', 
            'description' => 'test description', 
            'thumbnail' => UploadedFile::fake()->image('course.jpg')
        ]);

        // Act: Simulate logging in as the user with ID 1 and make a GET request to the index route
        $response = $this->actingAs($user)->get('/admin/courses');

        // Assert: Check if the view is correct and contains the courses
        $response->assertStatus(200);
        $response->assertViewIs('admin.courses.index');
        $response->assertViewHas('courses');
        $response->assertViewHas('title', 'Courses');

        // Assert that the courses paginated
        $viewcourses = $response->viewData('courses');
        $this->assertNotEmpty($viewcourses);
        $this->assertTrue($viewcourses->total() > 0);
    }

    public function test_view_topic_create_form()
    {
        // Ensure that the user with ID 1 exists in the database
        $user = $this->createAdminUser();

        // Act: Simulate logging in as the user with ID 1 and make a GET request to the create route
        $response = $this->actingAs($user)->get('/admin/courses/create');

        // Assert: Check if the view is correct and contains the form for creating a new article
        $response->assertStatus(200);
        $response->assertViewIs('admin.courses.create');
        $response->assertViewHas('title', 'Create New Course');

    }

    public function test_store_course()
    {
        // Ensure that the user with ID 1 exists in the database
        $user = $this->createAdminUser();

        // Create a course to associate with the article
        $course = [
            'name' => 'Test Course',
            'description' => 'test description',
            'thumbnail' => UploadedFile::fake()->image('course.jpg')
        ];

        Storage::fake('public');

        // Act: Simulate logging in as the user with ID 1 and make a POST request to store the article
        $response = $this->actingAs($user)->post('/admin/courses', $course);

        // Assert: Check if the article was stored successfully and redirected to the index route
        $response->assertStatus(302); // Assuming a redirect after successful creation
        $response->assertRedirect('/admin/courses');
        $response->assertSessionHas('success', 'New course has been created!');

        // Assert that the article exists in the database
        $this->assertDatabaseHas('courses', [
            'name' => 'Test Course',
            'description' => 'test description',
        ]);
    }

    public function test_show_course()
    {
        // Create a user
        $user = $this->createAdminUser();

        // Fake the storage
        Storage::fake('public');

        // Create a course with a fake image
        $course = Course::create([
            'name' => 'Test Course',
            'description' => 'test description',
            'thumbnail' => UploadedFile::fake()->image('course.jpg')
        ]);

        // Act as the user and make a GET request to show the course
        $response = $this->actingAs($user)->get("/admin/courses/{$course->id}");

        // Assert the response is OK
        $response->assertStatus(200);

        // Assert the view has the correct data
        $response->assertViewIs('admin.courses.show');
        $response->assertViewHas('course', function ($viewCourse) use ($course) {
            return $viewCourse->id === $course->id;
        });

    }

    public function test_edit_topic_view()
    {
        $user = $this->createAdminUser();
        // Create a course instance (assuming it has an 'id' column)
        $course = Course::create([
            'name' => 'Test Course',
            'description' => 'test course'
        ]);

        // Act: Make a GET request to edit the course
        $response = $this->actingAs($user)->get("/admin/courses/{$course->id}/edit");

        // Assert: Check if the view is correct and contains the expected data
        $response->assertStatus(200);
        $response->assertViewIs('admin.courses.edit');
        $response->assertViewHas('title', 'Edit Course');
        $response->assertViewHas('course', $course);
    }

    public function test_update_topic()
    {
        $user = $this->createAdminUser();
        // Create a course to associate with the article
        $course = Course::create([
            'name' => 'Test Course',
            'description' => 'test course',
            'thumbnail' => UploadedFile::fake()->image('course.jpg')
        ]);

        $updatedCourse = [
            'name' => 'Updated course',
            'description' => 'updated course',
            'thumbnail' => UploadedFile::fake()->image('new-course.jpg')
        ];

        // Act: Make a PUT request to update the article
        $response = $this->actingAs($user)->put("/admin/courses/{$course->id}", $updatedCourse);

        // Assert: Check if the article was updated successfully and redirected to the index route
        $response->assertStatus(302); // Assuming a redirect after successful update
        $response->assertRedirect('/admin/courses');
        $response->assertSessionHas('success', 'Course has been updated!');

        $this->assertDatabaseHas('courses', [
            'name' => 'Updated course',
            'description' => 'updated course',
        ]);
    }

    public function test_destroy_course()
    {
        $user = $this->createAdminUser();
        // Create a course
        $course = Course::create([
            'name' => 'Test Course',
            'description' => 'test course',
        ]);

        // Act: Make a DELETE request to delete the course
        $response = $this->actingAs($user)->delete("/admin/courses/{$course->id}");

        // Assert: Check if the course was deleted successfully and redirected to the index route
        $response->assertStatus(302); // Assuming a redirect after successful deletion
        $response->assertRedirect('/admin/courses');
        $response->assertSessionHas('success', 'Course has been deleted!');

        // Assert that the course does not exist in the database
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}

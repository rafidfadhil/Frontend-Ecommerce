<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserType;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminProductCategoryTest extends TestCase
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
    
    public function test_view_category_index()
    {
        // Ensure that the user with ID 1 exists in the database
        $user = $this->createAdminUser();

        // Membuat topic
        ProductCategory::create(['name' => 'Test Category', 'slug' => 'test-category']);

        // Act: Simulate logging in as the user with ID 1 and make a GET request to the index route
        $response = $this->actingAs($user)->get('/admin/product-categories');

        // Assert: Check if the view is correct and contains the product-categories
        $response->assertStatus(200);
        $response->assertViewIs('admin.product-categories.index');
        $response->assertViewHas('categories');
        $response->assertViewHas('title', 'Product Categories');

        // Assert that the product-categories paginated
        $viewCategories = $response->viewData('categories');
        $this->assertNotEmpty($viewCategories);
        $this->assertTrue($viewCategories->total() > 0);
    }

    public function test_view_category_create_form()
    {
        // Ensure that the user with ID 1 exists in the database
        $user = $this->createAdminUser();

        // Act: Simulate logging in as the user with ID 1 and make a GET request to the create route
        $response = $this->actingAs($user)->get('/admin/product-categories/create');

        // Assert: Check if the view is correct and contains the form for creating a new article
        $response->assertStatus(200);
        $response->assertViewIs('admin.product-categories.create');
        $response->assertViewHas('title', 'Create New Category');

    }

    public function test_store_category()
    {
        // Ensure that the user with ID 1 exists in the database
        $user = $this->createAdminUser();

        // Create a topic to associate with the article
        $category = [
            'name' => 'Test Category',
            'slug' => 'test-category',
        ];

        // Act: Simulate logging in as the user with ID 1 and make a POST request to store the article
        $response = $this->actingAs($user)->post('/admin/product-categories', $category);

        // Assert: Check if the article was stored successfully and redirected to the index route
        $response->assertStatus(302); // Assuming a redirect after successful creation
        $response->assertRedirect('/admin/product-categories');
        $response->assertSessionHas('success', 'New category has been created!');

        // Assert that the article exists in the database
        $this->assertDatabaseHas('product_categories', $category);
    }

    public function test_edit_category_view()
    {
        $user = $this->createAdminUser();
        // Create a topic instance (assuming it has an 'id' column)
        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);

        // Act: Make a GET request to edit the topic
        $response = $this->actingAs($user)->get("/admin/product-categories/{$category->slug}/edit");

        // Assert: Check if the view is correct and contains the expected data
        $response->assertStatus(200);
        $response->assertViewIs('admin.product-categories.edit');
        $response->assertViewHas('title', 'Edit Category');
        $response->assertViewHas('category', $category);

        $viewCategory = $response->viewData('category');
        $this->assertEquals($category->id, $viewCategory->id);
        $this->assertEquals($category->name, $viewCategory->name);
        $this->assertEquals($category->slug, $viewCategory->slug);
    }

    public function test_update_category()
    {
        $user = $this->createAdminUser();
        // Create a topic to associate with the article
        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
        ]);

        $updatedCategory = [
            'name' => 'Updated category',
            'slug' => 'updated-category'
        ];

        // Act: Make a PUT request to update the article
        $response = $this->actingAs($user)->put("/admin/product-categories/{$category->slug}", $updatedCategory);

        // Assert: Check if the article was updated successfully and redirected to the index route
        $response->assertStatus(302); // Assuming a redirect after successful update
        $response->assertRedirect('/admin/product-categories');
        $response->assertSessionHas('success', 'Category has been updated!');

        $this->assertDatabaseHas('product_categories', [
            'name' => 'Updated category',
            'slug' => 'updated-category',
        ]);
    }

    public function test_destroy_category()
    {
        $user = $this->createAdminUser();
        // Create a topic
        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
        ]);

        // Act: Make a DELETE request to delete the topic
        $response = $this->actingAs($user)->delete("/admin/product-categories/{$category->slug}");

        // Assert: Check if the topic was deleted successfully and redirected to the index route
        $response->assertStatus(302); // Assuming a redirect after successful deletion
        $response->assertRedirect('/admin/product-categories');
        $response->assertSessionHas('success', 'Category has been deleted!');

        // Assert that the topic does not exist in the database
        $this->assertDatabaseMissing('product_categories', ['id' => $category->id]);
    }
}

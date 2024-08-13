<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\UserType;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminProductTest extends TestCase
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

        return User::factory()->create([
            'user_type_id' => 1, // ID for admin
        ]);
    }

    private function createSupplierUser()
    {
        // Membuat UserType
        UserType::insert([
            ['id' => 2, 'name' => 'Supplier'],
        ]);

        return User::factory()->create([
            'user_type_id' => 2, // ID for supplier
        ]);
    }

    public function test_product_index()
    {
        $user = $this->createAdminUser();

        $supplier = $this->createSupplierUser();
        // Create products with associated categories for testing
        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);

        Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'user_id' => $supplier->id,
            'stock' => 10,
            'price' => 100000,
            'price_member' => 90000,
            'description' => 'Test Description',
            'product_category_id' => $category->id,
            'image' => 'test.jpg',
        ]);

        // Act: Make a GET request to the index endpoint with query parameters
        $response = $this->actingAs($user)->get('/admin/products', [
            'name' => 'Test Product',
            'product_category_id' => $category->id,
        ]);

        // Assert: Check if the view is correct and contains the expected data
        $response->assertStatus(200);
        $response->assertViewIs('admin.products.index');
        $response->assertViewHas('products');
        $response->assertViewHas('title', 'Products');
        $response->assertViewHas('categories');

        // Assert that the products returned match the filtered criteria
        $viewProducts = $response->viewData('products');
        $this->assertEquals(1, $viewProducts->total()); // Assuming pagination defaults to 10 per page

        // Assert that the categories are passed to the view
        $categories = $response->viewData('categories');
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $categories);
        $this->assertTrue($categories->contains($category));
    }

}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\UserType;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminOrderTest extends TestCase
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

    private function createResellerUser()
    {
        // Membuat UserType
        UserType::insert([
            ['id' => 3, 'name' => 'Reseller'],
        ]);

        return User::factory()->create([
            'user_type_id' => 3, // ID for supplier
        ]);
    }

    public function test_order_index()
    {
        $user = $this->createAdminUser();
        $supplier=$this->createSupplierUser();
        $reseller=$this->createResellerUser();

        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);

        $product = Product::create([
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

        $order = Order::create([
            'order_date' => now(),
            'order_supplier_id' => $supplier->id,
            'order_reseller_id' => $reseller->id,
            'order_product_id' => $product->id,
            'order_quantity' => '5',
            'order_price' => '10000',
            'order_total' => '50000',
            'order_payment' => 'Pending',
            'order_status' => 'Pending',
            'order_number' => '0001',
            'supplier_payment_status' => 'pending',
        ]);

        // Simulate a request with filters
        $response = $this->actingAs($user)
            ->get('/admin/orders?supplier_payment_status=pending');

        // Assert response status and view
        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.index');
        $response->assertViewHas('mergedOrders');
    }

    public function test_show_order_details()
    {
        $user = $this->createAdminUser();
        $supplier=$this->createSupplierUser();
        $reseller=$this->createResellerUser();

        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);

        $product = Product::create([
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

        $order = Order::create([
            'order_date' => now(),
            'order_supplier_id' => $supplier->id,
            'order_reseller_id' => $reseller->id,
            'order_product_id' => $product->id,
            'order_quantity' => '5',
            'order_price' => '10000',
            'order_total' => '50000',
            'order_payment' => 'Pending',
            'order_status' => 'Pending',
            'order_number' => '0001',
            'supplier_payment_status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get('/admin/orders/' . $order->order_number . '/show?supplier_id=' . $order->order_supplier_id);

        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.show');
        $response->assertViewHas('orders');
    }

    public function test_approve_payment()
    {
        $user = $this->createAdminUser();
        $supplier=$this->createSupplierUser();
        $reseller=$this->createResellerUser();

        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);

        $product = Product::create([
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

        $order = Order::create([
            'order_date' => now(),
            'order_supplier_id' => $supplier->id,
            'order_reseller_id' => $reseller->id,
            'order_product_id' => $product->id,
            'order_quantity' => '5',
            'order_price' => '10000',
            'order_total' => '50000',
            'order_payment' => 'Pending',
            'order_status' => 'Pending',
            'order_number' => '0001',
            'supplier_payment_status' => 'pending',
        ]);

        $response = $this->actingAs($user)
        ->post('/admin/orders/' . $order->order_number . '/approve');

        $response->assertRedirect('/admin/orders');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'order_id' => $order->order_id,
            'order_number' => $order->order_number,
            'order_payment' => 'Sukses',
            'order_status' => 'Menunggu Konfirmasi'
        ]);

    }

    public function test_reject_payment()
    {
        $user = $this->createAdminUser();
        $supplier=$this->createSupplierUser();
        $reseller=$this->createResellerUser();

        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);

        $product = Product::create([
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

        $order = Order::create([
            'order_date' => now(),
            'order_supplier_id' => $supplier->id,
            'order_reseller_id' => $reseller->id,
            'order_product_id' => $product->id,
            'order_quantity' => '5',
            'order_price' => '10000',
            'order_total' => '50000',
            'order_payment' => 'Pending',
            'order_status' => 'Pending',
            'order_number' => '0001',
            'supplier_payment_status' => 'pending',
        ]);

        $response = $this->actingAs($user)
        ->post('/admin/orders/' . $order->order_number . '/reject');

        $response->assertRedirect('/admin/orders');
        $response->assertSessionHas('success');

        // Assert that the order status has been updated to 'Sukses'
        $this->assertDatabaseHas('orders', [
            'order_id' => $order->order_id,
            'order_number' => $order->order_number,
            'order_payment' => 'Ditolak',
            'order_status' => 'Ditolak'
        ]);

    }

    public function test_payment_page()
    {
        $user = $this->createAdminUser();
        $supplier=$this->createSupplierUser();
        $reseller=$this->createResellerUser();

        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);

        $product = Product::create([
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

        $order = Order::create([
            'order_date' => now(),
            'order_supplier_id' => $supplier->id,
            'order_reseller_id' => $reseller->id,
            'order_product_id' => $product->id,
            'order_quantity' => '5',
            'order_price' => '10000',
            'order_total' => '50000',
            'order_payment' => 'Pending',
            'order_status' => 'Pending',
            'order_number' => '0001',
            'supplier_payment_status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get("/admin/orders/{$order->order_number}/payment?supplier_id={$order->order_supplier_id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.payment');
        $response->assertViewHas('order_number');
        $response->assertViewHas('supplier');
        $response->assertViewHas('totalPrice');

    }

    public function test_transfer_to_supplier()
    {
        $user = $this->createAdminUser();
        $supplier=$this->createSupplierUser();
        $reseller=$this->createResellerUser();

        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);

        $product = Product::create([
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

        $order = Order::create([
            'order_date' => now(),
            'order_supplier_id' => $supplier->id,
            'order_reseller_id' => $reseller->id,
            'order_product_id' => $product->id,
            'order_quantity' => '5',
            'order_price' => '10000',
            'order_total' => '50000',
            'order_payment' => 'Pending',
            'order_status' => 'Pending',
            'order_number' => '0001',
            'supplier_payment_status' => 'pending',
        ]);

        Storage::fake('public');

        $response = $this->actingAs($user)
        ->post('/admin/orders/' . $order->order_number . '/upload-proof', [
            'admin_transfer_proof' => UploadedFile::fake()->image('proof.jpg')
        ]);

    $response->assertRedirect('/admin/orders');
    $response->assertSessionHas('success');

    // Check the database to ensure the file path is stored correctly
    $this->assertDatabaseHas('orders', [
        'order_id' => $order->order_id,
        'order_number' => $order->order_number,
        'supplier_payment_status' => 'Paid',
    ]);

    }
}

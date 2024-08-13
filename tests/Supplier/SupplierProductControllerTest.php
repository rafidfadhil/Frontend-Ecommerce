<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use App\Models\Notif;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SupplierProductControllerTest extends TestCase
{
    use RefreshDatabase;

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Fungsi untuk membuat UserType dan User Supplier
     *
     * @return User
     */
    private function createSupplierUser()
    {
        // Membuat UserType
        UserType::insert([
            ['id' => 2, 'name' => 'Supplier'],
        ]);

        // Membuat pengguna Supplier
        return User::factory()->create([
            'user_type_id' => 2, // ID untuk Supplier
        ]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk route supplier.product.index.
     *
     * @return void
     */
    public function test_Rute_Index_SupplierProduct()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();
        $this->actingAs($user);

        // Mengakses halaman supplier.product.index
        $response = $this->get(route('supplier.product.index'));

        // Memeriksa respon
        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertViewIs('supplier.product.index');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method index pada SupplierProductController.
     *
     * @return void
     */
    public function test_Method_Index_SupplierProduct()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();
        $this->actingAs($user);

        // Membuat notifikasi
        Notif::create([
            'notif_user_id' => $user->id,
            'notif_type' => 'product',
            'notif_title' => 'New product added',
            'notif_read' => '0',
        ]);

        // Membuat kategori produk
        $category = ProductCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);

        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'user_id' => $user->id,
            'stock' => 10,
            'price' => 100000,
            'price_member' => 90000,
            'description' => 'Test Description',
            'product_category_id' => $category->id,
            'image' => 'test.jpg',
        ]);

        // Mengakses halaman supplier.product.index
        $response = $this->get(route('supplier.product.index'));

        // Memeriksa respon
        $response->assertViewHas('notif');
        $response->assertViewHas('products');
        $response->assertViewHas('categories');

        // Memeriksa apakah produk yang dibuat tadi ada di dalam view
        $response->assertViewHas('products', function ($products) use ($product) {
            return $products->contains($product);
        });
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method store pada SupplierProductController.
     *
     * @return void
     */
    public function test_Method_Store_SupplierProduct()
    {
        // Membuat penyimpanan palsu untuk file
        Storage::fake('public');

        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();
        $this->actingAs($user);

        // Membuat kategori produk
        $category = ProductCategory::create(['name' => 'Test Category']);

        // Data produk baru
        $data = [
            'product_name' => 'New Product',
            'description' => 'New Description',
            'product_category_id' => $category->id,
            'stock' => 20,
            'price' => 200000,
            'price_member' => 180000,
            'image' => UploadedFile::fake()->image('product.jpg')
        ];

        // Mengirim data produk baru
        $response = $this->post(route('supplier.product.store'), $data);

        // Memeriksa respon
        $response->assertRedirect(route('supplier.product.index'));
        $response->assertSessionHas('success', 'Produk berhasil ditambahkan');


        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'user_id' => $user->id,
        ]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method update pada SupplierProductController.
     *
     * @return void
     */
    public function test_Method_Update_SupplierProduct()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();
        $this->actingAs($user);

        // Membuat kategori produk
        $category = ProductCategory::create(['name' => 'Test Category']);
        $product = Product::create([
            'name' => 'Old Product',
            'user_id' => $user->id,
            'product_category_id' => $category->id,
            'stock' => 10,
            'price' => 100000,
            'price_member' => 90000,
            'description' => 'Old Description',
        ]);

        // Data produk yang akan diupdate
        $data = [
            'name' => 'Updated Product',
            'description' => 'Updated Description',
            'product_category_id' => $category->id,
            'stock' => 15,
            'price' => 150000,
            'price_member' => 140000,
        ];

        // Mengirim data produk yang akan diupdate
        $response = $this->put(route('supplier.product.update', $product->id), $data);

        // Memeriksa respon
        $response->assertRedirect(route('supplier.product.index'));
        $response->assertSessionHas('success', 'Produk berhasil diperbarui');

        // Memeriksa apakah data produk berhasil diupdate
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
        ]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method destroy pada SupplierProductController.
     *
     * @return void
     */
    public function test_Method_Destroy_SupplierProduct()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();
        $this->actingAs($user);

        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'user_id' => $user->id,
            'product_category_id' => ProductCategory::create(['name' => 'Test Category'])->id,
            'stock' => 10,
            'price' => 100000,
            'price_member' => 90000,
            'description' => 'Test Description',
        ]);

        // Menghapus produk
        $response = $this->delete(route('supplier.product.destroy', $product->id));

        // Memeriksa respon
        $response->assertRedirect(route('supplier.product.index'));
        $response->assertSessionHas('success', 'Produk berhasil dihapus');

        // Memeriksa apakah produk berhasil dihapus
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method stock pada SupplierProductController.
     *
     * @return void
     */
    public function test_Method_Stock_SupplierProduct()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();
        $this->actingAs($user);

        // Membuat produk
        $category = ProductCategory::create(['name' => 'Test Category']);

        // Membuat produk dengan stock 20
        Product::create([
            'name' => 'Ready Product',
            'user_id' => $user->id,
            'product_category_id' => $category->id,
            'stock' => 20,
            'price' => 100000,
            'price_member' => 90000,
        ]);

        // Membuat produk dengan stock 5
        Product::create([
            'name' => 'Low Stock Product',
            'user_id' => $user->id,
            'product_category_id' => $category->id,
            'stock' => 5,
            'price' => 100000,
            'price_member' => 90000,
        ]);

        // Membuat produk dengan stock 0
        Product::create([
            'name' => 'Empty Stock Product',
            'user_id' => $user->id,
            'product_category_id' => $category->id,
            'stock' => 0,
            'price' => 100000,
            'price_member' => 90000,
        ]);

        // Mengakses halaman supplier.product.stock
        $response = $this->get(route('supplier.product.stock'));

        // Memeriksa respon
        $response->assertStatus(200);
        $response->assertViewIs('supplier.product.stock');
        $response->assertViewHasAll(['notif', 'products', 'product_ready', 'product_low', 'product_empty']);

        // Memeriksa apakah data produk sudah ada di dalam view
        $response->assertViewHas('product_ready', 1);
        $response->assertViewHas('product_low', 1);
        $response->assertViewHas('product_empty', 1);
    }
}

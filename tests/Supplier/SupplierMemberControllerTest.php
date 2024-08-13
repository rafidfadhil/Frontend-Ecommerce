<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use App\Models\Notif;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Member;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SupplierMemberControllerTest extends TestCase
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
     * Pengujian untuk route supplier.member.index.
     *
     * @return void
     */
    public function test_Rute_Index_SupplierMember()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user);

        // Mengakses route /supplier/member
        $response = $this->get(route('supplier.member.index'));

        // Memastikan pengguna benar-benar terautentikasi
        $this->assertAuthenticated();

        // Memastikan status respon 200 OK
        $response->assertStatus(200);

        // Memastikan view yang di render adalah supplier.member.index
        $response->assertViewIs('supplier.member.index');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method index pada SupplierMemberController.
     *
     * @return void
     */
    public function test_Method_Index_SupplierMember()
    {
        // Membuat pengguna Supplier
        $user_supplier = $this->createSupplierUser();

        // Membuat notifikasi
        $notif = Notif::create([
            'notif_user_id' => $user_supplier->id,
            'notif_type' => 'member',
            'notif_title' => 'Member baru terdaftar',
            'notif_read' => '0',
        ]);

        // Membuat produk kategori
        $ProductCategory = ProductCategory::create([
            'name' => 'Makanan',
            'slug' => 'makanan'
        ]);

        // Membuat produk
        $product = Product::create([
            'name' => 'Product A',
            'slug' => 'Product-A',
            'user_id' => $user_supplier->id,
            'stock' => 5,
            'price' => 60000,
            'price_member' => 55000,
            'description' => 'Description of Product 1',
            'product_category_id' => $ProductCategory->id,
            'image' => 'product1.jpg',
            'product_member' => '1',
        ]);

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user_supplier);

        // Mengakses route /supplier/member
        $response = $this->get(route('supplier.member.index'));

        // Memastikan products ada di view
        $response->assertViewHas('products', function ($products) use ($product) {
            return $products->contains($product);
        });

        // Memastikan categories ada di view
        $response->assertViewHas('categories');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method list pada SupplierMemberController.
     *
     * @return void
     */
    public function test_Method_List_SupplierMember()
    {
        // Membuat pengguna Supplier
        $user_supplier = $this->createSupplierUser();

        // Membuat UserType Reseller
        UserType::insert([
            ['id' => 1, 'name' => 'Reseller'],
        ]);

        // Membuat pengguna Reseller
        $user_reseller = User::factory()->create([
            'user_type_id' => 1,
        ]);

        // Membuat member
        $member = Member::create([
            'member_supplier_id' => $user_supplier->id,
            'member_reseller_id' => $user_reseller->id,
        ]);

        // Membuat produk kategori
        $ProductCategory = ProductCategory::create([
            'name' => 'Makanan',
            'slug' => 'makanan'
        ]);

        // Membuat produk
        $product = Product::create([
            'name' => 'Product A',
            'slug' => 'Product-A',
            'user_id' => $user_supplier->id,
            'stock' => 5,
            'price' => 60000,
            'price_member' => 55000,
            'description' => 'Description of Product 1',
            'product_category_id' => $ProductCategory->id,
            'image' => 'product1.jpg',
        ]);

        // Membuat order
        $order = Order::create([
            'order_number' => '0001',
            'order_status' => 'Pending',
            'order_date' => now(),
            'order_reseller_id' => $user_reseller->id,
            'order_supplier_id' => $user_supplier->id,
            'order_product_id' => $product->id,
            'order_quantity' => '5',
            'order_price' => '10000',
            'order_total' => '50000',
            'order_payment' => 'Selesai',
        ]);

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user_supplier);

        // Mengakses route /supplier/member/list
        $response = $this->get(route('supplier.member.list'));

        // Memastikan status respon 200 OK
        $response->assertStatus(200);

        // Memastikan view yang di render adalah supplier.member.list
        $response->assertViewIs('supplier.member.list');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method store pada SupplierMemberController.
     *
     * @return void
     */
    public function test_Method_Store_SupplierMember()
    {
        // Menggunakan fake storage untuk pengujian upload file
        Storage::fake('public');

        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user);

        // Membuat produk kategori
        $category = ProductCategory::create(['name' => 'Test Category']);

        // Membuat file image palsu
        $image = UploadedFile::fake()->image('product.jpg');

        // Mengirim request untuk store produk dengan data baru termasuk image
        $response = $this->post(route('supplier.product.member.store'), [
            'product_name' => 'New Product',
            'description' => 'New Description',
            'product_category_id' => $category->id,
            'stock' => 20,
            'price' => 200000,
        ]);

        // Memastikan redirect ke route supplier.member.index setelah store
        $response->assertRedirect(route('supplier.member.index'));
        $response->assertSessionHas('success', 'Paket Produk berhasil ditambahkan');

        // Memastikan data produk disimpan dengan benar
        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'description' => 'New Description',
            'product_category_id' => $category->id,
            'stock' => 20,
            'price' => 200000,
            'price_member' => 200000,
            'product_member' => '1',
            'user_id' => $user->id,
        ]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method update pada SupplierMemberController.
     *
     * @return void
     */
    public function test_Method_Update_SupplierMember()
    {
        // Menggunakan fake storage untuk pengujian upload file
        Storage::fake('public');

        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user);

        // Membuat produk kategori
        $category = ProductCategory::create(['name' => 'Test Category']);

        // Membuat produk
        $product = Product::create([
            'name' => 'Old Product',
            'description' => 'Old Description',
            'product_category_id' => $category->id,
            'stock' => 10,
            'price' => 100000,
            'price_member' => 90000,
            'product_member' => '1',
            'user_id' => $user->id,
        ]);


        // Membuat file image palsu
        $image = UploadedFile::fake()->image('new_product.jpg');

        // Mengirim request untuk update produk dengan data baru termasuk image
        $response = $this->put(route('supplier.product.member.update', $product->id), [
            'name' => 'Updated Product',
            'description' => 'Updated Description',
            'product_category_id' => $category->id,
            'stock' => 15,
            'price' => 150000,
            // 'image' => $image,
        ]);

        // Memastikan redirect ke route supplier.member.index setelah update
        $response->assertRedirect(route('supplier.member.index'));
        $response->assertSessionHas('success', 'Paket Produk berhasil diperbarui');

        // Memastikan data produk diperbarui dengan benar
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'description' => 'Updated Description',
            'product_category_id' => $category->id,
            'stock' => 15,
            'price' => 150000,
        ]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method destroy pada SupplierMemberController.
     *
     * @return void
     */
    public function test_Method_Destroy_SupplierMember()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user);

        // Membuat produk kategori
        $category = ProductCategory::create(['name' => 'Test Category']);

        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'description' => 'Test Description',
            'product_category_id' => $category->id,
            'stock' => 10,
            'price' => 100000,
            'price_member' => 90000,
            'product_member' => '1',
            'user_id' => $user->id,
        ]);

        // Mengirim request untuk menghapus produk
        $response = $this->delete(route('supplier.product.member.destroy', $product->id));

        // Memastikan redirect ke route supplier.member.index setelah delete
        $response->assertRedirect(route('supplier.member.index'));
        $response->assertSessionHas('success', 'Paket Produk berhasil dihapus');

        // Memastikan produk telah dihapus dari database
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method destroy pada SupplierMemberController dengan order yang ada.
     *
     * @return void
     */
    public function test_Method_Destroy_SupplierMember_With_Order()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();

        // Membuat UserType Reseller
        UserType::insert([
            ['id' => 1, 'name' => 'Reseller'],
        ]);

        // Membuat pengguna Reseller
        $user_reseller = User::factory()->create([
            'user_type_id' => 1,
        ]);

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user);

        // Membuat produk kategori
        $category = ProductCategory::create(['name' => 'Test Category']);

        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'description' => 'Test Description',
            'product_category_id' => $category->id,
            'stock' => 10,
            'price' => 100000,
            'price_member' => 90000,
            'product_member' => '1',
            'user_id' => $user->id,
        ]);

        // Membuat order untuk produk ini
        Order::create([
            'order_number' => '0001',
            'order_status' => 'Pending',
            'order_date' => now(),
            'order_reseller_id' => $user_reseller->id,
            'order_supplier_id' => $user->id,
            'order_product_id' => $product->id,
            'order_quantity' => '5',
            'order_price' => '10000',
            'order_total' => '50000',
            'order_payment' => 'Pending',
        ]);

        // Mengirim request untuk menghapus produk
        $response = $this->delete(route('supplier.product.member.destroy', $product->id));

        // Memastikan redirect ke route supplier.member.index dengan pesan error
        $response->assertRedirect(route('supplier.member.index'));
        $response->assertSessionHas('error', 'Produk tidak bisa dihapus karena sudah ada order');

        // Memastikan produk masih ada di database
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }
}

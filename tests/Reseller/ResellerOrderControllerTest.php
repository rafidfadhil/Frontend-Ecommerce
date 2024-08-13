<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use App\Models\Notif;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ResellerOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    // =====================================================================================================
    /**
     * Fungsi untuk membuat UserType dan User Reseller
     *
     * @return User
     */
    private function createResellerUser()
    {
        // Membuat UserType Reseller
        UserType::insert([
            ['id' => 3, 'name' => 'Reseller'],
        ]);

        // Membuat User Reseller
        return User::factory()->create([
            'user_type_id' => 3, // ID untuk Reseller
        ]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Rute_Index_Reseller_Order()
    {
        // Membuat User Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi User Reseller
        $this->actingAs($user);

        // Mengunjungi halaman rute reseller.order.index
        $response = $this->get(route('reseller.order.index'));

        // Melakukan pengecekan bahwa halaman rute reseller.order.index berhasil diakses
        $this->assertAuthenticated();
        $response->assertStatus(200);
        // Melakukan pengecekan bahwa halaman rute reseller.order.index merupakan halaman view reseller.order.index
        $response->assertViewIs('reseller.order.index');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Index_Reseller_Order()
    {
        // Membuat UserType Supplier
        UserType::insert([
            ['id' => 2, 'name' => 'Supplier'],
        ]);

        // Membuat pengguna Supplier
        $user_supplier = User::factory()->create([
            'user_type_id' => 2,
        ]);

        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi pengguna Reseller
        $this->actingAs($user);

        // Membuat notifikasi
        Notif::create([
            'notif_user_id' => $user->id,
            'notif_type' => 'order',
            'notif_title' => 'New Order',
            'notif_read' => '0',
        ]);

        // Membuat kategori produk
        $category = ProductCategory::create(['name' => 'Test Category']);

        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'user_id' => $user_supplier->id,
            'product_category_id' => $category->id,
            'stock' => 10,
            'product_member' => '0',
        ]);

        // Membuat keranjang belanja
        Cart::create([
            'cart_reseller_id' => $user->id,
            'cart_product_id' => $product->id,
            'cart_quantity' => '1',
            'cart_order' => '1',
        ]);

        // Membuat pesanan
        Order::create([
            'order_number' => '0001',
            'order_status' => 'Pending',
            'order_date' => now(),
            'order_reseller_id' => $user->id,
            'order_supplier_id' => $user_supplier->id,
            'order_product_id' => $product->id,
            'order_quantity' => '5',
            'order_price' => '10000',
            'order_total' => '50000',
            'order_payment' => 'Pending',
        ]);

        // Mengunjungi halaman rute reseller.order.index
        $response = $this->get(route('reseller.order.index'));

        // Melakukan pengecekan bahwa halaman rute reseller.order.index berhasil diakses
        $response->assertViewHas('mergedOrders');
        $response->assertViewHas('notif');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Store_Reseller_Order()
    {
        // Membuat UserType Supplier
        UserType::insert([
            ['id' => 2, 'name' => 'Supplier'],
        ]);

        // Membuat pengguna Supplier
        $user_supplier = User::factory()->create([
            'user_type_id' => 2,
        ]);

        Storage::fake('public');

        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi pengguna Reseller
        $this->actingAs($user);

        // Membuat kategori produk
        $category = ProductCategory::create(['name' => 'Test Category']);

        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'user_id' => $user_supplier->id,
            'product_category_id' => $category->id,
            'stock' => 10,
            'product_member' => '0',
        ]);

        // Membuat file gambar
        $file = UploadedFile::fake()->image('receipt.jpg');

        // Mengunjungi halaman rute reseller.order.store
        $response = $this->put(route('reseller.order.store'), [
            'product_id' => [$product->id],
            'order_supplier_id' => [$user_supplier->id],
            'order_quantity' => [2],
            'order_price' => [100],
            'order_total' => [200],
            'order_date' => now(),
            'image' => $file,
        ]);

        // Melakukan pengecekan bahwa halaman rute reseller.order.store berhasil diakses
        $response->assertRedirect(route('reseller.order.index'));
        $response->assertSessionHas('success', 'Pesanan Berhasil di Bayar, Tunggu beberapa saat untuk konfirmasi dari supplier');

        // Melakukan pengecekan bahwa data pesanan berhasil disimpan
        $this->assertDatabaseHas('orders', [
            'order_reseller_id' => $user->id,
            'order_product_id' => $product->id,
        ]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Cancel_Reseller_Order()
    {
        // Membuat UserType Supplier
        UserType::insert([
            ['id' => 2, 'name' => 'Supplier'],
        ]);

        // Membuat pengguna Supplier
        $user_supplier = User::factory()->create([
            'user_type_id' => 2,
        ]);

        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi pengguna Reseller
        $this->actingAs($user);

        // Membuat kategori produk
        $category = ProductCategory::create(['name' => 'Test Category']);

        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'user_id' => $user_supplier->id,
            'product_category_id' => $category->id,
            'stock' => 10,
            'product_member' => '0',
        ]);

        // Membuat keranjang belanja
        $cart = Cart::create([
            'cart_reseller_id' => $user->id,
            'cart_product_id' => $product->id,
            'cart_quantity' => '1',
            'cart_order' => '1',
            'updated_at' => now(),
        ]);

        // Mengunjungi halaman rute reseller.order.cancel
        $response = $this->post(route('reseller.order.cancel'), [
            'cart_id' => $cart->updated_at,
        ]);

        // Melakukan pengecekan bahwa halaman rute reseller.order.cancel berhasil diakses
        $response->assertJson([
            'status' => 'success',
            'message' => 'Pesanan Berhasil di Batalkan'
        ]);


        $this->assertDatabaseHas('carts', [
            'cart_id' => $cart->cart_id,
            'cart_order' => '0',
        ]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Show_Reseller_Order()
    {
        // Membuat UserType Supplier
        UserType::insert([
            ['id' => 2, 'name' => 'Supplier'],
        ]);

        // Membuat pengguna Supplier
        $user_supplier = User::factory()->create([
            'user_type_id' => 2,
        ]);

        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi pengguna Reseller
        $this->actingAs($user);

        // Membuat kategori produk
        $category = ProductCategory::create(['name' => 'Test Category']);

        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'user_id' => $user_supplier->id,
            'product_category_id' => $category->id,
            'stock' => 10,
            'product_member' => '0',
        ]);

        // Membuat pesanan
        $order = Order::create([
            'order_date' => now(),
            'order_supplier_id' => $user_supplier->id,
            'order_reseller_id' => $user->id,
            'order_product_id' => $product->id,
            'order_quantity' => '5',
            'order_price' => '10000',
            'order_total' => '50000',
            'order_payment' => 'Pending',
            'order_status' => 'Pending',
            'order_number' => '0001',
        ]);

        // Mengunjungi halaman rute reseller.order.show
        $response = $this->get(route('reseller.order.show', $order->order_number));

        // Melakukan pengecekan bahwa halaman rute reseller.order.show berhasil diakses
        $response->assertStatus(200);
        // Melakukan pengecekan bahwa halaman rute reseller.order.show merupakan halaman view reseller.order.show
        $response->assertViewIs('reseller.order.show');
        $response->assertViewHas('orders');
        $response->assertViewHas('notif');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Update_Reseller_Order()
    {
        // Membuat UserType Supplier
        UserType::insert([
            ['id' => 2, 'name' => 'Supplier'],
        ]);

        // Membuat pengguna Supplier
        $user_supplier = User::factory()->create([
            'user_type_id' => 2,
        ]);

        // Membuat pengguna Reseller
        Storage::fake('public');

        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi pengguna Reseller
        $this->actingAs($user);

        // Membuat kategori produk
        $category = ProductCategory::create(['name' => 'Test Category']);

        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'user_id' => $user_supplier->id,
            'product_category_id' => $category->id,
            'stock' => 10,
            'product_member' => '0',
        ]);

        // Membuat pesanan
        $order = Order::create([
            'order_date' => now(),
            'order_supplier_id' => $user_supplier->id,
            'order_reseller_id' => $user->id,
            'order_product_id' => $product->id,
            'order_quantity' => '5',
            'order_price' => '10000',
            'order_total' => '50000',
            'order_payment' => 'Pending',
            'order_status' => 'Pending',
            'order_number' => '0001',
        ]);

        // Mengunjungi halaman rute reseller.order.update
        $file = UploadedFile::fake()->image('review.jpg');

        // Membuat pesanan
        $response = $this->post(route('reseller.order.update', $order->order_id), [
            'order_rating' => 5,
            'order_review' => 'Great service!',
            'order_reseller_id' => $user->id,
            'order_supplier_id' => $user_supplier->id,
            'product_member' => '1',
        ]);

        // Melakukan pengecekan bahwa halaman rute reseller.order.update berhasil diakses
        $response->assertRedirect(route('reseller.order.index'));
        // Melakukan pengecekan bahwa pesanan berhasil di konfirmasi
        $response->assertSessionHas('success', 'Pesanan Berhasil di Konfirmasi dan di Beri Rating');

        // Melakukan pengecekan bahwa data pesanan berhasil disimpan
        $this->assertDatabaseHas('orders', [
            'order_id' => $order->order_id,
            'order_rating' => 5,
            'order_review' => 'Great service!',
            'order_status' => 'Selesai',
        ]);
    }
}

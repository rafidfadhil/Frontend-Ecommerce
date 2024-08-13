<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResellerCartControllerTest extends TestCase
{
    use RefreshDatabase;

    // =====================================================================================================
    /**
     * Fungsi untuk membuat UserType dan User Supplier
     *
     * @return User
     */
    private function createResellerUser()
    {
        // Membuat UserType
        UserType::insert([
            ['id' => 3, 'name' => 'Reseller'],
        ]);

        // Membuat pengguna Reseller
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
    public function test_Rute_Index_Cart()
    {
        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Mengunjungi halaman keranjang
        $response = $this->get(route('reseller.cart'));

        // Memastikan bahwa pengguna sudah terautentikasi
        $this->assertAuthenticated();
        // Memastikan bahwa halaman keranjang berhasil diakses
        $response->assertStatus(200);
        // Memastikan bahwa halaman yang ditampilkan adalah halaman keranjang
        $response->assertViewIs('reseller.cart.index');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Index_Cart()
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
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat kategori produk
        $category = ProductCategory::create(['name' => 'Test Category']);
        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'product_category_id' => $category->id,
            'user_id' => $user_supplier->id,
            'price' => 100,
            'stock' => 10,
        ]);

        // Membuat keranjang
        Cart::create([
            'cart_reseller_id' => $user->id,
            'cart_product_id' => $product->id,
            'cart_quantity' => 1,
            'cart_order' => '0',
        ]);

        // Mengunjungi halaman keranjang
        $response = $this->get(route('reseller.cart'));

        // Memastikan bahwa pengguna sudah terautentikasi
        $response->assertViewHas('carts');
        $response->assertViewHas('members');
        $response->assertViewHas('notif');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Store_Cart()
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
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat kategori produk
        $category = ProductCategory::create(['name' => 'Test Category']);
        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'product_category_id' => $category->id,
            'user_id' => $user_supplier->id,
            'stock' => 10,
        ]);

        // Mengunjungi halaman keranjang
        $response = $this->get(route('reseller.cart.store', $product->id));

        // Memastikan bahwa pengguna sudah terautentikasi
        $response->assertRedirect('/reseller/cart');
        // Memastikan bahwa produk berhasil dimasukkan ke keranjang
        $response->assertSessionHas('success', 'Produk berhasil masuk ke keranjang');

        // Memastikan bahwa produk berhasil dimasukkan ke keranjang
        $this->assertDatabaseHas('carts', [
            'cart_reseller_id' => $user->id,
            'cart_product_id' => $product->id,
            'cart_quantity' => 1,
        ]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Update_Cart()
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
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat kategori produk
        $category = ProductCategory::create(['name' => 'Test Category']);
        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'product_category_id' => $category->id,
            'user_id' => $user_supplier->id,
            'stock' => 10,
        ]);

        // Membuat keranjang
        $cart = Cart::create([
            'cart_reseller_id' => $user->id,
            'cart_product_id' => $product->id,
            'cart_quantity' => 1,
        ]);

        // Mengunjungi halaman keranjang
        $response = $this->putJson(route('reseller.cart.update', $cart->cart_id), [
            'cart_quantity' => 2,
        ]);

        // Memastikan bahwa pengguna sudah terautentikasi
        $response->assertJson(['status' => 'success']);

        // Memastikan bahwa produk berhasil diupdate
        $this->assertDatabaseHas('carts', [
            'cart_id' => $cart->cart_id,
            'cart_quantity' => 2,
        ]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Destroy_Cart()
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
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat kategori produk
        $category = ProductCategory::create(['name' => 'Test Category']);
        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'product_category_id' => $category->id,
            'user_id' => $user_supplier->id,
            'stock' => 10,
        ]);

        // Membuat keranjang
        $cart = Cart::create([
            'cart_reseller_id' => $user->id,
            'cart_product_id' => $product->id,
            'cart_quantity' => 1,
        ]);

        // Mengunjungi halaman keranjang
        $response = $this->post(route('reseller.cart.destroy', $cart->cart_id));

        // Memastikan bahwa pengguna sudah terautentikasi
        $response->assertRedirect();
        // Memastikan bahwa produk berhasil dihapus
        $response->assertSessionHas('success', 'Produk berhasil dihapus');

        // Memastikan bahwa produk berhasil dihapus
        $this->assertDatabaseMissing('carts', ['cart_id' => $cart->cart_id]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Order_Cart()
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
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat kategori produk
        $category = ProductCategory::create(['name' => 'Test Category']);

        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'product_category_id' => $category->id,
            'user_id' => $user_supplier->id,
            'stock' => 10,
        ]);

        // Membuat keranjang
        $cart = Cart::create([
            'cart_reseller_id' => $user->id,
            'cart_product_id' => $product->id,
            'cart_quantity' => 1,
            'cart_order' => '0',
        ]);

        // Mengunjungi halaman keranjang
        $response = $this->post(route('reseller.cart.order'), [
            'product_ids' => [$product->id],
        ]);

        // Memastikan bahwa pengguna sudah terautentikasi
        $response->assertRedirect();
        // Memastikan bahwa produk berhasil diorder
        $response->assertSessionHas('success', 'Pesanan berhasil dibuat, silahkan proses pembayaran.');

        // Memastikan bahwa produk berhasil diorder
        $this->assertDatabaseHas('carts', [
            'cart_id' => $cart->cart_id,
            'cart_order' => '1',
        ]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Order_Now_Cart()
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
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat kategori produk
        $category = ProductCategory::create(['name' => 'Test Category']);

        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'product_category_id' => $category->id,
            'user_id' => $user_supplier->id,
            'stock' => 10,
        ]);

        // Membuat keranjang
        $response = $this->post(route('reseller.cart.ordernow'), [
            'product_id' => $product->id,
        ]);

        // Memastikan bahwa pengguna sudah terautentikasi
        $response->assertRedirect();
        // Memastikan bahwa produk berhasil diorder
        $response->assertSessionHas('success', 'Pesanan berhasil dibuat, silahkan proses pembayaran.');

        // Memastikan bahwa produk berhasil diorder
        $this->assertDatabaseHas('carts', [
            'cart_reseller_id' => $user->id,
            'cart_product_id' => $product->id,
            'cart_quantity' => 1,
            'cart_order' => 1,
        ]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Order_Show_Cart()
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
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat kategori produk
        $category = ProductCategory::create(['name' => 'Test Category']);

        // Membuat produk
        $product = Product::create([
            'name' => 'Test Product',
            'product_category_id' => $category->id,
            'user_id' => $user_supplier->id,
            'stock' => 10,
        ]);

        // Membuat keranjang
        $cart = Cart::create([
            'cart_reseller_id' => $user->id,
            'cart_product_id' => $product->id,
            'cart_quantity' => 1,
            'cart_order' => '1',
        ]);

        // Mengunjungi halaman keranjang
        $response = $this->get(route('reseller.cart.order.show', $cart->updated_at));

        // Memastikan bahwa pengguna sudah terautentikasi
        $response->assertStatus(200);
        // Memastikan bahwa produk berhasil diorder
        $response->assertViewIs('reseller.cart.order');
        $response->assertViewHas('carts');
        $response->assertViewHas('members');
        $response->assertViewHas('notif');
    }
}

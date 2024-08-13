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

class ResellerControllerTest extends TestCase
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
    public function test_Rute_Index_Reseller()
    {
        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Mengunjungi halaman reseller
        $response = $this->get(route('reseller.index'));

        // Memeriksa bahwa pengguna telah terautentikasi
        $this->assertAuthenticated();
        // Memeriksa bahwa halaman reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman reseller yang dimuat adalah halaman reseller
        $response->assertViewIs('reseller.dashboard');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Index_Reseller()
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

        // Membuat notifikasi untuk pengguna Reseller
        Notif::create([
            'notif_user_id' => $user->id,
            'notif_type' => 'member',
            'notif_title' => 'Anda terdaftar sebagai member baru',
            'notif_read' => '0',
        ]);

        // Membuat kategori produk
        $category = ProductCategory::create(['name' => 'Test Category']);

        // Membuat produk
        Product::create([
            'name' => 'Test Product',
            'user_id' => $user_supplier->id,
            'product_category_id' => $category->id,
            'stock' => 10,
            'product_member' => '0',
        ]);

        // Membuat member
        Member::create([
            'member_reseller_id' => $user->id,
            'member_supplier_id' => $user_supplier->id,
        ]);

        // Mengunjungi halaman reseller
        $response = $this->get(route('reseller.index'));
        // Memeriksa bahwa halaman reseller berhasil dimuat
        $response->assertViewHas('product_categories');
        $response->assertViewHas('products');
        $response->assertViewHas('members');
        $response->assertViewHas('notif');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Edit_Reseller()
    {
        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat notifikasi untuk pengguna Reseller
        Notif::create([
            'notif_user_id' => $user->id,
            'notif_type' => 'member',
            'notif_title' => 'Anda terdaftar sebagai member baru',
            'notif_read' => '0',
        ]);

        // Mengunjungi halaman edit profil reseller
        $response = $this->get(route('reseller.edit', $user->id));

        // Memeriksa bahwa halaman edit profil reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman edit profil reseller yang dimuat adalah halaman edit profil reseller
        $response->assertViewIs('reseller.profile');
        // Memeriksa bahwa halaman edit profil reseller yang dimuat memiliki data pengguna
        $response->assertViewHas('user');
        // Memeriksa bahwa halaman edit profil reseller yang dimuat memiliki notifikasi
        $response->assertViewHas('notif');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Update_Reseller()
    {
        // Membuat pengguna Reseller
        Storage::fake('public');

        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Mengunggah file gambar
        $file = UploadedFile::fake()->image('avatar.jpg');

        // Mengirimkan data untuk diperbarui
        $response = $this->put(route('reseller.update', $user->id), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'address' => 'Updated Address',
            'phone' => '1234567890',
            'bio' => 'Updated Bio',
            'avatar' => $file,
        ]);

        // Memeriksa bahwa data berhasil diperbarui
        $response->assertRedirect(route('reseller.edit', $user->id));
        // Memeriksa bahwa sesi memiliki pesan sukses
        $response->assertSessionHas('success', 'Profil berhasil diperbarui');

        // Memeriksa bahwa data pengguna telah diperbarui
        $user->refresh();
        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('updated@example.com', $user->email);
        $this->assertEquals('Updated Address', $user->address);
        $this->assertEquals('1234567890', $user->phone);
        $this->assertEquals('Updated Bio', $user->bio);
        $this->assertNotNull($user->avatar);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Show_Product_Reseller()
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

        // Membuat produk
        $category = ProductCategory::create(['name' => 'Test Category']);
        $supplier = User::factory()->create();
        $product = Product::create([
            'name' => 'Test Product',
            'user_id' => $supplier->id,
            'product_category_id' => $category->id,
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

        // Mengunjungi halaman produk reseller
        $response = $this->get(route('reseller.product.show', $product->id));

        // Memeriksa bahwa halaman produk reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman produk reseller yang dimuat adalah halaman produk reseller
        $response->assertViewIs('reseller.product.show');
        // Memeriksa bahwa halaman produk reseller yang dimuat memiliki data produk
        $response->assertViewHas('product');
        // Memeriksa bahwa halaman produk reseller yang dimuat memiliki data pesanan
        $response->assertViewHas('total_review');
        // Memeriksa bahwa halaman produk reseller yang dimuat memiliki data ulasan
        $response->assertViewHas('avg_rating');
        $response->assertViewHas('review_count');
        $response->assertViewHas('star_percentages');
        $response->assertViewHas('reviews');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Compare_Product_Reseller()
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

        // Membuat produk
        $category = ProductCategory::create(['name' => 'Test Category']);
        // Membuat produk 1 dan produk 2
        $product1 = Product::create([
            'name' => 'Test Product 1',
            'user_id' => $user_supplier->id,
            'product_category_id' => $category->id,
            'stock' => 10,
            'product_member' => '0',
        ]);
        $product2 = Product::create([
            'name' => 'Test Product 2',
            'user_id' => $user_supplier->id,
            'product_category_id' => $category->id,
            'stock' => 10,
            'product_member' => '0',
        ]);

        // Mengunjungi halaman perbandingan produk reseller
        $response = $this->get(route('reseller.product.compare', [$product1->id, $product2->id]));

        // Memeriksa bahwa halaman perbandingan produk reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman perbandingan produk reseller yang dimuat adalah halaman perbandingan produk reseller
        $response->assertViewIs('reseller.product.compare');
        // Memeriksa bahwa halaman perbandingan produk reseller yang dimuat memiliki data produk
        $response->assertViewHas('products');
        $response->assertViewHas('product_1');
        $response->assertViewHas('product_2s');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Notif_Reseller()
    {
        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat notifikasi untuk pengguna Reseller
        Notif::create([
            'notif_user_id' => $user->id,
            'notif_type' => 'member',
            'notif_title' => 'Anda terdaftar sebagai member baru',
            'notif_read' => '0',
        ]);

        // Mengunjungi halaman notifikasi reseller
        $response = $this->get(route('reseller.notif.index'));

        // Memeriksa bahwa halaman notifikasi reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman notifikasi reseller yang dimuat adalah halaman notifikasi reseller
        $response->assertViewIs('reseller.notif');
        // Memeriksa bahwa halaman notifikasi reseller yang dimuat memiliki notifikasi
        $response->assertViewHas('notifs');
        $response->assertViewHas('notif');

        // Memeriksa bahwa notifikasi telah dibaca
        $this->assertDatabaseHas('notifs', [
            'notif_user_id' => $user->id,
            'notif_read' => '1',
        ]);
    }
}

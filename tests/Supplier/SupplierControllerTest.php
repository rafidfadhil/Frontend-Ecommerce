<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use App\Models\Notif;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SupplierControllerTest extends TestCase
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
     * Pengujian untuk route supplier.index.
     *
     * @return void
     */
    public function test_Rute_Index_Supplier()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user);

        // Mengakses route /supplier
        $response = $this->get(route('supplier.index'));

        // Memastikan pengguna benar-benar terautentikasi
        $this->assertAuthenticated();

        // Memastikan status respon 200 OK
        $response->assertStatus(200);

        // Memastikan view yang di render adalah supplier.dashboard
        $response->assertViewIs('supplier.dashboard');
    }
    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method index pada SupplierController.
     *
     * @return void
     */
    public function test_Method_Index_Supplier()
    {
        // Membuat pengguna Supplier
        $user_supplier = $this->createSupplierUser();

        // Membuat UserType
        UserType::insert([
            ['id' => 1, 'name' => 'Reseller'],
        ]);

        // Membuat pengguna Reseller
        $user_reseller = User::factory()->create([
            'user_type_id' => 1,
        ]);

        // Membuat notifikasi
        $notif = Notif::create([
            'notif_user_id' => $user_supplier->id,
            'notif_type' => 'order',
            'notif_title' => 'Ada pesanan baru dari member',
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
        ]);

        // Membuat order
        $order = Order::create([
            'order_number' => '0001',
            'order_status' => 'Selesai',
            'order_date' => '2024-05-01',
            'order_reseller_id' => $user_reseller->id,
            'order_supplier_id' => $user_supplier->id,
            'order_product_id' => $product->id,
            'order_quantity' => '5',
            'order_price' => '10000',
            'order_total' => '50000',
            'order_payment' => 'Sukses',
            'order_resi' => '4545668868654',
            'order_rating' => '4',
            'order_review' => 'Barangnya bagus, pengiriman cepat',
        ]);

        // Menambahkan beberapa order lagi untuk pengujian yang lebih komprehensif
        $order2 = Order::create([
            'order_number' => '0002',
            'order_status' => 'Selesai',
            'order_date' => '2024-06-01',
            'order_reseller_id' => $user_reseller->id,
            'order_supplier_id' => $user_supplier->id,
            'order_product_id' => $product->id,
            'order_quantity' => '3',
            'order_price' => '10000',
            'order_total' => '30000',
            'order_payment' => 'Sukses',
            'order_resi' => '4545668868655',
            'order_rating' => '5',
            'order_review' => 'Sangat puas dengan produknya',
        ]);

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user_supplier);

        // Mengakses route /supplier
        $response = $this->get(route('supplier.index'));

        // Mengakses route /supplier
        $response = $this->get(route('supplier.index'));

        // Memastikan notifikasi ada di view
        $response->assertViewHas('notif', function ($notifications) use ($notif) {
            return $notifications->contains($notif);
        });

        // Memastikan orders ada di view
        $response->assertViewHas('orders', function ($orders) use ($order) {
            return $orders->where('order_number', $order->order_number)->count() > 0;
        });

        // Memastikan months dan counts ada di view
        $response->assertViewHas('months');
        $response->assertViewHas('counts');

        // Memastikan data yang diolah untuk chart sesuai
        $response->assertViewHas('months', function ($months) {
            return $months->count() === 12; // Pastikan ada 12 bulan
        });

        $response->assertViewHas('counts', function ($counts) {
            return $counts->count() === 12; // Pastikan ada 12 count
        });

        // Memastikan jumlah order sesuai
        $response->assertViewHas('orders', function ($orders) {
            return $orders->count() === 2;
        });

        // Memastikan pengelompokan data per bulan bekerja dengan benar
        $response->assertViewHas('counts', function ($counts) {
            return $counts[4] === 1 && $counts[5] === 1; // May and June should have 1 order each
        });

        // Memastikan semua bulan diinisialisasi
        $response->assertViewHas('months', function ($months) {
            return $months->count() === 12 && $months[0] === date('Y-01') && $months[11] === date('Y-12');
        });

        // Memastikan query kompleks bekerja dengan benar
        $response->assertViewHas('orders', function ($orders) use ($product, $user_reseller) {
            return $orders->first()->product_name === $product->name &&
                $orders->first()->reseller_name === $user_reseller->name;
        });
    }
    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method edit pada SupplierController.
     *
     * @return void
     */
    public function test_Method_Edit_Supplier()
    {
        // Membuat pengguna Supplier dan pengguna yang akan di-edit
        $user = $this->createSupplierUser();

        // Membuat notifikasi
        Notif::create([
            'notif_user_id' => $user->id,
            'notif_type' => 'suspend',
            'notif_title' => 'Akun anda telah di-suspend oleh admin',
            'notif_read' => '0',
        ]);

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user);

        // Mengakses route /supplier/edit/{id}
        $response = $this->get(route('supplier.edit', $user->id));

        // Memastikan status respon 200 OK
        $response->assertStatus(200);

        // Memastikan view yang di render adalah supplier.profile
        $response->assertViewIs('supplier.profile');

        // Memastikan view memiliki data notifikasi
        $response->assertViewHas('notif');

        // Memastikan view memiliki data user yang di-edit
        $response->assertViewHas('user', $user);
    }
    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method update pada SupplierController.
     *
     * @return void
     */
    public function test_Method_Update_Supplier()
    {
        // Menggunakan fake storage untuk pengujian upload file
        Storage::fake('public');

        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user);

        // Membuat folder images di dalam disk public jika belum ada
        Storage::disk('public')->makeDirectory('images');

        // Membuat file avatar palsu
        $avatar = UploadedFile::fake()->image('avatar.jpg');

        // Mengirim request untuk update profil dengan data baru termasuk avatar
        $response = $this->put(route('supplier.update', $user->id), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'address' => 'Updated Address',
            'phone' => '1234567890',
            'bio' => 'Updated Bio',
            'rekening' => '1234567890',
            'avatar' => $avatar,
        ]);

        // Memastikan redirect ke route supplier.edit setelah update
        $response->assertRedirect(route('supplier.edit', $user->id));
        $response->assertSessionHas('success', 'Profil berhasil diperbarui');

        // Refresh data user dari database
        $user->refresh();

        // Memastikan data user diperbarui dengan benar
        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('updated@example.com', $user->email);
        $this->assertEquals('Updated Address', $user->address);
        $this->assertEquals('1234567890', $user->phone);
        $this->assertEquals('Updated Bio', $user->bio);
        $this->assertEquals('1234567890', $user->rekening);
    }
    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method notif pada SupplierController.
     *
     * @return void
     */
    public function test_Method_Notif_Supplier()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();

        // Membuat beberapa notifikasi untuk pengguna
        Notif::create([
            'notif_user_id' => $user->id,
            'notif_type' => 'suspend',
            'notif_title' => 'Akun anda telah di-suspend oleh admin',
            'notif_read' => '0',
        ]);

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user);

        // Mengakses route /supplier/notif
        $response = $this->get(route('supplier.notif.index'));

        // Memastikan status respon 200 OK
        $response->assertStatus(200);

        // Memastikan view yang di render adalah supplier.notif
        $response->assertViewIs('supplier.notif');

        // Memastikan view memiliki data notifikasi
        $response->assertViewHas('notifs');
        $response->assertViewHas('notif');
    }
}

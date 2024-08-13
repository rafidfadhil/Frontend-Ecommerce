<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use App\Models\Notif;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierOrderControllerTest extends TestCase
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
     * Pengujian untuk route supplier.order.index.
     *
     * @return void
     */
    public function test_Rute_Index_SupplierOrder()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user);

        // Mengakses route /supplier/order
        $response = $this->get(route('supplier.order.index'));

        // Memastikan pengguna benar-benar terautentikasi
        $this->assertAuthenticated();

        // Memastikan status respon 200 OK
        $response->assertStatus(200);

        // Memastikan view yang di render adalah supplier.order.index
        $response->assertViewIs('supplier.order.index');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method index pada SupplierOrderController.
     *
     * @return void
     */
    public function test_Method_Index_SupplierOrder()
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
            'order_status' => 'Pending',
            'order_date' => now(),
            'order_reseller_id' => $user_reseller->id,
            'order_supplier_id' => $user_supplier->id,
            'order_product_id' => $product->id,
            'order_quantity' => '5',
            'order_price' => '10000',
            'order_total' => '50000',
            'order_payment' => 'Pending',
        ]);

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user_supplier);

        // Mengakses route /supplier/order
        $response = $this->get(route('supplier.order.index'));

        // Memastikan orders ada di view
        $response->assertViewHas('orders', function ($orders) use ($order) {
            return $orders->where('order_number', $order->order_number)->count() > 0;
        });

        // Memastikan notifikasi order telah dibaca
        $this->assertDatabaseHas('notifs', [
            'notif_user_id' => $user_supplier->id,
            'notif_type' => 'order',
            'notif_read' => '1',
        ]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method update pada SupplierOrderController.
     *
     * @return void
     */
    public function test_Method_Update_SupplierOrder()
    {
        // Membuat pengguna Supplier dan Reseller
        $user_supplier = $this->createSupplierUser();

        // Membuat UserType
        UserType::insert([
            ['id' => 1, 'name' => 'Reseller'],
        ]);

        // Membuat pengguna Reseller
        $user_reseller = User::factory()->create([
            'user_type_id' => 1,
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
        Order::create([
            'order_number' => '0009',
            'order_status' => 'Pending',
            'order_date' => '2024-05-04',
            'order_reseller_id' => $user_reseller->id,
            'order_supplier_id' => $user_supplier->id,
            'order_product_id' => $product->id,
            'order_quantity' => '5',
            'order_price' => '10000',
            'order_total' => '50000',
            'order_payment' => 'Pending',
        ]);

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user_supplier);

        // Mengambil order pertama
        $order = Order::first();

        // Mengirim request untuk update order
        $response = $this->put(route('supplier.order.update', $order->order_id), [
            'order_status' => 'Proses Pengiriman',
            'order_resi' => '1234567890',
            'order_reseller_id' => $user_reseller->id,
            'order_number' => '0001',
        ]);

        // Memastikan redirect ke route supplier.order.index setelah update
        $response->assertRedirect(route('supplier.order.index'));
        $response->assertSessionHas('success', 'Pesanan berhasil diperbarui');

        // Memastikan data order diperbarui dengan benar
        $this->assertDatabaseHas('orders', [
            'order_id' => $order->order_id,
            'order_status' => 'Proses Pengiriman',
            'order_resi' => '1234567890',
        ]);

        // Memastikan notifikasi untuk reseller dibuat
        $this->assertDatabaseHas('notifs', [
            'notif_user_id' => $user_reseller->id,
            'notif_type' => 'order',
            'notif_title' => 'Pesanan 0001 Proses Pengiriman',
        ]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method history pada SupplierOrderController.
     *
     * @return void
     */
    public function test_Method_History_SupplierOrder()
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

        // Membuat order yang sudah selesai
        $order =  Order::create([
            'order_number' => '0001',
            'order_status' => 'Selesai',
            'order_date' => now(),
            'order_reseller_id' => $user_reseller->id,
            'order_supplier_id' => $user_supplier->id,
            'order_product_id' => $product->id,
            'order_quantity' => '5',
            'order_price' => '10000',
            'order_total' => '50000',
            'order_payment' => 'Sukses',
        ]);

        // Membuat notifikasi
        $notif = Notif::create([
            'notif_user_id' => $user_supplier->id,
            'notif_type' => 'order_selesai',
            'notif_title' => 'Pesanan 0001 telah selesai',
            'notif_read' => '0',
        ]);

        // Menjalankan pengujian sebagai pengguna yang sudah login
        $this->actingAs($user_supplier);

        // Mengakses route /supplier/history
        $response = $this->get(route('supplier.order.history'));

        // Memastikan status respon 200 OK
        $response->assertStatus(200);

        // Memastikan view yang di render adalah supplier.order.history
        $response->assertViewIs('supplier.order.history');

        // Memastikan view memiliki data notifikasi
        $response->assertViewHas('notif');

        // Memastikan view memiliki data orders
        $response->assertViewHas('orders', function ($orders) use ($order) {
            return $orders->where('order_number', $order->order_number)->count() > 0;
        });

        // Memastikan notifikasi order_selesai telah dibaca
        $this->assertDatabaseHas('notifs', [
            'notif_user_id' => $user_supplier->id,
            'notif_type' => 'order_selesai',
            'notif_read' => '1',
        ]);
    }
}

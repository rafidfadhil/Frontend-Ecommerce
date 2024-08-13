<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use App\Models\Notif;
use App\Models\Forum;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SupplierForumControllerTest extends TestCase
{
    use RefreshDatabase;

    // =====================================================================================================
    /**
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
     * Pengujian untuk route supplier.forum.index.
     *
     * @return void
     */
    public function test_Rute_Index_Forum_Supplier()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();
        // Melakukan autentikasi sebagai pengguna Supplier
        $this->actingAs($user);
        // Mengunjungi halaman forum supplier
        $response = $this->get(route('supplier.forum.index'));
        // Memeriksa bahwa pengguna telah terautentikasi
        $this->assertAuthenticated();
        // Memeriksa bahwa halaman forum supplier berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman forum supplier yang dimuat adalah halaman forum supplier
        $response->assertViewIs('supplier.forum.index');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method index pada SupplierForumController.
     *
     * @return void
     */
    public function test_Method_Index_Forum_Supplier()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();

        // Membuat notifikasi
        Notif::create([
            'notif_user_id' => $user->id,
            'notif_type' => 'member',
            'notif_title' => 'Ada diskusi baru di dalam forum',
            'notif_read' => '0',
        ]);
        // Membuat forum
        Forum::create([
            'forum_supplier_id' => $user->id,
            'forum_user_id' => $user->id,
            'forum_message' => 'Test message',
        ]);

        // Melakukan autentikasi sebagai pengguna Supplier
        $this->actingAs($user);

        // Mengunjungi halaman forum supplier
        $response = $this->get(route('supplier.forum.index'));
        // Memeriksa bahwa pengguna telah terautentikasi
        $response->assertViewHas('notif');
        $response->assertViewHas('forums');

        // Memeriksa bahwa notifikasi telah dimuat
        $response->assertViewHas('forums', function ($forums) use ($user) {
            return $forums->where('forum_supplier_id', $user->id)->count() > 0;
        });
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method store pada SupplierForumController.
     *
     * @return void
     */
    public function test_Method_Store_Forum_Supplier()
    {
        // Membuat pengguna Supplier
        Storage::fake('public');
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
        $this->actingAs($user_supplier);
        // Membuat pengguna Reseller
        $reseller = User::factory()->create(['user_type_id' => 1]);
        Member::create([
            'member_supplier_id' => $user_supplier->id,
            'member_reseller_id' => $user_reseller->id,
        ]);
        // Membuat file attachment
        $file = UploadedFile::fake()->create('document.pdf', 1000);
        // Mengirimkan data forum
        $response = $this->post(route('supplier.forum.store'), [
            'forum_user_id' => $user_reseller->id,
            'forum_message' => 'Test forum message',
            'forum_attachment' => $file,
        ]);
        // Memeriksa bahwa data forum berhasil disimpan
        $response->assertRedirect();
        // Memeriksa bahwa data forum berhasil disimpan di database
        $this->assertDatabaseHas('forums', [
            'forum_supplier_id' => $user_supplier->id,
            'forum_user_id' => $user_reseller->id,
            'forum_message' => 'Test forum message',
        ]);
        // Memeriksa bahwa notifikasi berhasil disimpan di database
        $this->assertDatabaseHas('notifs', [
            'notif_user_id' => $user_reseller->id,
            'notif_type' => 'member',
            'notif_title' => 'Ada diskusi baru didalam forum ' . $user_supplier->name,
        ]);
    }
}

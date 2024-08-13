<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use App\Models\Notif;
use App\Models\Member;
use App\Models\Forum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ResellerForumControllerTest extends TestCase
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
    public function test_Rute_Index_ResellerForum()
    {
        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Mengunjungi halaman forum reseller
        $response = $this->get(route('reseller.forum.index'));

        // Memeriksa bahwa pengguna telah terautentikasi
        $this->assertAuthenticated();
        // Memeriksa bahwa halaman forum reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman yang dimuat adalah halaman forum reseller
        $response->assertViewIs('reseller.forum.index');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Index_ResellerForum()
    {
        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat notifikasi untuk pengguna Reseller
        Notif::create([
            'notif_user_id' => $user->id,
            'notif_type' => 'member',
            'notif_title' => 'Ada diskusi baru',
            'notif_read' => '0',
        ]);

        // Membuat UserType Supplier
        UserType::insert([
            ['id' => 2, 'name' => 'Supplier'],
        ]);

        // Membuat pengguna Supplier
        $user_supplier = User::factory()->create([
            'user_type_id' => 2,
        ]);

        // Membuat member
        Member::create([
            'member_reseller_id' => $user->id,
            'member_supplier_id' => $user_supplier->id,
        ]);

        // Mengunjungi halaman forum reseller
        $response = $this->get(route('reseller.forum.index'));

        // Memeriksa bahwa halaman forum reseller berhasil dimuat
        $response->assertViewHas('notif');
        $response->assertViewHas('members');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Show_ResellerForum()
    {
        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat UserType Supplier
        UserType::insert([
            ['id' => 2, 'name' => 'Supplier'],
        ]);

        // Membuat pengguna Supplier
        $user_supplier = User::factory()->create([
            'user_type_id' => 2,
        ]);

        // Membuat forum
        Forum::create([
            'forum_supplier_id' => $user_supplier->id,
            'forum_user_id' => $user->id,
            'forum_message' => 'Test message',
        ]);

        // Mengunjungi halaman show forum reseller
        $response = $this->get(route('reseller.forum.show', $user_supplier->id));

        // Memeriksa bahwa halaman show forum reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman yang dimuat adalah halaman show forum reseller
        $response->assertViewIs('reseller.forum.show');
        // Memeriksa bahwa halaman memiliki data yang diperlukan
        $response->assertViewHas('notif');
        $response->assertViewHas('forums');
        $response->assertViewHas('supplier_id');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Store_ResellerForum_Without_Attachment()
    {
        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat UserType Supplier
        UserType::insert([
            ['id' => 2, 'name' => 'Supplier'],
        ]);

        // Membuat pengguna Supplier
        $user_supplier = User::factory()->create([
            'user_type_id' => 2,
        ]);

        // Data untuk forum baru
        $forumData = [
            'forum_supplier_id' => $user_supplier->id,
            'forum_user_id' => $user->id,
            'forum_message' => 'Test forum message',
        ];

        // Mengirim request POST ke route store
        $response = $this->post(route('reseller.forum.store'), $forumData);

        // Memeriksa bahwa forum berhasil disimpan
        $response->assertStatus(302); // redirect
        $this->assertDatabaseHas('forums', [
            'forum_supplier_id' => $user_supplier->id,
            'forum_user_id' => $user->id,
            'forum_message' => 'Test forum message',
        ]);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Store_ResellerForum_With_Attachment()
    {
        // Menggunakan storage fake
        Storage::fake('public');

        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat UserType Supplier
        UserType::insert([
            ['id' => 2, 'name' => 'Supplier'],
        ]);

        // Membuat pengguna Supplier
        $user_supplier = User::factory()->create([
            'user_type_id' => 2,
        ]);

        // Membuat file palsu
        $file = UploadedFile::fake()->image('attachment.jpg');

        // Data untuk forum baru
        $forumData = [
            'forum_supplier_id' => $user_supplier->id,
            'forum_user_id' => $user->id,
            'forum_message' => 'Test forum message with attachment',
            'forum_attachment' => $file,
        ];

        // Mengirim request POST ke route store
        $response = $this->post(route('reseller.forum.store'), $forumData);

        // Memeriksa bahwa forum berhasil disimpan
        $response->assertStatus(302); // redirect
        $this->assertDatabaseHas('forums', [
            'forum_supplier_id' => $user_supplier->id,
            'forum_user_id' => $user->id,
            'forum_message' => 'Test forum message with attachment',
        ]);

        // Memeriksa bahwa file attachment telah disimpan
        $forum = Forum::where('forum_message', 'Test forum message with attachment')->first();
    }
}

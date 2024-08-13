<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use App\Models\Notif;
use App\Models\Topic;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierArtikelControllerTest extends TestCase
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
     * Pengujian untuk route supplier.artikel.index.
     *
     * @return void
     */
    public function test_Rute_Index_Artikel_Supplier()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();
        // Melakukan autentikasi sebagai pengguna Supplier
        $this->actingAs($user);

        // Mengunjungi halaman artikel supplier
        $response = $this->get(route('supplier.artikel.index'));

        // Memeriksa bahwa pengguna telah terautentikasi
        $this->assertAuthenticated();
        // Memeriksa bahwa halaman artikel supplier berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman artikel supplier yang dimuat adalah halaman artikel supplier
        $response->assertViewIs('supplier.artikel.index');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk method index pada SupplierArtikelController.
     *
     * @return void
     */
    public function test_Method_Index_Artikel_Supplier()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();

        // Membuat notifikasi
        Notif::create([
            'notif_user_id' => $user->id,
            'notif_type' => 'member',
            'notif_title' => 'Test Notification',
            'notif_read' => '0',
        ]);

        // Membuat topic dan artikel
        $topic = Topic::create(['name' => 'Test Topic']);
        Article::create([
            'topic_id' => $topic->id,
            'title' => 'Test Article',
            'body' => 'Test Content',
            'content' => 'Test Content',
        ]);

        // Melakukan autentikasi sebagai pengguna Supplier
        $this->actingAs($user);
        // Mengunjungi halaman artikel supplier
        $response = $this->get(route('supplier.artikel.index'));
        // Memeriksa bahwa pengguna telah terautentikasi
        $response->assertViewHas('notif');
        $response->assertViewHas('data');

        // Memeriksa bahwa notifikasi telah dimuat
        $response->assertViewHas('notif', function ($notif) use ($user) {
            return $notif->where('notif_user_id', $user->id)->count() > 0;
        });

        // Memeriksa bahwa notifikasi telah dimuat
        $response->assertViewHas('data', function ($data) {
            return $data->count() > 0 && $data->first()->articles->count() > 0;
        });
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     * Pengujian untuk memastikan hanya topic dengan artikel yang ditampilkan.
     *
     * @return void
     */
    public function test_Only_Topics_With_Articles_Are_Shown()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();

        // Membuat topic dengan artikel
        $topicWithArticle = Topic::create(['name' => 'Topic With Article']);
        Article::create([
            'topic_id' => $topicWithArticle->id,
            'title' => 'Test Article',
            'body' => 'Test Content',
            'content' => 'Test Content',
        ]);

        // Membuat topic tanpa artikel
        Topic::create(['name' => 'Topic Without Article']);
        // Melakukan autentikasi sebagai pengguna Supplier
        $this->actingAs($user);
        // Mengunjungi halaman artikel supplier
        $response = $this->get(route('supplier.artikel.index'));
        // Memeriksa bahwa pengguna telah terautentikasi
        $response->assertViewHas('data', function ($data) {
            return $data->count() == 1 && $data->first()->name == 'Topic With Article';
        });
    }
}

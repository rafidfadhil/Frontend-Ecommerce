<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use App\Models\Notif;
use App\Models\Topic;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResellerArtikelControllerTest extends TestCase
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
    public function test_Rute_Index_ResellerArtikel()
    {
        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Mengunjungi halaman artikel reseller
        $response = $this->get(route('reseller.artikel.index'));

        // Memeriksa bahwa pengguna telah terautentikasi
        $this->assertAuthenticated();
        // Memeriksa bahwa halaman artikel reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman yang dimuat adalah halaman artikel reseller
        $response->assertViewIs('reseller.artikel.index');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Index_ResellerArtikel()
    {
        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat notifikasi untuk pengguna Reseller
        Notif::create([
            'notif_user_id' => $user->id,
            'notif_type' => 'Test',
            'notif_title' => 'Notifikasi Test',
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

        // Mengunjungi halaman artikel reseller
        $response = $this->get(route('reseller.artikel.index'));

        // Memeriksa bahwa halaman artikel reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman artikel reseller yang dimuat adalah halaman artikel reseller
        $response->assertViewIs('reseller.artikel.index');
        // Memeriksa bahwa halaman artikel reseller yang dimuat memiliki data
        $response->assertViewHas('data');
        // Memeriksa bahwa halaman artikel reseller yang dimuat memiliki notifikasi
        $response->assertViewHas('notif');

        // Memeriksa bahwa data topic dan artikel sesuai
        $viewData = $response->original->getData()['data'];
        $this->assertCount(1, $viewData);
        $this->assertEquals('Test Topic', $viewData[0]->name);
        $this->assertCount(1, $viewData[0]->articles);
        $this->assertEquals('Test Article', $viewData[0]->articles[0]->title);

        // Memeriksa bahwa notifikasi sesuai
        $viewNotif = $response->original->getData()['notif'];
        $this->assertCount(1, $viewNotif);
        $this->assertEquals('Notifikasi Test', $viewNotif[0]->notif_title);
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Index_ResellerArtikel_No_Articles()
    {
        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat topic tanpa artikel
        Topic::create(['name' => 'Test Topic Without Article']);

        // Mengunjungi halaman artikel reseller
        $response = $this->get(route('reseller.artikel.index'));

        // Memeriksa bahwa halaman artikel reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman artikel reseller yang dimuat adalah halaman artikel reseller
        $response->assertViewIs('reseller.artikel.index');
        // Memeriksa bahwa halaman artikel reseller yang dimuat memiliki data
        $response->assertViewHas('data');

        // Memeriksa bahwa tidak ada data topic yang dikembalikan (karena tidak ada artikel)
        $viewData = $response->original->getData()['data'];
        $this->assertCount(0, $viewData);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use App\Models\Notif;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResellerMemberControllerTest extends TestCase
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
    public function test_Rute_Index_ResellerMember()
    {
        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Mengunjungi halaman member reseller
        $response = $this->get(route('reseller.member.index'));

        // Memeriksa bahwa pengguna telah terautentikasi
        $this->assertAuthenticated();
        // Memeriksa bahwa halaman member reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman yang dimuat adalah halaman member reseller
        $response->assertViewIs('reseller.member.index');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Index_ResellerMember()
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

        // Membuat UserType Supplier
        UserType::insert([
            ['id' => 2, 'name' => 'Supplier'],
        ]);

        // Membuat pengguna Supplier
        $supplier = User::factory()->create([
            'user_type_id' => 2,
        ]);

        // Membuat member
        Member::create([
            'member_reseller_id' => $user->id,
            'member_supplier_id' => $supplier->id,
        ]);

        // Mengunjungi halaman member reseller
        $response = $this->get(route('reseller.member.index'));

        // Memeriksa bahwa halaman member reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman member reseller yang dimuat adalah halaman member reseller
        $response->assertViewIs('reseller.member.index');
        // Memeriksa bahwa halaman member reseller yang dimuat memiliki data member
        $response->assertViewHas('members');
        // Memeriksa bahwa halaman member reseller yang dimuat memiliki notifikasi
        $response->assertViewHas('notif');

        // Memeriksa bahwa notifikasi telah dibaca
        $this->assertDatabaseHas('notifs', [
            'notif_user_id' => $user->id,
            'notif_title' => 'Anda terdaftar sebagai member baru',
            'notif_read' => '1',
        ]);

        // Memeriksa bahwa data member sesuai
        $members = $response->original->getData()['members'];
        $this->assertCount(1, $members);
        $this->assertEquals($supplier->name, $members[0]->name);
    }
}

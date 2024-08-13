<?php

use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Memastikan halaman registrasi dapat dirender dengan baik.
     *
     * @return void
     */
    public function test_registration_screen_can_be_rendered(): void
    {
        // Melakukan permintaan GET ke '/register'
        $response = $this->get('/register');

        // Memastikan status respons adalah 200 (OK)
        $response->assertStatus(200);
    }

    /**
     * Memastikan pengguna baru dapat mendaftar dengan benar.
     *
     * @return void
     */
    public function test_new_users_can_register(): void
    {
        // Membuat UserType
        UserType::insert([
            ['name' => 'Admin'], // ID=4
            ['name' => 'Reseller'], // ID=5
            ['name' => 'Supplier'], // ID=6
        ]);

        // Data pengguna yang akan didaftarkan
        $userData = [
            'name' => 'Test User',
            'user_type_id' => 4, // Dengan asumsi 1 adalah ID jenis pengguna yang valid
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'address' => '123 Test Street',
            'phone' => '1234567890',
        ];

        // Melakukan permintaan POST untuk mendaftarkan pengguna baru
        $response = $this->post(route('register'), $userData);

        // Memastikan pengguna berhasil dibuat di database
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'user_type_id' => 4, // Dengan asumsi 1 adalah ID jenis pengguna yang valid
            'email' => 'test@example.com',
        ]);

        // Mendapatkan informasi pengguna yang baru dibuat
        $user = User::where('email', 'test@example.com')->first();

        // Memastikan password pengguna berhasil di-hash
        $this->assertTrue(Hash::check('password', $user->password));

        // Memastikan info pengguna berhasil dibuat di database
        $this->assertDatabaseHas('user_infos', [
            'user_id' => $user->id,
            'address' => '123 Test Street',
            'phone' => '1234567890',
        ]);


        // Memeriksa apakah pengguna telah diarahkan ke halaman login
        $response->assertRedirect(route('login', absolute: false));
    }
}

<?php

namespace TestsFeature;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function user_can_login_with_correct_credentials()
    {
        // Membuat UserType
        UserType::insert([
            ['name' => 'Admin'],
            ['name' => 'Reseller'],
            ['name' => 'Supplier'],
        ]);

        // Membuat pengguna
        $user = User::factory()->create([
            'user_type_id' => 1, // Dengan asumsi 1 adalah ID jenis pengguna yang valid
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        // Melakukan permintaan login
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        // Memastikan pengguna berhasil masuk
        $this->assertAuthenticatedAs($user);

        // Memastikan pengguna diarahkan ke dashboard
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    /** @test */
    public function user_cannot_login_with_incorrect_password()
    {
        // Membuat UserType
        UserType::insert([
            ['name' => 'Admin'],
            ['name' => 'Reseller'],
            ['name' => 'Supplier'],
        ]);

        // Membuat pengguna
        $user = User::factory()->create([
            'user_type_id' => 1, // Dengan asumsi 1 adalah ID jenis pengguna yang valid
            'password' => bcrypt('i-love-laravel'),
        ]);

        // Melakukan permintaan login dengan password yang salah
        $response = $this->from(route('login'))->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        // Memastikan pengguna tidak masuk
        $this->assertGuest();

        // Memastikan pengguna diarahkan kembali ke halaman login
        $response->assertRedirect(route('login', absolute: false));
    }

    /** @test */
    public function user_cannot_login_with_non_existing_email()
    {
        // Melakukan permintaan login dengan email yang tidak ada
        $response = $this->from(route('login'))->post(route('login'), [
            'email' => 'non-existing-email@example.com',
            'password' => 'password',
        ]);

        // Memastikan pengguna tidak masuk
        $this->assertGuest();

        // Memastikan pengguna diarahkan kembali ke halaman login
        $response->assertRedirect(route('login', absolute: false));
    }

    /** @test */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;
   /**
     * @RefreshDatabase
     * Fungsi untuk membuat UserType dan User Supplier
     *
     * @return User
     */
    private function createAdminUser()
    {
        // Membuat UserType
        UserType::insert([
            ['id' => 1, 'name' => 'Admin'],
        ]);

        // Membuat pengguna Reseller
        return User::factory()->create([
            'user_type_id' => 1, // ID for admin
        ]);
    }

    private function createSupplierUser()
    {
        // Membuat UserType
        UserType::insert([
            ['id' => 2, 'name' => 'Supplier'],
        ]);

        return User::factory()->create([
            'user_type_id' => 2, // ID for supplier
        ]);
    }

    public function test_suspend_account()
    {
        $user = $this->createAdminUser();
        $supplier=$this->createSupplierUser();

        $response = $this->actingAs($user)
        ->post('/admin/users/' . $supplier->id . '/suspend');

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success');

        // Assert that the order status has been updated to 'Sukses'
        $this->assertDatabaseHas('users', [
            'id' => $supplier->id,
            'suspended' => 1,
        ]);

    }

    public function test_unsuspend_account()
    {
        $user = $this->createAdminUser();
        $supplier=$this->createSupplierUser();

        $response = $this->actingAs($user)
        ->post('/admin/users/' . $supplier->id . '/unsuspend');

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success');

        // Assert that the order status has been updated to 'Sukses'
        $this->assertDatabaseHas('users', [
            'id' => $supplier->id,
            'suspended' => 0,
        ]);

    }

    public function test_create_user_form()
    {
        $user = $this->createAdminUser();

        $response = $this->actingAs($user)->get('/admin/users/create');

        // Assert that the response is OK
        $response->assertStatus(200);

        // Assert that the correct view is returned
        $response->assertViewIs('admin.users.create');

        // Assert that the view has the correct title
        $response->assertViewHas('title', 'Create New User');
    }

    public function test_add_account()
    {
        $user = $this->createAdminUser();

        $newUser = [
            'name' => 'New user',
            'email' => 'newadminuser@gmail.com',
            'password' => 'password123',
            'rekening' => '08123123',
            'user_type_id' => 1
        ];

        $response = $this->actingAs($user)->post('/admin/users', $newUser);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success', 'New user has been created!');

        $this->assertDatabaseHas('users', [
            'name' => 'New user',
            'email' => 'newadminuser@gmail.com'
        ]);
    }

    public function test_delete_account()
    {
        $user = $this->createAdminUser();

        $userToDelete = User::create([
            'name' => 'test_user',
            'user_type_id' => 1,
            'email' => 'newadminuser@gmail.com',
            'rekening' => '08123123',
            'password' => bcrypt('password')
        ]);

        $response = $this->actingAs($user)->delete("/admin/users/{$userToDelete->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success', 'User has been deleted!');

        // Assert: Verify that the user has been removed from the database
        $this->assertSoftDeleted('users', ['id' => $userToDelete->id]);
    }
}

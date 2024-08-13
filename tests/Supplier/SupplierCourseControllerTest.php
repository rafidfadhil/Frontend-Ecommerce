<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use App\Models\Notif;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierCourseControllerTest extends TestCase
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
     *
     * @return void
     */
    public function test_Rute_Index_SupplierCourse()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();
        // Melakukan autentikasi sebagai pengguna Supplier
        $this->actingAs($user);

        // Mengunjungi halaman course supplier
        $response = $this->get(route('supplier.course.index'));

        // Memeriksa bahwa pengguna telah terautentikasi
        $this->assertAuthenticated();
        // Memeriksa bahwa halaman course supplier berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman yang dimuat adalah halaman course supplier
        $response->assertViewIs('supplier.course.index');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Index_SupplierCourse()
    {
        // Membuat pengguna Supplier
        $user = $this->createSupplierUser();
        // Melakukan autentikasi sebagai pengguna Supplier
        $this->actingAs($user);

        // Membuat notifikasi untuk pengguna Supplier
        Notif::create([
            'notif_user_id' => $user->id,
            'notif_type' => 'Test',
            'notif_title' => 'Notifikasi Test',
            'notif_read' => '0',
        ]);

        // Membuat course dan lesson
        $course = Course::create(['name' => 'Test Course', 'description' => 'Test Description']);
        Lesson::create([
            'course_id' => $course->id,
            'title' => 'Test Lesson',
            'url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        ]);

        // Mengunjungi halaman course supplier
        $response = $this->get(route('supplier.course.index'));

        // Memeriksa bahwa halaman course supplier yang dimuat adalah halaman course supplier
        $response->assertViewIs('supplier.course.index');
        // Memeriksa bahwa halaman course supplier yang dimuat memiliki data
        $response->assertViewHas('data');
        // Memeriksa bahwa halaman course supplier yang dimuat memiliki notifikasi
        $response->assertViewHas('notif');

        // Memeriksa bahwa data course dan lesson sesuai
        $viewData = $response->original->getData()['data'];
        $this->assertCount(1, $viewData);
        $this->assertEquals('Test Course', $viewData[0]->name);
        $this->assertCount(1, $viewData[0]->lessons);
        $this->assertEquals('Test Lesson', $viewData[0]->lessons[0]->title);
        $this->assertStringContainsString('https://img.youtube.com/vi/dQw4w9WgXcQ/hqdefault.jpg', $viewData[0]->lessons[0]->thumbnail);
    }

    // =====================================================================================================
}

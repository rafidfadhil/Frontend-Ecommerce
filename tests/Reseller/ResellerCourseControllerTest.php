<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use App\Models\Notif;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResellerCourseControllerTest extends TestCase
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
    public function test_Rute_Index_ResellerCourse()
    {
        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Mengunjungi halaman course reseller
        $response = $this->get(route('reseller.course.index'));

        // Memeriksa bahwa pengguna telah terautentikasi
        $this->assertAuthenticated();
        // Memeriksa bahwa halaman course reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman yang dimuat adalah halaman course reseller
        $response->assertViewIs('reseller.course.index');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Index_ResellerCourse()
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

        // Membuat course dan lesson
        $course = Course::create(['name' => 'Test Course', 'description' => 'Test Description',]);
        Lesson::create([
            'course_id' => $course->id,
            'title' => 'Test Lesson',

            'url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        ]);

        // Mengunjungi halaman course reseller
        $response = $this->get(route('reseller.course.index'));

        // Memeriksa bahwa halaman course reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman course reseller yang dimuat adalah halaman course reseller
        $response->assertViewIs('reseller.course.index');
        // Memeriksa bahwa halaman course reseller yang dimuat memiliki data
        $response->assertViewHas('data');
        // Memeriksa bahwa halaman course reseller yang dimuat memiliki notifikasi
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
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Rute_Lesson_ResellerCourse()
    {
        // Membuat pengguna Reseller
        $user = $this->createResellerUser();
        // Melakukan autentikasi sebagai pengguna Reseller
        $this->actingAs($user);

        // Membuat course dan lesson
        $course = Course::create(['name' => 'Test Course', 'description' => 'Test Description',]);
        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Test Lesson',
            'url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        ]);

        // Mengunjungi halaman lesson reseller
        $response = $this->get(route('reseller.course.lesson', $lesson->id));

        // Memeriksa bahwa halaman lesson reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman lesson reseller yang dimuat adalah halaman lesson reseller
        $response->assertViewIs('reseller.course.lesson');
    }

    // =====================================================================================================
    /**
     * @RefreshDatabase
     *
     * @return void
     */
    public function test_Method_Lesson_ResellerCourse()
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

        // Membuat course dengan nama panjang
        $course = Course::create(['name' => 'This is a very long course name that should be shortened', 'description' => 'Test Description']);

        // Membuat lesson dengan judul panjang
        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'This is a very long lesson title that should be shortened',
            'url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        ]);

        // Mengunjungi halaman lesson reseller
        $response = $this->get(route('reseller.course.lesson', $lesson->id));

        // Memeriksa bahwa halaman lesson reseller berhasil dimuat
        $response->assertStatus(200);
        // Memeriksa bahwa halaman lesson reseller yang dimuat adalah halaman lesson reseller
        $response->assertViewIs('reseller.course.lesson');
        // Memeriksa bahwa halaman lesson reseller yang dimuat memiliki data
        $response->assertViewHas('data');
        $response->assertViewHas('courses');
        $response->assertViewHas('notif');

        // Memeriksa bahwa data lesson sesuai
        $viewData = $response->original->getData()['data'];
        $this->assertEquals($lesson->id, $viewData->id);

        // Memeriksa bahwa nama course dan judul lesson dipotong dengan benar
        $viewCourses = $response->original->getData()['courses'];
        $this->assertEquals('This is a very long...', $viewCourses[0]->shortName);
        $this->assertEquals('This is a very long...', $viewCourses[0]->lessons[0]->shortName);
    }
}

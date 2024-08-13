<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lesson::create([
            'title' => 'Cara Mempromosikan Produk',
            'url' => 'https://www.youtube.com/embed/qRkaeqGpUAw?si=shbMYMCVr5hnWhEP',
            'course_id' => 1
        ]);

        Lesson::create([
            'title' => 'Memanfaatkan Fitur Chat dengan Reseller',
            'url' => 'https://www.youtube.com/embed/WTfDDy_-doA?si=MheS_N_bm_YOsf8M',
            'course_id' => 2
        ]);

        Lesson::create([
            'title' => 'Tips Menjaga Hubungan dengan Member',
            'url' => 'https://www.youtube.com/embed/pE814dg97i0?si=nThFgZv7zZo6uu8R',
            'course_id' => 3
        ]);
    }
}

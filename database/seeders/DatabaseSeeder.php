<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserTypeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(TopicSeeder::class);
        $this->call(MemberSeeder::class);
        $this->call(CartSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(NotifSeeder::class);
    }
}

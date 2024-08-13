<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'name' => 'Mempromosikan Produk',
            'description' => 'Materi tentang bagimana cara Anda sebagai supplier untuk mempromosikan produk Anda'
        ]);

        Course::create([
            'name' => 'Menarik Reseller Menggunakan Fitur Chat',
            'description' => 'Materi tentang bagimana cara Anda sebagai supplier dapat menarik reseller untuk membeli produk anda dengan fitur chat'
        ]);

        Course::create([
            'name' => 'Mengelola Hubungan dengan Member',
            'description' => 'Materi tentang bagimana cara Anda sebagai supplier dapat menjaga hubungan dengan member Anda'
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Topic::create([
            'name' => 'Akun dan Keamanan',
            'slug' => 'akun-dan-keamanan'
        ]);

        Topic::create([
            'name' => 'Pesanan',
            'slug' => 'pesanan'
        ]);

        Topic::create([
            'name' => 'Pembayaran',
            'slug' => 'pembayaran'
        ]);

        Topic::create([
            'name' => 'Membership',
            'slug' => 'membership'
        ]);
    }
}

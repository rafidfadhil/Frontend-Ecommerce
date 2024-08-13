<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notif;

class NotifSeeder extends Seeder
{
    public function run(): void
    {
        Notif::create([
            'notif_user_id' => '2',
            'notif_type' => 'order',
            'notif_title' => 'Ada pesanan baru dari member',
            'notif_read' => '0',
        ]);

        Notif::create([
            'notif_user_id' => '2',
            'notif_type' => 'member',
            'notif_title' => 'Member baru terdaftar',
            'notif_read' => '0',
        ]);

        Notif::create([
            'notif_user_id' => '3',
            'notif_type' => 'member',
            'notif_title' => 'Anda terdaftar sebagai member baru',
            'notif_read' => '0',
        ]);
    }
}

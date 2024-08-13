<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin', 'user_type_id' => 1, 'email' => 'admin@gmail.com', 'password' => 'password', 'user_info_id' => '1', 'avatar' => 'Avatar.jpg', 'address' => '', 'rekening' => '0899987633', 'phone' => '', 'bio' => ''],
            ['name' => 'User Supplier', 'user_type_id' => 2, 'email' => 'supplier@gmail.com', 'password' => '12345678', 'user_info_id' => '2', 'avatar' => 'Avatar-1.jpg', 'address' => 'Jl. Raya No. 2', 'rekening' => '56488889', 'phone' => '08123456789', 'bio' => 'Bio Supplier'],
            ['name' => 'User Reseller', 'user_type_id' => 3, 'email' => 'reseller@gmail.com', 'password' => '12345678', 'user_info_id' => '3', 'avatar' => 'Avatar-2.jpg', 'address' => 'Jl. Raya No. 3', 'rekening' => '56488001', 'phone' => '08123456789', 'bio' => 'Bio Reseller']
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt($user['password']),
                'user_type_id' => $user['user_type_id'],
                'avatar' => $user['avatar'],
                'address' => $user['address'],
                'phone' => $user['phone'],
                'rekening' => $user['rekening'],
                'bio' => $user['bio'],
            ]);
        }
    }
}

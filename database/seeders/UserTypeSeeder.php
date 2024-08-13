<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserType;

class UserTypeSeeder extends Seeder
{
    public function run(): void
    {
        $userTypes = ['Admin', 'Supplier', 'Reseller'];
        foreach ($userTypes as $type) {
            UserType::create(['name' => $type]);
        }
    }
}

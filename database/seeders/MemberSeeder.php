<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        Member::create([
            'member_reseller_id' => '3',
            'member_supplier_id' => '2',
        ]);
    }
}

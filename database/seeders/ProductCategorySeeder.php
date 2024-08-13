<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        ProductCategory::create([
            'name' => 'Fashion',
            'slug' => 'fashion'
        ]);

        ProductCategory::create([
            'name' => 'Kecantikan',
            'slug' => 'kecantikan'
        ]); 

        ProductCategory::create([
            'name' => 'Makanan',
            'slug' => 'makanan'
        ]);

        ProductCategory::create([
            'name' => 'Mainan & Hobi',
            'slug' => 'mainan-hobi'
        ]);
    }
}

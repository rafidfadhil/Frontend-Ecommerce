<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Lego set',
            'slug' => 'lego-set',
            'user_id' => 2,
            'stock' => 10,
            'price' => 200000,
            'price_member' => 190000,
            'image'=>'https://source.unsplash.com/random',
            'product_category_id' => 4,
            'description' => 'Mainan anak-anak'
        ]);

        Product::create([
            'name' => 'Keripik singkong',
            'slug' => 'keripik-singkong',
            'user_id' => 2,
            'stock' => 12,
            'price' => 10000,
            'price_member' => 9500,
            'image'=>'https://source.unsplash.com/random',
            'product_category_id' => 3,
            'description' => 'Keripik singkong'
        ]);

        Product::create([
            'name' => 'Product A',
            'slug' => 'Product-A',
            'user_id' => 2,
            'stock' => 5,
            'price' => 60000,
            'price_member' => 55000,
            'description' => 'Description of Product 1',
            'product_category_id' => 1,
            'image' => 'product1.jpg',
        ]);

        Product::create([
            'name' => 'Product B',
            'slug' => 'Product-B',
            'user_id' => 2,
            'stock' => 25,
            'price' => 80000,
            'price_member' => 75000,
            'description' => 'Description of Product 2',
            'product_category_id' => 2,
            'image' => 'product2.jpg',
        ]);

        Product::create([
            'name' => 'Product C',
            'slug' => 'Product-C',
            'user_id' => 2,
            'stock' => 0,
            'price' => 70000,
            'price_member' => 65000,
            'description' => 'Description of Product 3',
            'product_category_id' => 3,
            'image' => 'product3.jpg',
        ]);

        Product::create([
            'name' => 'Product D',
            'slug' => 'Product-D',
            'user_id' => 2,
            'stock' => 30,
            'price' => 90000,
            'price_member' => 85000,
            'description' => 'Description of Product 4',
            'product_category_id' => 4,
            'image' => 'product4.jpg',
        ]);

        Product::create([
            'name' => 'Bundle 1',
            'slug' => 'Bundle_1',
            'user_id' => 2,
            'stock' => 3,
            'price' => 150000,
            'price_member' => 150000,
            'description' => 'Deskripsi Bundel 1 Berisi Product A dan Product B',
            'product_category_id' => 2,
            'image' => 'Bundle_1.jpg',
            'product_member' => '1',
        ]);

        Product::create([
            'name' => 'Bundle 2',
            'slug' => 'Bundle_2',
            'user_id' => 2,
            'stock' => 3,
            'price' => 100000,
            'price_member' => 100000,
            'description' => 'Deskripsi Bundel 1 Berisi Product C dan Product D',
            'product_category_id' => 2,
            'image' => 'Bundle_2.jpg',
            'product_member' => '1',
        ]);
    }
}

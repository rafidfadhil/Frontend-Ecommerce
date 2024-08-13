<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;

class CartSeeder extends Seeder
{
    public function run(): void
    {

        $cart1 = new Cart();
        $cart1->cart_product_id = '3';
        $cart1->cart_reseller_id = '3';
        $cart1->cart_quantity = '1';
        $cart1->save();

        $cart2 = new Cart();
        $cart2->cart_product_id = '4';
        $cart2->cart_reseller_id = '3';
        $cart2->cart_quantity = '2';
        $cart2->save();

    }
}

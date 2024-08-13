<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $order1 = new Order();
        $order1->order_number = '0001';
        $order1->order_date = '2024-05-01';
        $order1->order_reseller_id = 3;
        $order1->order_supplier_id = 2;
        $order1->order_product_id = 1;
        $order1->order_quantity = 5;
        $order1->order_price = 10000;
        $order1->order_total = $order1->order_quantity * $order1->order_price;
        $order1->order_payment = 'Sukses';
        $order1->order_status = 'Selesai';
        $order1->order_resi = '4545668868654';
        $order1->order_rating = 4;
        $order1->order_review = 'Barangnya bagus, pengiriman cepat';
        $order1->save();

        // Entry 2
        $order2 = new Order();
        $order2->order_number = '0002';
        $order2->order_date = '2024-05-02';
        $order2->order_reseller_id = 3;
        $order2->order_supplier_id = 2;
        $order2->order_product_id = 2;
        $order2->order_quantity = 10;
        $order2->order_price = 15000;
        $order2->order_total = $order2->order_quantity * $order2->order_price;
        $order2->order_payment = 'Pending';
        $order2->order_status = 'Menunggu Konfirmasi';
        $order2->save();

        // Entry 3
        $order3 = new Order();
        $order3->order_number = '0003';
        $order3->order_date = '2024-05-03';
        $order3->order_reseller_id = 3;
        $order3->order_supplier_id = 2;
        $order3->order_product_id = 3;
        $order3->order_quantity = 8;
        $order3->order_price = 20000;
        $order3->order_total = $order3->order_quantity * $order3->order_price;
        $order3->order_payment = 'Sukses';
        $order3->order_resi = '4545668889964';
        $order3->order_status = 'Diproses';
        $order3->save();

        // Entry 4
        $order4 = new Order();
        $order4->order_number = '0004';
        $order4->order_date = '2024-05-04';
        $order4->order_reseller_id = 3;
        $order4->order_supplier_id = 2;
        $order4->order_product_id = 4;
        $order4->order_quantity = 3;
        $order4->order_price = 12000;
        $order4->order_total = $order4->order_quantity * $order4->order_price;
        $order4->order_payment = 'Sukses';
        $order4->order_resi = '4545787888654';
        $order4->order_status = 'Proses Pengiriman';
        $order4->save();

        // Entry 5
        $order5 = new Order();
        $order5->order_number = '0005';
        $order5->order_date = '2024-05-05';
        $order5->order_reseller_id = 3;
        $order5->order_supplier_id = 2;
        $order5->order_product_id = 1;
        $order5->order_quantity = 6;
        $order5->order_price = 18000;
        $order5->order_total = $order5->order_quantity * $order5->order_price;
        $order5->order_payment = 'Sukses';
        $order5->order_status = 'Ditolak';
        $order5->save();

        // Entry 6
        $order6 = new Order();
        $order6->order_number = '0006';
        $order6->order_date = '2024-05-04';
        $order6->order_reseller_id = 3;
        $order6->order_supplier_id = 2;
        $order6->order_product_id = 3;
        $order6->order_quantity = 3;
        $order6->order_price = 13000;
        $order6->order_total = $order4->order_quantity * $order4->order_price;
        $order6->order_payment = 'Sukses';
        $order6->order_resi = '45456688687878';
        $order6->order_status = 'Proses Pengiriman';
        $order6->save();

        // Entry 7
        $order7 = new Order();
        $order7->order_number = '0006';
        $order7->order_date = '2024-05-04';
        $order7->order_reseller_id = 3;
        $order7->order_supplier_id = 2;
        $order7->order_product_id = 4;
        $order7->order_quantity = 4;
        $order7->order_price = 14000;
        $order7->order_total = $order4->order_quantity * $order4->order_price;
        $order7->order_payment = 'Sukses';
        $order7->order_resi = '45456688555454';
        $order7->order_status = 'Proses Pengiriman';
        $order7->save();
    }
}

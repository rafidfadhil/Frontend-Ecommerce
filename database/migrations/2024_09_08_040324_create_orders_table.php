<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->string('order_number');
            $table->date('order_date');

            $table->unsignedBigInteger('order_reseller_id');
            $table->foreign('order_reseller_id')->references('id')->on('users');

            $table->unsignedBigInteger('order_supplier_id');
            $table->foreign('order_supplier_id')->references('id')->on('users');

            $table->unsignedBigInteger('order_product_id');
            $table->foreign('order_product_id')->references('id')->on('products');

            $table->integer('order_quantity');
            $table->decimal('order_price', 10, 2);
            $table->decimal('order_total', 10, 2);
            $table->string('order_payment');
            $table->string('order_payment_image')->nullable();
            $table->string('order_status');
            $table->string('order_resi')->nullable();
            $table->integer('order_rating')->nullable();
            $table->string('order_rating_image')->nullable();
            $table->string('order_review')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

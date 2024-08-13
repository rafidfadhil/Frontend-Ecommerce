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
        Schema::create('carts', function (Blueprint $table) {
            $table->id('cart_id');

            $table->unsignedBigInteger('cart_reseller_id');
            $table->foreign('cart_reseller_id')->references('id')->on('users');

            $table->unsignedBigInteger('cart_product_id');
            $table->foreign('cart_product_id')->references('id')->on('products');

            $table->integer('cart_quantity');
            $table->integer('cart_order')->default('0');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};

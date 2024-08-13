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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('admin_transfer_proof')->nullable()->after('order_review'); // Add after the existing column for better organization
            $table->string('supplier_payment_status')->default('pending')->after('admin_transfer_proof');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('admin_transfer_proof');
            $table->dropColumn('supplier_payment_status');
        });
    }
};

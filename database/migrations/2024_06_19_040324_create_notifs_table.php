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
        Schema::create('notifs', function (Blueprint $table) {
            $table->id('notif_id');
            $table->unsignedBigInteger('notif_user_id');
            $table->foreign('notif_user_id')->references('id')->on('users');
            $table->string('notif_type');
            $table->string('notif_title');
            $table->integer('notif_read');
            $table->integer('notif_sender_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifs');
    }
};

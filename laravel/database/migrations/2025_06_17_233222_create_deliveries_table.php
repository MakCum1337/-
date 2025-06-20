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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('physical_product_id');
            $table->unsignedBigInteger('delivery_id');
            $table->unsignedBigInteger('cart_id');
            $table->integer('time_delivery');
            $table->decimal('delivery_price', 10, 2);
            $table->enum('paid', ['paid', 'not_paid'])->default('not_paid');
            $table->enum('status', ['getting_ready_to_send', 'delivering', 'delivered'])->default('getting_ready_to_send');
            $table->timestamps();
            
            $table->foreign('physical_product_id')->references('id')->on('physical_products');
            $table->foreign('delivery_id')->references('id')->on('delivery_services');
            $table->foreign('cart_id')->references('id')->on('cart');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};

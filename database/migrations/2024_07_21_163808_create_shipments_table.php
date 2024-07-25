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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('order_item_charges_id')->nullable();
            $table->timestamp('shipment_date')->nullable();
            $table->timestamp('delivery_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('order_item_charges_id')->references('id')->on('order_item_and_charges');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};

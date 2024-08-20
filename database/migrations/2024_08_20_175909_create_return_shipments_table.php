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
        Schema::create('return_shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable()->comment('Order ID from Orders table');
            $table->unsignedBigInteger('return_id')->nullable()->comment('Return ID from Return Orders table');
            $table->unsignedBigInteger('courier_id')->nullable()->comment('Courier ID from Courier Details table');
            $table->string('awb_number')->comment('A unique number or identifier for the return shipment, useful for tracking and reference');
            $table->timestamp('shipment_date')->default(now())->comment('The date when the return shipment was issued');
            $table->tinyInteger('courier_type')->default(1)->comment('1: Surface, 2: Air');
            $table->string('provider_name')->nullable()->comment('The name of the courier service provider');
            $table->timestamp('expected_delivery_date')->nullable()->comment('The expected delivery date of the return shipment');
            $table->tinyInteger('status')->default(1)->comment('1: Created, 2: Shipped Or Dispatched, 3: Delivered, 4: Cancelled, 5: RTO');
            $table->text('file_path')->nullable()->comment('The path to the uploaded return shipment lable file or images');
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('return_id')->references('id')->on('return_orders');
            $table->foreign('courier_id')->references('id')->on('courier_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_shipments');
    }
};

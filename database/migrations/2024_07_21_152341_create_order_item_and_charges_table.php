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
        Schema::create('order_item_and_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable(); // user_id
            $table->integer('quantity');
            $table->decimal('per_item_price', 8, 2)->nullable()->comment('Price of the product per item excluding gst');
            $table->decimal('total_price_inc_gst', 8, 2)->nullable()->comment('Total price of the product including gst (quatity*item_price)');
            $table->decimal('total_price_exc_gst', 8, 2)->nullable()->comment('Total price of the product excluding gst (quatity*item_price)');
            $table->decimal('gst_percentage', 5, 2)->nullable()->comment('GST percentage of the product Item Wise');
            $table->decimal('igst', 8, 2)->nullable()->comment('IGST of the product Item Wise');
            $table->decimal('cgst', 8, 2)->nullable()->comment('CGST of the product Item Wise');
            $table->decimal('shipping_gst_percent', 5, 2)->nullable()->comment('Shipping GST percentage');
            $table->decimal('shipping_charges', 8, 2)->nullable()->comment('Shipping charges including gst');
            $table->decimal('packing_charges', 8, 2)->nullable()->comment('Packing charges including gst');
            $table->decimal('packaging_gst_percent', 5, 2)->nullable()->comment('Packing GST percentage');
            $table->decimal('labour_charges', 8, 2)->nullable()->comment('Labour charges including gst');
            $table->decimal('labour_gst_percent', 5, 2)->nullable()->comment('Labour GST percentage');
            $table->decimal('processing_charges', 8, 2)->nullable()->comment('Processing charges including gst');
            $table->decimal('processing_gst_percent', 5, 2)->nullable()->comment('Processing GST percentage');
            $table->decimal('payment_gateway_percentage', 8, 2)->nullable()->comment('Payment gateway percentage');
            $table->decimal('payment_gateway_charges', 8, 2)->nullable()->comment('Payment gateway charges including gst');
            $table->decimal('payment_gateway_gst_percent', 5, 2)->nullable()->comment('Payment gateway GST percentage');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('product_id')->references('id')->on('product_variations');
            $table->foreign('supplier_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_and_charges');
    }
};

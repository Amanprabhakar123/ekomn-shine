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
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('buyer_id')->references('id')->on('users');
            $table->foreign('supplier_id')->references('id')->on('users');
            $table->timestamp('order_date')->default(now())->comment('order date when order is placed');
            $table->tinyInteger('status')->default(1)->comment('1-Draft, 2-Pending, 3-In Progress ,4-Dispatched, 5-In Transit, 6-Delivered, 7-Cancelled, 8-RTO');
            $table->decimal('total_amount')->nullable()->comment('total amount of order including tax and shipping');
            $table->decimal('discount')->default(0)->comment('Discount amount');
            $table->tinyInteger('payment_status')->comment('1-Pending, 2-Paid, 3-Failed');
            $table->tinyInteger('payment_currency')->default(1)->comment('1-INR, 2-USD, 3-EUR');
            $table->tinyInteger('order_type')->default(1)->comment('1-Dropship, 2-Bulk, 3-Resell');
            $table->tinyInteger('order_channel_type')->default(1)->comment('1-Manual Order, 2-Store order');
            $table->tinyInteger('payment_method')->default(2)->comment('1-COD, 2-Online Payment');
            $table->unsignedBigInteger('shipping_address_id')->nullable();
            $table->unsignedBigInteger('billing_address_id')->nullable();
            $table->unsignedBigInteger('pickup_address_id')->nullable();
            $table->boolean('is_cancelled')->default(false);
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
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

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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->timestamp('payment_date')->default(now());
            $table->tinyInteger('payment_method')->default(1)->comment('1: Razorpay, 2: Paytm, 3: UPI, 4: Net Banking, 5: Debit Card, 6: Credit Card, 7: Wallet, 8: Bank Transfer');
            $table->decimal('amount', 8, 2)->nullable();
            $table->tinyInteger('currency')->default(1)->comment('1: INR, 2: USD, 3: EUR');
            $table->tinyInteger('status')->default(1)->comment('1: Created, 2: Authorized, 3: Captured, 4: Refunded, 5: Failed');
            $table->string('razorpay_signature')->nullable()->comment('Razorpay signature');
            $table->text('description')->nullable()->comment('Payment description');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};

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
        Schema::create('order_refunds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('transaction_id')->nullable()->comment('Transaction ID from Order Transaction table');
            $table->unsignedBigInteger('order_payment_id')->nullable()->comment('Payment ID from Order Payment table');
            $table->unsignedBigInteger('buyer_id')->nullable()->comment('User ID of the buyer');
            $table->decimal('amount', 8, 2)->nullable();
            $table->tinyInteger('currency')->default(1)->comment('1: INR, 2: USD, 3: EUR');
            $table->tinyInteger('status')->default(1)->comment('1: Initiated, 2: Processing, 3: Completed, 4: Failed');
            $table->text('reason')->nullable();
            $table->tinyInteger('initiated_by')->default(1)->comment('1: Admin, 2: System');
            $table->tinyInteger('refund_method')->default(1)->comment('1: Razorpay, 2: Paytm, 3: UPI, 4: Net Banking, 5: Debit Card, 6: Credit Card, 7: Wallet, 8: Bank Transfer');
            $table->timestamp('refund_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('transaction_id')->references('id')->on('order_transactions');
            $table->foreign('order_payment_id')->references('id')->on('order_payments');
            $table->foreign('buyer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_refunds');
    }
};

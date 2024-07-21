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
        Schema::create('order_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('order_payment_id')->nullable();
            $table->timestamp('transaction_date');
            $table->tinyInteger('transaction_type')->default(1)->comment('1: Payment, 2: Refund');
            $table->decimal('transaction_amount', 8, 2)->nullable();
            $table->tinyInteger('transaction_currency')->default(1)->comment('1: INR, 2: USD, 3: EUR');
            $table->string('razorpay_transaction_id')->nullable()->unique();
            $table->tinyInteger('status')->default(1)->comment('1: Success, 2: Failed, 3: Pending');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('order_payment_id')->references('id')->on('order_payments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_transactions');
    }
};

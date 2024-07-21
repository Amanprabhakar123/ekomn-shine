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
        Schema::create('supplier_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('distribution_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->decimal('adjustment_amount', 8, 2)->default(0);
            $table->decimal('disburse_amount', 8, 2)->default(0);
            $table->timestamp('statement_date')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->tinyInteger('payment_status')->default(1)->comment('0: NA, 1: Hold, 2: Accured, 3: Paid, 4: Due to track the payment status to the supplier');
            $table->tinyInteger('payment_method')->default(1)->comment('1: Razorpay, 2: Paytm, 3: UPI, 4: Net Banking, 5: Debit Card, 6: Credit Card, 7: Wallet, 8: Bank Transfer');
            $table->string('transaction_id')->nullable()->comment('Transaction ID updated manually for now because we will create automatic payment gateway integration in future');
            $table->boolean('invoice_generated')->default(false)->comment('To check if the invoice is generated or not and if payment not done it is false if done change true');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('distribution_id')->references('id')->on('order_payment_distributions');
            $table->foreign('supplier_id')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_payments');
    }
};

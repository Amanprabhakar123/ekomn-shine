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
        Schema::create('company_plan_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_id');
            $table->uuid('purchase_id'); // unique system id made by us
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('receipt_id');
            $table->unsignedBigInteger('company_id')->default(0);
            $table->boolean('is_trial_plan')->default(0);
            $table->string('currency', 20);
            $table->string('email',100)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->unsignedBigInteger('buyer_id')->default(0); // buyer_id is the user_id of the buyer temp table or buyer table
            $table->decimal('amount', 10, 2);
            $table->string('payment_status', 30);
            $table->longText('json_response');
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->timestamps();

            // Assuming you have a foreign key to the plans table
            $table->foreign('plan_id')->references('id')->on('plans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_plan_payments');
    }
};

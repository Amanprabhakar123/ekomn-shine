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
            $table->string('currency', 20);
            $table->string('user_email',100);
            $table->string('mobile_no', 20);
            $table->decimal('amount', 10, 2);
            $table->string('payment_status', 30);
            $table->longText('json_response');
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

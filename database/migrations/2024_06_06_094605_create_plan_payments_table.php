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
        Schema::create('plan_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('plan_id');
            $table->date('subscription_start_date');
            $table->date('subscription_end_date');
            $table->decimal('total_amount_paid', 10, 2)->default(0);
            $table->integer('validity_months')->default(0);
            $table->string('payment_status'); // Assuming it's a string, please adjust if it's ENUM or another type
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            // Assuming you have foreign keys to companies and plans tables
            $table->foreign('company_id')->references('id')->on('company_details');
            $table->foreign('plan_id')->references('id')->on('plans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_payments');
    }
};

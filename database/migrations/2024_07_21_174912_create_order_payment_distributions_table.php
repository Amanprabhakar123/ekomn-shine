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
        Schema::create('order_payment_distributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('order_payment_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->tinyInteger('status')->default(1)->comment('0: NA, 1: Hold, 2: Accured, 3: Paid, 4: Due to track the payment status to the supplier');
            $table->boolean('is_refunded')->default(false)->comment('Indicates if the payment to the supplier has been refunded back to the marketplace or customer due to cancellation');
            $table->tinyInteger('refund_status')->default(0)->comment('0: NA, 1: Hold, 2: Accured, 3: Paid, 4: Due to track the refund status to the supplier');
            $table->decimal('refunded_amount', 8, 2)->nullable();
            $table->timestamp('refund_initiated_at')->nullable();
            $table->timestamp('refund_completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('order_payment_id')->references('id')->on('order_payments');
            $table->foreign('supplier_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payment_distributions');
    }
};

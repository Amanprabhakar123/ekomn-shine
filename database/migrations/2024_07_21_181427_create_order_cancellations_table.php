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
        Schema::create('order_cancellations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('refund_id')->nullable()->comment('Refund ID from Order Refund table');
            $table->unsignedBigInteger('cancelled_by_id')->nullable()->comment('User ID of the person who cancelled the order');
            $table->text('reason')->nullable()->comment('Reason for cancellation');
            $table->tinyInteger('cancelled_by')->default(1)->comment('1 = Customer, 2 = Admin');
            $table->tinyInteger('refund_status')->default(1)->comment('1 = Pending, 2 = Approved, 3 = Rejected');
            $table->decimal('refund_amount', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('cancelled_by_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_cancellations');
    }
};

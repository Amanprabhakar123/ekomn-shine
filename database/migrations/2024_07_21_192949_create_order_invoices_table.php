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
        Schema::create('order_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable()->comment('Order ID from Orders table');
            $table->unsignedBigInteger('buyer_id')->nullable()->comment('Buyer ID from Users table');
            $table->unsignedBigInteger('supplier_id')->nullable()->comment('Supplier ID from Users table');
            $table->string('invoice_number')->unique()->comment('A unique number or identifier for the invoice, useful for tracking and reference');
            $table->timestamp('invoice_date')->default(now())->comment('The date when the invoice was issued');
            $table->decimal('total_amount', 8, 2)->nullable()->comment('The total amount charged in the invoice, including products, shipping, and any additional fees.');
            $table->tinyInteger('status')->default(1)->comment('0-> Due, 1: Paid, 2: Cancelled, 3: Refunded');
            $table->string('uploaded_invoice_path')->nullable()->comment('The path to the uploaded invoice file');
            $table->decimal('refund_amount', 8, 2)->nullable()->comment('The amount refunded for the invoice');
            $table->tinyInteger('refund_status')->default(0)->comment('0: NA, 1: Initiated, 2: Processing, 3: Completed, 4: Failed');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('supplier_id')->references('id')->on('users');
            $table->foreign('buyer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_invoices');
    }
};

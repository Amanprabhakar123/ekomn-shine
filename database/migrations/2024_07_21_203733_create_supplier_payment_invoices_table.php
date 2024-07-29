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
        Schema::create('supplier_payment_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_payments_id')->nullable();
            $table->string('invoice_number')->unique();
            $table->timestamp('invoice_date');
            $table->decimal('total_amount', 8, 2);
            $table->tinyInteger('status')->default(1)->comment('1: Paid, 2: Cancelled, 3: Refunded');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('supplier_payments_id')->references('id')->on('supplier_payments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_payment_invoices');
    }
};

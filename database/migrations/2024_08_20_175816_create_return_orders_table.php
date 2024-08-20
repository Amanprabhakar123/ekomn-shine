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
        Schema::create('return_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable()->comment('Order ID from Orders table');
            $table->string('return_number')->unique()->comment('A unique number or identifier for the return order, useful for tracking and reference');
            $table->timestamp('return_date')->default(now())->comment('The date when the return order was issued');
            $table->tinyInteger('status')->default(1)->comment('1-> Open, 2: InProgress, 3: Accept, 4: Approved, 5: Rejected');
            $table->tinyInteger('dispute')->default(0)->comment('0: No, 1: Yes');
            $table->text('file_path')->nullable()->comment('The path to the uploaded return invoice file or images');
            $table->string('reason')->nullable()->comment('The reason for the return order');
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_orders');
    }
};

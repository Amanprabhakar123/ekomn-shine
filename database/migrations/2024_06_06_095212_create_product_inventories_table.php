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
        Schema::create('product_inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->notNullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->text('description')->nullable();
            $table->text('features')->nullable();
            $table->string('model', 255)->nullable();
            $table->string('sku', 100)->unique();
            $table->string('hsn', 100)->nullable();
            $table->decimal('gst_percentage', 5, 2)->nullable();
            $table->string('size', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('upc', 100)->nullable();
            $table->string('isbn', 100)->nullable();
            $table->string('mpin', 100)->nullable();
            $table->integer('stock')->nullable();
            $table->decimal('price_before_tax', 10, 2)->nullable();
            $table->decimal('price_after_tax', 10, 2)->nullable();
            $table->json('tier_pricing')->nullable();
            $table->decimal('length', 10, 2)->nullable();
            $table->decimal('breadth', 10, 2)->nullable();
            $table->decimal('height', 10, 2)->nullable();
            $table->string('dimension_class', 10)->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('weight_class', 10)->nullable();
            $table->enum('availability_status', ['till_stock_last', 'regular'])->nullable();
            $table->enum('status', ['active', 'inactive'])->nullable();
            $table->json('packaging_detail')->nullable();
            $table->json('shipping_cost_detail')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Assuming you have foreign keys to companies and suppliers tables
            $table->foreign('company_id')->references('id')->on('company_details')->onDelete('cascade');
            // $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_inventories');
    }
};

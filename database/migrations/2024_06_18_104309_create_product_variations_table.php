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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('company_id');
            $table->string('sku', 100)->unique();
            $table->string('title', 191)->nullable();
            $table->text('description')->nullable();
            $table->string('size', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->decimal('length', 10, 2)->nullable();
            $table->decimal('width', 10, 2)->nullable();
            $table->decimal('height', 10, 2)->nullable();
            $table->string('dimension_class', 10)->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('weight_class', 10)->nullable();
            $table->decimal('volumetric_weight', 10, 2)->nullable();
            $table->decimal('package_length', 10, 2)->nullable();
            $table->decimal('package_width', 10, 2)->nullable();
            $table->decimal('package_height', 10, 2)->nullable();
            $table->string('package_dimension_class', 10)->nullable();
            $table->decimal('package_weight', 10, 2)->nullable();
            $table->string('package_weight_class', 10)->nullable();
            $table->decimal('price_before_tax', 10, 2)->nullable();
            $table->decimal('price_after_tax', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('availability_status')->default(2);
            $table->decimal('dropship_rate', 10, 2)->nullable();
            $table->decimal('potential_mrp', 10, 2)->nullable();
            $table->json('tier_rate')->nullable();
            $table->json('tier_shipping_rate')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('company_details');
            $table->foreign('product_id')->references('id')->on('product_inventories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};

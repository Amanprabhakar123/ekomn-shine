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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('desc')->nullable();
            $table->string('sku')->nullable();
            $table->string('l')->nullable();
            $table->string('b')->nullable();
            $table->string('h')->nullable();
            $table->string('weight')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('price')->nullable();
            $table->string('total_price')->nullable();
            $table->string('tags')->nullable();
            $table->string('address_id')->nullable();
            $table->string('cgst')->nullable();
            $table->string('cgst_amount')->nullable();
            $table->string('sgst')->nullable();
            $table->string('sgst_percentage')->nullable();
            $table->string('igst_percentage')->nullable();
            $table->string('total_tax')->nullable();
            $table->string('total_tax_percentage')->nullable();
            $table->string('discount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

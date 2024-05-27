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
            $table->string('Name')->nullable();
            $table->string('desc')->nullable();
            $table->string('Sku')->nullable();
            $table->string('L')->nullable();
            $table->string('B')->nullable();
            $table->string('H')->nullable();
            $table->string('Weight')->nullable();
            $table->string('Color')->nullable();
            $table->string('size')->nullable();
            $table->string('Price')->nullable();
            $table->string('Total_price')->nullable();
            $table->string('Tags')->nullable();
            $table->string('Address_id')->nullable();
            $table->string('Cgst')->nullable();
            $table->string('Cgst_amount')->nullable();
            $table->string('Sgst')->nullable();
            $table->string('Sgst_percentage')->nullable();
            $table->string('Igst_percentage')->nullable();
            $table->string('Total_tax')->nullable();
            $table->string('Total_tax_percentage')->nullable();
            $table->string('Discount')->nullable();
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

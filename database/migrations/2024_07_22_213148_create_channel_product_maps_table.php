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
        Schema::create('channel_product_maps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_channel_id');
            $table->unsignedBigInteger('product_variation_id');
            $table->string('sales_channel_product_sku');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sales_channel_id')->references('id')->on('sales_channels')->onDelete('cascade');
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channel_product_maps');
    }
};

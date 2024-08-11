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
        Schema::create('product_matrics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedBigInteger('search_count')->default(0);
            $table->unsignedBigInteger('click_count')->default(0);
            $table->unsignedBigInteger('purchase_count')->default(0);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('product_variations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_matrics');
    }
};

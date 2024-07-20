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
        Schema::create('buyer_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('buyer_id');  // user_id
            $table->foreign('company_id')->references('id')->on('company_details');
            $table->foreign('product_id')->references('id')->on('product_variations');
            $table->foreign('buyer_id')->references('id')->on('users');
            $table->timestamp('added_to_inventory_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_inventories');
    }
};

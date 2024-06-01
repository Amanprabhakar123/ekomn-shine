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
        Schema::create('company_address_details', function (Blueprint $table) {
            $table->id();
            $table->string('street_address');
            $table->string('state');
            $table->string('nearby_landmark')->nullable();
            $table->string('location_link')->nullable();
            $table->enum('type', ['Billing Address', 'Shipping', 'Delivery']);
            $table->string('pincode');
            $table->boolean('is_location_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_address_details');
    }
};

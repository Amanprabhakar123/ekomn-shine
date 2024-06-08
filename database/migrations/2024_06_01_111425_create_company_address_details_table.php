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
            $table->foreignId('company_id')->constrained('company_details');
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('city', 50);
            $table->string('state', 50);
            $table->string('pincode', 10);
            $table->string('country')->default('India');
            $table->string('landmark')->nullable();
            $table->tinyInteger('address_type');
            $table->string('location_link')->nullable();
            $table->boolean('is_location_verified')->default(false);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            $table->softDeletes();
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

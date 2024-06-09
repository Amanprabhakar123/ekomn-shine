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
        Schema::create('buyer_registration_temps', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('designation')->nullable();
            $table->string('address')->nullable();
            $table->string('state', 13)->nullable();
            $table->string('city')->nullable();
            $table->string('pin_code', 7)->nullable();
            $table->string('business_name')->default(false); 
            $table->string('gst')->nullable(); 
            $table->string('pan')->nullable(); 
            $table->string('email')->nullable();
            $table->string('password')->nullable(); 
            $table->string('product_channel')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_registration_temps');
    }
};

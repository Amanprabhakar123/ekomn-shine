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
        Schema::create('ekomn_details', function (Blueprint $table) {
            $table->id();
            $table->string('ekomn_name');
            $table->string('address');
            $table->string('pincode');
            $table->string('city');
            $table->string('state');
            $table->string('contact');
            $table->string('email');
            $table->string('gst');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekomn_details');
    }
};

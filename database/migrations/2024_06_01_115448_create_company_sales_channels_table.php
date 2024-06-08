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
        Schema::create('company_sales_channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_channel_id')->constrained('sales_channels');
            $table->foreignId('company_id')->constrained('company_details');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_sales_channels');
    }
};

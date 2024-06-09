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
        Schema::create('company_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('plan_id');
            $table->date('subscription_start_date');
            $table->date('subscription_end_date');
            
            $table->timestamps();

            // Assuming you have foreign keys to companies and plans tables
            $table->foreign('company_id')->references('id')->on('company_details');
            $table->foreign('plan_id')->references('id')->on('plans');
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_plans');
    }
};

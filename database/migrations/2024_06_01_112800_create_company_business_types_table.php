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
        Schema::create('company_business_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_type_id')->constrained('business_types');
            $table->foreignId('company_id')->constrained('company_details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_business_types');
    }
};

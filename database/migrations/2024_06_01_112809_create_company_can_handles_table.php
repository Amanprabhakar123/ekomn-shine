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
        Schema::create('company_can_handles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('can_handles_id')->constrained('can_handles');
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
        Schema::dropIfExists('company_can_handles');
    }
};

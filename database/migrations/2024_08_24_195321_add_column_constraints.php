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
        Schema::table('company_address_details', function (Blueprint $table) {
            // update existing columns to nullable
            $table->string('city')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('pincode')->nullable()->change();
            $table->string('address_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_address_details', function (Blueprint $table) {
            //
        });
    }
};

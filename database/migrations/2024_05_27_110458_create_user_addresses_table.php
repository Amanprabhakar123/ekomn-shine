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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('User_id')->nullable();
            $table->string('Address_line1')->nullable();
            $table->string('Address_line2')->nullable();
            $table->string('City')->nullable();
            $table->string('Address_type')->nullable();
            $table->string('Postal_code')->nullable();
            $table->string('Country')->nullable();
            $table->string('Is_primary')->nullable();
            $table->string('Telephone')->nullable();
            $table->string('Status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};

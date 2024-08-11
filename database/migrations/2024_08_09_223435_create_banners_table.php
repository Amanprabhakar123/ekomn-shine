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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image_path');
            $table->tinyInteger('banner_type')->default(1)->comment('1-home', '2-category', '3-product', '4-user_dashboard');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->enum('user_role', ['buyer', 'supplier', 'super-admin'])->nullable()->comment('buyer', 'supplier', 'super-admin');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};

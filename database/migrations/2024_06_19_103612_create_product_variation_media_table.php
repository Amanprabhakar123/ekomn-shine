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
        Schema::create('product_variation_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id');
            $table->tinyInteger('media_type'); // 0 for image, 1 for video
            $table->string('file_path', 255);
            $table->boolean('is_master')->default(0); // Primary Image or Video
            $table->text('desc')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->foreign('product_variation_id')->references('id')->on('product_variations');
            $table->foreign('product_id')->references('id')->on('product_inventories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variation_media');
    }
};

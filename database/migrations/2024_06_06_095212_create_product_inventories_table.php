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
       
        Schema::create('product_inventories', function (Blueprint $table) {
            $table->id('id');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('product_category')->nullable();
            $table->string('product_subcategory')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->comment('Supplier id');
            $table->string('model', 255)->nullable();
            $table->string('sku', 100)->unique();
            $table->string('hsn', 100)->nullable();
            $table->decimal('gst_percentage', 5, 2)->nullable();
            $table->string('upc', 100)->nullable();
            $table->string('isbn', 100)->nullable();
            $table->string('mpin', 100)->nullable();
            $table->tinyInteger('availability_status')->default(2);
            $table->tinyInteger('status')->default(1);  
            $table->softDeletes();
            $table->timestamps();

            // Assuming you have foreign keys to companies and suppliers tables
            $table->foreign('company_id')->references('id')->on('company_details');
            // $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_inventories');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShineProductsTable extends Migration
{
    public function up()
    {
        Schema::create('shine_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('assigner_id')->nullable();
            $table->string('batch_id');
            $table->string('request_no');
            $table->string('name');
            $table->string('platform');
            $table->string('url');
            $table->string('product_id');
            $table->string('seller_name');
            $table->string('search_term');
            $table->decimal('amount', 10, 2);
            $table->string('feedback_title');
            $table->text('feedback_comment');
            $table->integer('review_rating');
            $table->integer('status');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('shine_products');
    }
};



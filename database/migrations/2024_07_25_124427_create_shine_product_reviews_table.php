<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShineProductReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('shine_product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shine_product_id')->constrained()->onDelete('cascade');
            $table->string('order_number');
            $table->string('order_invoice');
            $table->text('requestor_comment')->nullable();
            $table->integer('requestor_confirmation');
            $table->text('screenshots')->nullable();
            $table->integer('requestor_confirmation_complition')->nullable();
            $table->text('feedback_comment')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shine_product_reviews');
    }
};


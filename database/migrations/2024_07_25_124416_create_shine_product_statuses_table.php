<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShineProductStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('shine_product_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shine_product_id')->constrained()->onDelete('cascade');
            $table->string('status');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shine_product_statuses');
    }
};

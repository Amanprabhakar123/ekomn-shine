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
        Schema::create('return_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('return_id')->nullable()->comment('Return ID from Return Orders table');
            $table->string('role_type')->nullable()->comment('The role of the user who made the comment like buyer, supplier, admin, etc');
            $table->text('comment')->nullable()->comment('The comment made by the user');
            $table->timestamps();
            $table->foreign('return_id')->references('id')->on('return_orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_comments');
    }
};

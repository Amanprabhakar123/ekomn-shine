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
        Schema::create('import_error_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('import_id');
            $table->string('row_number');
            $table->text('error_message');
            $table->foreign('import_id')->references('id')->on('import')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_error_messages');
    }
};

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
        Schema::create('shipment_awbs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipment_id')->nullable()->comment('Shipment ID from Shipments table'); 
            $table->string('awb_number')->nullable()->comment('AWB number provided by the courier service');
            $table->timestamp('awb_date')->default(now());
            $table->tinyInteger('courier_type')->default(1)->comment('1: Surface, 2: Air');
            $table->string('courier_provider_name')->nullable()->comment('Name of the courier service provider');
            $table->tinyInteger('status')->default(1)->comment('1: Created, 2: Shipped Or Dispatched, 3: Delivered, 4: Cancelled, 5: RTO');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('shipment_id')->references('id')->on('shipments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_awbs');
    }
};

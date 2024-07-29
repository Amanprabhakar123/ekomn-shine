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
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreign('shipping_address_id')->references('id')->on('order_addresses');
                $table->foreign('billing_address_id')->references('id')->on('order_addresses');
                $table->foreign('pickup_address_id')->references('id')->on('order_addresses');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['shipping_address_id']);
                $table->dropForeign(['billing_address_id']);
                $table->dropForeign(['pickup_address_id']);
            });
        }
    }
};

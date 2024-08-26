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
        Schema::table('order_payment_distributions', function (Blueprint $table) {
            $table->tinyInteger('refund_type')->default(1)->comment('1: Cancellation, 2: Return');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_payment_distributions', function (Blueprint $table) {
            $table->dropColumn('refund_type');
        });
    }
};

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
        Schema::table('supplier_payments', function (Blueprint $table) {
            $table->decimal('tds', 5, 2)->nullable()->after('order_id')->comment('TDS percentage of the payment');
            $table->decimal('tcs', 5, 2)->nullable()->after('tds')->comment('TCS percentage of the payment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplier_payments', function (Blueprint $table) {
            $table->dropColumnIfExists('tds');
            $table->dropColumnIfExists('tcs');
        });
    }
};

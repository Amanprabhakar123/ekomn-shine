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

        Schema::table('product_variations', function (Blueprint $table) {
            $table->tinyInteger('allow_editable')->default(0)->after('tier_shipping_rate')->comment('0: Not Editable, 1: Editable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variations', function (Blueprint $table) {
            $table->dropColumn('allow_editable');
        });
    }
};

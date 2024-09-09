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
        Schema::table('company_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('company_plan_paymnet_id')->nullable()->after('company_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_plans', function (Blueprint $table) {
            $table->dropColumn('company_plan_paymnet_id');
        });
    }
};

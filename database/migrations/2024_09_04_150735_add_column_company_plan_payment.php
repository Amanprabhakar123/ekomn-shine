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
        Schema::table('company_plan_payments', function (Blueprint $table) {
            $table->string('amount_with_gst')->nullable()->after('amount');
            $table->string('gst_percent')->nullable()->after('amount_with_gst');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_plan_payments', function (Blueprint $table) {
            $table->dropColumn('amount_with_gst');
            $table->dropColumn('gst_percent');
        });
    }
};

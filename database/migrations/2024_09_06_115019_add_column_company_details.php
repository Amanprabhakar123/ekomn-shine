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
        Schema::table('company_details', function (Blueprint $table) {
            $table->string('razorpay_subscription_id')->nullable()->after('gst_verified');
            $table->string('razorpay_plan_id')->nullable()->after('razorpay_subscription_id');
            $table->tinyInteger('subscription_status')->default(0)->after('razorpay_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_details', function (Blueprint $table) {
            $table->dropColumn('razorpay_subscription_id');
            $table->dropColumn('razorpay_plan_id');
            $table->dropColumn('subscription_status');
        });
    }
};

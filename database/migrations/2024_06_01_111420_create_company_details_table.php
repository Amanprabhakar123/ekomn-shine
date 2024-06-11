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
        Schema::create('company_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('business_name', 191)->default(null);
            $table->string('display_name', 191)->default(null);
            $table->string('designation', 191)->nullable();
            $table->string('first_name', 191)->default(null);
            $table->string('last_name', 191)->nullable();
            $table->string('email', 191)->default(null);
            $table->string('mobile_no', 20)->default(null);
            $table->string('pan_no', 10)->nullable();
            $table->string('gst_no', 15)->nullable();
            $table->string('pan_no_file_path', 191)->nullable();
            $table->string('gst_no_file_path', 191)->nullable();
            $table->boolean('pan_verified')->default(false);
            $table->boolean('gst_verified')->default(false);
            $table->string('language_i_can_read', 191)->nullable();
            $table->string('language_i_can_understand', 191)->nullable();
            $table->json('alternate_business_contact')->nullable();
            $table->string('bank_name', 191)->nullable();
            $table->string('bank_account_no', 50)->nullable();
            $table->string('ifsc_code', 20)->nullable();
            $table->string('swift_code', 20)->nullable();
            $table->string('cancelled_cheque_file_path', 191)->nullable()->default(null);
            $table->string('signature_image_file_path', 191)->nullable()->default(null);
            $table->boolean('bank_account_verified')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_details');
    }
};

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPlanPayment extends Model
{
    use HasFactory;

    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_SUCCESS = 'success';
    const PAYMENT_STATUS_FAILED = 'failed';

    protected $fillable = [
        'transaction_id',
        'purchase_id',
        'plan_id',
        'receipt_id',
        'company_id',
        'is_trial_plan',
        'currency',
        'email',
        'mobile',
        'buyer_id', // buyer_id is the user_id of the buyer temp table or buyer table
        'amount',
        'payment_status',
        'razorpay_payment_id',
        'razorpay_signature',
        'json_response',
    ];

    protected $casts = [
        'json_response' => 'array',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPayment extends Model
{
    use HasFactory;


    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_EXPIRED = 2;
    
    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_SUCCESS = 'success';
    const PAYMENT_STATUS_FAILED = 'failed';
    
    protected $fillable = [
        'company_id',
        'plan_id',
        'subscription_start_date',
        'subscription_end_date',
        'total_amount_paid',
        'validity_months',
        'payment_status',
        'status',
    ];

    protected $casts = [
        'subscription_start_date' => 'date',
        'subscription_end_date' => 'date',
        'total_amount_paid' => 'decimal:2',
        'validity_months' => 'integer',
        'status' => 'string',
    ];
}

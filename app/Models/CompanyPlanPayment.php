<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyPlanPayment extends Model
{
    use HasFactory, LogsActivity;

    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_SUCCESS = 'success';
    const PAYMENT_STATUS_FAILED = 'failed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'json_response' => 'array',
    ];

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'transaction_id',
                'purchase_id',
                'plan_id',
                'receipt_id',
                'company_id',
                'is_trial_plan',
                'currency',
                'email',
                'mobile',
                'buyer_id',
                'amount',
                'payment_status',
                'razorpay_payment_id',
                'razorpay_signature',
                'json_response',
            ])
            ->logOnlyDirty()
            ->useLogName('Company Plan Payment Log')
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} company plan payments with ID: {$this->id}");
    }
}

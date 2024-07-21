<?php

namespace App\Models;

use App\Models\CompanyDetail;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanPayment extends Model
{
    use HasFactory, LogsActivity;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_EXPIRED = 2;
    
    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_SUCCESS = 'success';
    const PAYMENT_STATUS_FAILED = 'failed';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'subscription_start_date' => 'date',
        'subscription_end_date' => 'date',
        'total_amount_paid' => 'decimal:2',
        'validity_months' => 'integer',
        'status' => 'string',
    ];

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'company_id',
            'plan_id',
            'subscription_start_date',
            'subscription_end_date',
            'total_amount_paid',
            'validity_months',
            'payment_status',
            'status',
        ])
        ->logOnlyDirty()
        ->useLogName('Plan Payment Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} plan payment with ID: {$this->id}");
    }

    /**
     * Get the company that owns the plan payment.
     */
    public function company()
    {
        return $this->belongsTo(CompanyDetail::class, 'company_id', 'id');
    }
}

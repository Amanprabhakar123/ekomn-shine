<?php

namespace App\Models;

use App\Models\SupplierPayment;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderPaymentDistribution extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'order_payment_id',
        'supplier_id',
        'amount',
        'status',
        'is_refunded',
        'refund_status',
        'refunded_amount',
        'refund_initiated_at',
        'refund_completed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'refunded_amount' => 'decimal:2',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $dates = [
        'refund_initiated_at',
        'refund_completed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    const STATUS_NA = 0;
    const STATUS_HOLD = 1;
    const STATUS_ACCURED = 2;
    const STATUS_PAID = 3;
    const STATUS_DUE = 4;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    const REFUND_STATUS_NA = self::STATUS_NA;
    const REFUND_STATUS_HOLD = self::STATUS_HOLD;
    const REFUND_STATUS_ACCURED = self::STATUS_ACCURED;
    const REFUND_STATUS_PAID = self::STATUS_PAID;
    const REFUND_STATUS_DUE = self::STATUS_DUE;

    // Default Adjustment amount 
    const DEFAULT_ADJUSTMENT_AMOUNT = 0;

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'order_id',
            'order_payment_id',
            'supplier_id',
            'amount',
            'status',
            'is_refunded',
            'refund_status',
            'refunded_amount',
            'refund_initiated_at',
            'refund_completed_at',
        ])
        ->logOnlyDirty()
        ->useLogName('Order Payment Distribution Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} order payment distribution with ID: {$this->id}");
    }

    /**
     * Get the order that owns the order payment distribution.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Get the order payment that owns the order payment distribution.
     */
    public function orderPayment()
    {
        return $this->belongsTo(OrderPayment::class, 'order_payment_id', 'id');
    }

    /**
     * Get the supplier that owns the order payment distribution.
     */
    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id', 'id');
    }

    public function supplierPayment()
    {
        return $this->hasOne(SupplierPayment::class, 'distribution_id', 'id');
    }

    /**
     * Scope a query to only include order payment distributions that are due.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDue($query)
    {
        return $query->where('status', self::STATUS_DUE);
    }

    /**
     * Scope a query to only include order payment distributions that are not refunded.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotRefunded($query)
    {
        return $query->where('is_refunded', false);
    }

    /**
     * Scope a query to only include order payment distributions that are refunded.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRefunded($query)
    {
        return $query->where('is_refunded', true);
    }

    /**
     * Scope a query to only include order payment distributions that are due for refund.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDueForRefund($query)
    {
        return $query->where('refund_status', self::REFUND_STATUS_DUE);
    }

     /**
     * Get the status attribute.
     * 
     * @param  int  $value
     * @return string|null
     */
    public function getStatus(int $value): ?string
    {
        switch ($value) {
            case self::STATUS_NA:
                return 'NA';
            case self::STATUS_HOLD:
                return 'Hold';
            case self::STATUS_ACCURED:
                return 'Accured';
            case self::STATUS_PAID:
                return 'Paid';
            case self::STATUS_DUE:
                return 'Due';
            default:
                return null;
        }
    }

    /**
     * Get the refund status attribute.
     * 
     * @param  int  $value
     * @return string|null
     */
    public function getRefundStatus(int $value): ?string
    {
        switch ($value) {
            case self::REFUND_STATUS_NA:
                return 'NA';
            case self::REFUND_STATUS_HOLD:
                return 'Hold';
            case self::REFUND_STATUS_ACCURED:
                return 'Accured';
            case self::REFUND_STATUS_PAID:
                return 'Paid';
            case self::REFUND_STATUS_DUE:
                return 'Due';
            default:
                return null;
        }
    }

    /**
     * Check if the order payment distribution is refunded.
     *
     * @return bool
     */
    public function isRefunded(): bool
    {
        return $this->is_refunded;
    }

    /**
     * Check if the order payment distribution is not refunded.
     *
     * @return bool
     */
    public function isNotRefunded(): bool
    {
        return !$this->is_refunded;
    }

    /**
     * Check if the order payment distribution is due for refund.
     *
     * @return bool
     */
    public function isDueForRefund(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_DUE;
    }

    /**
     * Check if the order payment distribution is due.
     *
     * @return bool
     */
    public function isDue(): bool
    {
        return $this->status === self::STATUS_DUE;
    }

    /**
     * Check if the order payment distribution is paid.
     *
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    /**
     * Check if the order payment distribution is accured.
     *
     * @return bool
     */
    public function isAccured(): bool
    {
        return $this->status === self::STATUS_ACCURED;
    }

    /**
     * Check if the order payment distribution is on hold.
     *
     * @return bool
     */
    public function isHold(): bool
    {
        return $this->status === self::STATUS_HOLD;
    }
    
}

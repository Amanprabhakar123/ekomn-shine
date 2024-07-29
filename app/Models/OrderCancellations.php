<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderCancellations extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'refund_id',
        'cancelled_by_id',
        'reason',
        'cancelled_by',
        'refund_status',
        'refund_amount',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'refund_amount' => 'decimal:2',
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
    const CANCELLED_BY_CUSTOMER = 1;
    const CANCELLED_BY_ADMIN = 2;
    const CANCELLED_BY_SUPPLIER = 3;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    const REFUND_STATUS_PENDING = 1;
    const REFUND_STATUS_APPROVED = 2;
    const REFUND_STATUS_REJECTED = 3;

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'order_id',
            'refund_id',
            'cancelled_by_id',
            'reason',
            'cancelled_by',
            'refund_status',
            'refund_amount',
        ])
        ->logOnlyDirty()
        ->useLogName('Order Cancellation Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} order cancellation with ID: {$this->id}");
    }

    /**
     * Get the order that owns the OrderCancellations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Get the user that owns the OrderCancellations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by_id', 'id');
    }

    /**
     * Get the refund that owns the OrderCancellations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function refund()
    {
        return $this->belongsTo(OrderRefund::class, 'refund_id', 'id');
    }

    /**
     * Get the refund status attribute.
     *
     * @return string|null
     */
    public function getRefundStatus(): ?string
    {
        switch ($this->refund_status) {
            case self::REFUND_STATUS_PENDING:
                return 'Pending';
            case self::REFUND_STATUS_APPROVED:
                return 'Approved';
            case self::REFUND_STATUS_REJECTED:
                return 'Rejected';
            default: 
                return null;
        }
    }

    /**
     * Get the cancelled by attribute.
     *
     * @return string|null
     */
    public function getCancelledBy(): ?string
    {
        switch ($this->cancelled_by) {
            case self::CANCELLED_BY_CUSTOMER:
                return 'Customer';
            case self::CANCELLED_BY_ADMIN:
                return 'Admin';
            case self::CANCELLED_BY_SUPPLIER:
                return 'Supplier';
            default: 
                return null;
        }
    }

    /**
     * Get the refund amount attribute.
     *
     * @return string|null
     */
    public function getRefundAmount(): ?string
    {
        return number_format($this->refund_amount, 2);
    }

    /**
     * Get the refund amount attribute.
     *
     * @return string|null
     */
    public function getRefundAmountInr(): ?string
    {
        return '₹ ' . number_format($this->refund_amount, 2);
    }

    /**
     * Check if the refund is pending.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_PENDING;
    }

    /**
     * Check if the refund is approved.
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_APPROVED;
    }

    /**
     * Check if the refund is rejected.
     *
     * @return bool
     */
    public function isRejected(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_REJECTED;
    }

    /**
     * Check if the refund is rejected.
     *
     * @return bool
     */
    public function isCustomer(): bool
    {
        return $this->cancelled_by === self::CANCELLED_BY_CUSTOMER;
    }

    /**
     * Check if the refund is rejected.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->cancelled_by === self::CANCELLED_BY_ADMIN;
    }

    /**
     * Check if the refund is rejected.
     *
     * @return bool
     */
    public function isSupplier(): bool
    {
        return $this->cancelled_by === self::CANCELLED_BY_SUPPLIER;
    }

    /**
     * Check if the refund is rejected.
     *
     * @return bool
     */
    public function isRefundableByAdmin(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_PENDING && $this->cancelled_by === self::CANCELLED_BY_ADMIN;
    }

    /**
     * Check if the refund is rejected.
     *
     * @return bool
     */
    public function isRefundableByCustomer(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_PENDING && $this->cancelled_by === self::CANCELLED_BY_CUSTOMER;
    }
    
}

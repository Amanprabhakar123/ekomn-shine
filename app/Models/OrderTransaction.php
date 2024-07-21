<?php

namespace App\Models;

use App\Models\Order;
use App\Models\OrderRefund;
use App\Models\OrderPayment;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderTransaction extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'order_payment_id',
        'transaction_date',
        'transaction_type',
        'transaction_amount',
        'transaction_currency',
        'razorpay_transaction_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    const TRANSACTION_TYPE_PAYMENT = 1;
    const TRANSACTION_TYPE_REFUND = 2;

    /** 
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    const CURRENCY_INR = 1;
    const CURRENCY_USD = 2;
    const CURRENCY_EUR = 3;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    const STATUS_SUCCESS = 1;
    const STATUS_FAILED = 2;
    const STATUS_PENDING = 3;
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'transaction_date' => 'datetime',
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
     * Get the options for logging changes to the model.
     */
   public function getActivitylogOptions(): LogOptions
   {
       return LogOptions::defaults()
       ->logOnly([
              'order_id',
              'order_payment_id',
              'transaction_date',
              'transaction_type',
              'transaction_amount',
              'transaction_currency',
              'razorpay_transaction_id',
              'status',
       ])
       ->logOnlyDirty()
       ->useLogName('Order Transaction Log')
       ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} order transaction with ID: {$this->id}");
   }

   /**
    * Get the order that owns the order transaction.
    */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Get the order payment that owns the order transaction.
     */
    public function orderPayment()
    {
        return $this->belongsTo(OrderPayment::class, 'order_payment_id', 'id');
    }

    /**
     * Get the order refund that owns the order transaction.
     */
    public function orderRefund()
    {
        return $this->hasOne(OrderRefund::class, 'transaction_id', 'id');
    }

    /**
     * Scope a query to only include payment transactions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePayment($query)
    {
        return $query->where('transaction_type', self::TRANSACTION_TYPE_PAYMENT);
    }

    /**
     * Scope a query to only include refund transactions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRefund($query)
    {
        return $query->where('transaction_type', self::TRANSACTION_TYPE_REFUND);
    }

    /**
     * Get the transaction type attribute.
     *
     * @param  int  $value
     * @return string|null
     */
    public function getTransactionType(int $value): ?string
    {
        switch ($value) {
            case self::TRANSACTION_TYPE_PAYMENT:
                return 'Payment';
            case self::TRANSACTION_TYPE_REFUND:
                return 'Refund';
            default:
                return null;
        }
    }

    /**
     * Get the currency attribute.
     *
     * @param  int  $value
     * @return string|null
     */
    public function getCurrency(int $value): ?string
    {
        switch ($value) {
            case self::CURRENCY_INR:
                return 'INR';
            case self::CURRENCY_USD:
                return 'USD';
            case self::CURRENCY_EUR:
                return 'EUR';
            default:
                return null;
        }
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
            case self::STATUS_SUCCESS:
                return 'Success';
            case self::STATUS_FAILED:
                return 'Failed';
            case self::STATUS_PENDING:
                return 'Pending';
            default:
                return null;
        }
    }

    /**
     * Check if the transaction is in INR.
     *
     * @return bool
     */
    public function isInr(): bool
    {
        return $this->transaction_currency === self::CURRENCY_INR;
    }

    /**
     * Check if the transaction is successful.
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    /**
     * Check if the transaction is failed.
     *
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * Check if the transaction is pending.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if the transaction is a payment.
     *
     * @return bool
     */
    public function isPayment(): bool
    {
        return $this->transaction_type === self::TRANSACTION_TYPE_PAYMENT;
    }

    /**
     * Check if the transaction is a refund.
     *
     * @return bool
     */
    public function isRefund(): bool
    {
        return $this->transaction_type === self::TRANSACTION_TYPE_REFUND;
    }

    /**
     * Check if the transaction is in USD.
     *
     * @return bool
     */
    public function isUsd(): bool
    {
        return $this->transaction_currency === self::CURRENCY_USD;
    }

    /**
     * Check if the transaction is in EUR.
     *
     * @return bool
     */
    public function isEur(): bool
    {
        return $this->transaction_currency === self::CURRENCY_EUR;
    }
}

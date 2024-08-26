<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderTransaction;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderRefund extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'transaction_id',
        'order_payment_id',
        'refund_type',
        'buyer_id',
        'amount',
        'currency',
        'status',
        'reason',
        'initiated_by',
        'refund_method',
        'refund_date',
        'completed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    const REFUND_METHOD_RAZORPAY = 1;
    const REFUND_METHOD_PAYTM = 2;
    const REFUND_METHOD_UPI = 3;
    const REFUND_METHOD_NET_BANKING = 4;
    const REFUND_METHOD_DEBIT_CARD = 5;
    const REFUND_METHOD_CREDIT_CARD = 6;
    const REFUND_METHOD_WALLET = 7;
    const REFUND_METHOD_BANK_TRANSFER = 8;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    const CURRENCY_INR = 1;
    const CURRENCY_USD = 2;
    const CURRENCY_EUR = 3;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    const STATUS_INITIATED = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_FAILED = 4;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    const INITIATED_BY_ADMIN = 1;
    const INITIATED_BY_SYSTEM = 2;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    const REFUND_TYPE_CANCEL = 1;
    const REFUND_TYPE_RETURN = 2;

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
    protected $casts = [
        'refund_date' => 'datetime',
        'completed_at' => 'datetime',
    ];


    
    /**
     * Get the options for logging changes to the model.
     */
   public function getActivitylogOptions(): LogOptions
   {
       return LogOptions::defaults()
       ->logOnly([
            'order_id',
            'transaction_id',
            'order_payment_id',
            'refund_type',
            'buyer_id',
            'amount',
            'currency',
            'status',
            'reason',
            'initiated_by',
            'refund_method',
            'refund_date',
            'completed_at',
       ])
       ->logOnlyDirty()
       ->useLogName('Order Refund Log')
       ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} order refund with ID: {$this->id}");
   }

   /**
    * Get the order that owns the OrderRefund
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function order()
   {
       return $this->belongsTo(Order::class, 'order_id', 'id');
   }

   /**
    * Get the order transaction that owns the OrderRefund
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function orderTransaction()
    {
        return $this->belongsTo(OrderTransaction::class, 'transaction_id', 'id');
    }

    /**
     * Get the order payment that owns the OrderRefund
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderPayment()
    {
         return $this->belongsTo(OrderPayment::class, 'order_payment_id', 'id');
    }

    /**
     * Get the user that owns the OrderRefund
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    /**
     * Get the refund method attribute.
     *
     * @return string|null
     */
    public function getRefundMethod(): ?string
    {
        switch ($this->refund_method) {
            case self::REFUND_METHOD_RAZORPAY:
                return 'Razorpay';
            case self::REFUND_METHOD_PAYTM:
                return 'Paytm';
            case self::REFUND_METHOD_UPI:
                return 'UPI';
            case self::REFUND_METHOD_NET_BANKING:
                return 'Net Banking';
            case self::REFUND_METHOD_DEBIT_CARD:
                return 'Debit Card';
            case self::REFUND_METHOD_CREDIT_CARD:
                return 'Credit Card';
            case self::REFUND_METHOD_WALLET:
                return 'Wallet';
            case self::REFUND_METHOD_BANK_TRANSFER:
                return 'Bank Transfer';
            default: 
                return null;
        }
    }

    /**
     * Get the currency attribute.
     *
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        switch ($this->currency) {
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
     * Get the refund status attribute.
     *
     * @return string|null
     */
    public function getRefundStatus(): ?string
    {
        switch ($this->status) {
            case self::STATUS_INITIATED:
                return 'Initiated';
            case self::STATUS_PROCESSING:
                return 'Processing';
            case self::STATUS_COMPLETED:
                return 'Completed';
            case self::STATUS_FAILED:
                return 'Failed';
            default: 
                return null;
        }
    }

    /**
     * Get the refund initiated by attribute.
     *
     * @return string|null
     */
    public function getRefundInitiatedBy(): ?string
    {
        switch ($this->initiated_by) {
            case self::INITIATED_BY_ADMIN:
                return 'Admin';
            case self::INITIATED_BY_SYSTEM:
                return 'System';
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
        return number_format($this->amount, 2);
    }

    /**
     * Get the refund amount attribute.
     *
     * @return string|null
     */
    public function getRefundAmountInr(): ?string
    {
        return '₹ ' . number_format($this->amount, 2);
    }

    /**
     * Check if the refund is initiated.
     *
     * @return bool
     */
    public function isInitiated(): bool
    {
        return $this->status === self::STATUS_INITIATED;
    }

    /**
     * Check if the refund is processing.
     *
     * @return bool
     */
    public function isProcessing(): bool
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    /**
     * Check if the refund is completed.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if the refund is failed.
     *
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * Check if the refund is initiated by admin.
     *
     * @return bool
     */
    public function isInitiatedByAdmin(): bool
    {
        return $this->initiated_by === self::INITIATED_BY_ADMIN;
    }

    /**
     * Check if the refund is initiated by system.
     *
     * @return bool
     */
    public function isInitiatedBySystem(): bool
    {
        return $this->initiated_by === self::INITIATED_BY_SYSTEM;
    }

    /**
     * Check if the refund is in INR.
     *
     * @return bool
     */
    public function isInr(): bool
    {
        return $this->currency === self::CURRENCY_INR;
    }

    /**
     * Check if the refund is in USD.
     *
     * @return bool
     */
    public function isUsd(): bool
    {
        return $this->currency === self::CURRENCY_USD;
    }

    /**
     * Check if the refund is in EUR.
     *
     * @return bool
     */
    public function isEur(): bool
    {
        return $this->currency === self::CURRENCY_EUR;
    }

    /**
     * Check if the refund is Razorpay.
     *
     * @return bool
     */
    public function isRazorpay(): bool
    {
        return $this->refund_method === self::REFUND_METHOD_RAZORPAY;
    }

    /**
     * Check if the refund is Paytm.
     *
     * @return bool
     */
    public function isPaytm(): bool
    {
        return $this->refund_method === self::REFUND_METHOD_PAYTM;
    }

    /**
     * Check if the refund is UPI.
     *
     * @return bool
     */
    public function isUpi(): bool
    {
        return $this->refund_method === self::REFUND_METHOD_UPI;
    }

    /**
     * Check if the refund is Net Banking.
     *
     * @return bool
     */
    public function isNetBanking(): bool
    {
        return $this->refund_method === self::REFUND_METHOD_NET_BANKING;
    }

    /**
     * Check if the refund is Debit Card.
     *
     * @return bool
     */
    public function isDebitCard(): bool
    {
        return $this->refund_method === self::REFUND_METHOD_DEBIT_CARD;
    }

    /**
     * Check if the refund is Credit Card.
     *
     * @return bool
     */
    public function isCreditCard(): bool
    {
        return $this->refund_method === self::REFUND_METHOD_CREDIT_CARD;
    }

    /**
     * Check if the refund is Wallet.
     *
     * @return bool
     */
    public function isWallet(): bool
    {
        return $this->refund_method === self::REFUND_METHOD_WALLET;
    }

    /**
     * Check if the refund is Bank Transfer.
     *
     * @return bool
     */
    public function isBankTransfer(): bool
    {
        return $this->refund_method === self::REFUND_METHOD_BANK_TRANSFER;
    }

    /**
     * Check if the refund is initiated by admin.
     *
     * @return bool
     */
    public function isRefundable(): bool
    {
        return $this->status === self::STATUS_INITIATED;
    }

    /**
     * Check if the refund is initiated by admin.
     *
     * @return bool
     */
    public function isRefunded(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if the refund is initiated by admin.
     *
     * @return bool
     */
    public function isFailedRefund(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * Check if the refund is initiated by admin.
     *
     * @return bool
     */
    public function isRefundableByAdmin(): bool
    {
        return $this->status === self::STATUS_INITIATED && $this->initiated_by === self::INITIATED_BY_ADMIN;
    }

    /**
     * Check if the refund is initiated by admin.
     *
     * @return bool
     */
    public function isRefundableBySystem(): bool
    {
        return $this->status === self::STATUS_INITIATED && $this->initiated_by === self::INITIATED_BY_SYSTEM;
    }

}

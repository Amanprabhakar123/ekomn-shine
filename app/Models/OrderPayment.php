<?php

namespace App\Models;

use App\Models\Order;
use App\Models\OrderRefund;
use App\Models\OrderTransaction;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderPaymentDistribution;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderPayment extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'razorpay_order_id',
        'razorpay_payment_id',
        'payment_date',
        'payment_method',
        'amount',
        'currency',
        'status',
        'razorpay_signature',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    const PAYMENT_METHOD_RAZORPAY = 1;
    const PAYMENT_METHOD_PAYTM = 2;
    const PAYMENT_METHOD_UPI = 3;
    const PAYMENT_METHOD_NET_BANKING = 4;
    const PAYMENT_METHOD_DEBIT_CARD = 5;
    const PAYMENT_METHOD_CREDIT_CARD = 6;
    const PAYMENT_METHOD_WALLET = 7;
    const PAYMENT_METHOD_BANK_TRANSFER = 8;
    

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
    const STATUS_CREATED = 1;
    const STATUS_AUTHORIZED = 2;
    const STATUS_CAPTURED = 3;
    const STATUS_REFUNDED = 4;
    const STATUS_FAILED = 5;

    const REFUND_SPEED = "normal";

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_date' => 'datetime',
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
            'razorpay_payment_id',
            'payment_date',
            'payment_method',
            'amount',
            'currency',
            'status',
            'razorpay_signature',
            'description',
        ])
        ->logOnlyDirty()
        ->useLogName('Order Payment Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} order payment with ID: {$this->id}");
    }

    /**
     * Get the order that owns the order payment.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Get the order transactions for the order payment.
     */
    public function orderTransactions()
    {
        return $this->hasMany(OrderTransaction::class, 'order_payment_id', 'id');
    }

    /**
     * Get the order payment distributions for the order payment.
     */
    public function orderPaymentDistributions()
    {
        return $this->hasMany(OrderPaymentDistribution::class, 'order_payment_id', 'id');
    }

    /**
     * Get the order refund for the order payment.
     */
    public function orderRefund()
    {
        return $this->hasOne(OrderRefund::class, 'order_payment_id', 'id');
    }

    /**
     * Get the payment method attribute.
     *
     * @param  int  $value
     * @return string|null
     */
    public function getPaymentMethod(int $value): ?string
    {
        switch ($value) {
            case self::PAYMENT_METHOD_RAZORPAY:
                return 'Razorpay';
            case self::PAYMENT_METHOD_PAYTM:
                return 'Paytm';
            case self::PAYMENT_METHOD_UPI:
                return 'UPI';
            case self::PAYMENT_METHOD_NET_BANKING:
                return 'Net Banking';
            case self::PAYMENT_METHOD_DEBIT_CARD:
                return 'Debit Card';
            case self::PAYMENT_METHOD_CREDIT_CARD:
                return 'Credit Card';
            case self::PAYMENT_METHOD_WALLET:
                return 'Wallet';
            case self::PAYMENT_METHOD_BANK_TRANSFER:
                return 'Bank Transfer';
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
            case self::STATUS_CREATED:
                return 'Created';
            case self::STATUS_AUTHORIZED:
                return 'Authorized';
            case self::STATUS_CAPTURED:
                return 'Captured';
            case self::STATUS_REFUNDED:
                return 'Refunded';
            case self::STATUS_FAILED:
                return 'Failed';
            default:
                return null;
        }
    }

    
    /**
     * Get the refund amount attribute.
     *
     * @return string|null
     */
    public function getAmountInr(): ?string
    {
        return '₹ ' . number_format($this->amount, 2);
    }

    /**
     * Check if the order is in INR.
     *
     * @return bool
     */
    public function isInr(): bool
    {
        return $this->payment_currency === self::CURRENCY_INR;
    }

    /**
     * Check if the order is in USD.
     *
     * @return bool
     */
    public function isUsd(): bool
    {
        return $this->payment_currency === self::CURRENCY_USD;
    }

    /**
     * Check if the order is in EUR.
     *
     * @return bool
     */
    public function isEur(): bool
    {
        return $this->payment_currency === self::CURRENCY_EUR;
    }

    /**
     * Check if the order is created.
     *
     * @return bool
     */
    public function isCreated(): bool
    {
        return $this->payment_status === self::STATUS_CREATED;
    }

    /**
     * Check if the order is authorized.
     *
     * @return bool
     */
    public function isAuthorized(): bool
    {
        return $this->payment_status === self::STATUS_AUTHORIZED;
    }

    /**
     * Check if the order is captured.
     *
     * @return bool
     */
    public function isCaptured(): bool
    {
        return $this->payment_status === self::STATUS_CAPTURED;
    }

    /**
     * Check if the order is refunded.
     *
     * @return bool
     */
    public function isRefunded(): bool
    {
        return $this->payment_status === self::STATUS_REFUNDED;
    }

    /**
     * Check if the order is failed.
     *
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->payment_status === self::STATUS_FAILED;
    }

    /**
     * Check if the order is Razorpay.
     *
     * @return bool
     */
    public function isRazorpay(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_RAZORPAY;
    }

    /**
     * Check if the order is Paytm.
     *
     * @return bool
     */
    public function isPaytm(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_PAYTM;
    }

    /**
     * Check if the order is UPI.
     *
     * @return bool
     */
    public function isUpi(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_UPI;
    }

    /**
     * Check if the order is Net Banking.
     *
     * @return bool
     */
    public function isNetBanking(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_NET_BANKING;
    }

    /**
     * Check if the order is Debit Card.
     *
     * @return bool
     */
    public function isDebitCard(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_DEBIT_CARD;
    }

    /**
     * Check if the order is Credit Card.
     *
     * @return bool
     */
    public function isCreditCard(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_CREDIT_CARD;
    }

    /**
     * Check if the order is Wallet.
     *
     * @return bool
     */
    public function isWallet(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_WALLET;
    }

    /**
     * Check if the order is Bank Transfer.
     *
     * @return bool
     */
    public function isBankTransfer(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_BANK_TRANSFER;
    }

}

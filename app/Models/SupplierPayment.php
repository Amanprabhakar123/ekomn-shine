<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use Spatie\Activitylog\LogOptions;
use App\Models\SupplierPaymentInvoice;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderPaymentDistribution;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierPayment extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'distribution_id',
        'supplier_id',
        'order_id',
        'adjustment_amount',
        'disburse_amount',
        'statement_date',
        'payment_date',
        'payment_status',
        'payment_method',
        'transaction_id',
        'invoice_generated',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'statement_date' => 'datetime',
        'payment_date' => 'datetime',
        'invoice_generated' => 'boolean',
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
    const PAYMENT_STATUS_NA = 0;
    const PAYMENT_STATUS_HOLD = 1;
    const PAYMENT_STATUS_ACCURED = 2;
    const PAYMENT_STATUS_PAID = 3;
    const PAYMENT_STATUS_DUE = 4;


    /**
     * The attributes that should be cast to native types.
     *  @var array<string, string>
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
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'distribution_id',
            'supplier_id',
            'order_id',
            'adjustment_amount',
            'disburse_amount',
            'statement_date',
            'payment_date',
            'payment_status',
            'payment_method',
            'transaction_id',
            'invoice_generated',
        ])
        ->logOnlyDirty()
        ->useLogName('Supplier Payment Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} supplier payment with ID: {$this->id}");
    }

    /**
     * Get the distribution that owns the SupplierPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function distribution()
    {
        return $this->belongsTo(OrderPaymentDistribution::class, 'distribution_id');
    }

    /**
     * Get the supplier that owns the SupplierPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id', 'id');
    }

    /**
     * Get the order that owns the SupplierPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function supplierPaymentInvoice()
    {
        return $this->hasOne(SupplierPaymentInvoice::class, 'supplier_payments_id');
    }

    /**
     * Get the payment status name based on the payment status int value.
     *
     * @param int $value
     * @return string
     */
    public function getPaymentStatus() : ?string
    {
        switch ($this->payment_status) {
            case self::PAYMENT_STATUS_NA:
                return 'NA';
            case self::PAYMENT_STATUS_HOLD:
                return 'Hold';
            case self::PAYMENT_STATUS_ACCURED:
                return 'Accured';
            case self::PAYMENT_STATUS_PAID:
                return 'Paid';
            case self::PAYMENT_STATUS_DUE:
                return 'Due';
            default:
                return null;
        }
    }

    /**
     * Get the payment method name based on the payment method int value.
     *
     * @param int $value
     * @return string
     */
    public function getPaymentMethod() : ?string
    {
        switch ($this->payment_method) {
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
     * Check if the payment status is NA.
     *
     * @return bool
     */
    public function isPaymentStatusNA(): bool
    {
        return $this->payment_status === self::PAYMENT_STATUS_NA;
    }

    /**
     * Check if the payment status is Hold.
     *
     * @return bool
     */
    public function isPaymentStatusHold(): bool
    {
        return $this->payment_status === self::PAYMENT_STATUS_HOLD;
    }

    /**
     * Check if the payment status is Accured.
     *
     * @return bool
     */
    public function isPaymentStatusAccured(): bool
    {
        return $this->payment_status === self::PAYMENT_STATUS_ACCURED;
    }

    /**
     * Check if the payment status is Paid.
     *
     * @return bool
     */
    public function isPaymentStatusPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_STATUS_PAID;
    }

    /**
     * Check if the payment status is Due.
     *
     * @return bool
     */
    public function isPaymentStatusDue(): bool
    {
        return $this->payment_status === self::PAYMENT_STATUS_DUE;
    }

    /**
     * Check if the payment method is Razorpay.
     *
     * @return bool
     */
    public function isPaymentMethodRazorpay(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_RAZORPAY;
    }

    /**
     * Check if the payment method is Paytm.
     *
     * @return bool
     */
    public function isPaymentMethodPaytm(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_PAYTM;
    }

    /**
     * Check if the payment method is UPI.
     *
     * @return bool
     */
    public function isPaymentMethodUPI(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_UPI;
    }

    /**
     * Check if the payment method is Net Banking.
     *
     * @return bool
     */
    public function isPaymentMethodNetBanking(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_NET_BANKING;
    }

    /**
     * Check if the payment method is Debit Card.
     *
     * @return bool
     */
    public function isPaymentMethodDebitCard(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_DEBIT_CARD;
    }

    /**
     * Check if the payment method is Credit Card.
     *
     * @return bool
     */
    public function isPaymentMethodCreditCard(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_CREDIT_CARD;
    }

    /**
     * Check if the payment method is Wallet.
     *
     * @return bool
     */
    public function isPaymentMethodWallet(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_WALLET;
    }

    /**
     * Check if the payment method is Bank Transfer.
     *
     * @return bool
     */
    public function isPaymentMethodBankTransfer(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_BANK_TRANSFER;
    }

    /**
     * Check if the invoice is generated.
     *
     * @return bool
     */
    public function isInvoiceGenerated(): bool
    {
        return $this->invoice_generated;
    }

    /**
     * Check if the invoice is not generated.
     *
     * @return bool
     */
    public function isInvoiceNotGenerated(): bool
    {
        return !$this->invoice_generated;
    }
}

<?php

namespace App\Models;

use App\Models\User;
use App\Models\Shipment;
use App\Models\OrderRefund;
use App\Models\OrderAddress;
use App\Models\OrderPayment;
use App\Models\SupplierPayment;
use App\Models\OrderTransaction;
use App\Models\OrderCancellations;
use Spatie\Activitylog\LogOptions;
use App\Models\OrderItemAndCharges;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderPaymentDistribution;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * Constants for order status.
     */
    const STATUS_DRAFT = 1;
    const STATUS_PENDING = 2;
    const STATUS_IN_PROGRESS = 3;
    const STATUS_DISPATCHED = 4;
    const STATUS_IN_TRANSIT = 5;
    const STATUS_DELIVERED = 6;
    const STATUS_CANCELLED = 7;
    const STATUS_RTO = 8;

    /**
     * Constants for payment status.
     */
    const PAYMENT_STATUS_PENDING = 1;
    const PAYMENT_STATUS_PAID = 2;
    const PAYMENT_STATUS_FAILED = 3;

    /**
     * Constants for payment currency.
     */
    const PAYMENT_CURRENCY_INR = 1;
    const PAYMENT_CURRENCY_USD = 2;
    const PAYMENT_CURRENCY_EUR = 3;

    /**
     * Constants for order type.
     */
    const ORDER_TYPE_DROPSHIP = 1;
    const ORDER_TYPE_BULK = 2;
    const ORDER_TYPE_RESELL = 3;

    /**
     * Constants for order channel type.
     */
    const ORDER_CHANNEL_TYPE_MANUAL = 1;
    const ORDER_CHANNEL_TYPE_STORE = 2;

    /**
     * Constants for payment method.
     */
    const PAYMENT_METHOD_COD = 1;
    const PAYMENT_METHOD_ONLINE = 2;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_number',
        'buyer_id',
        'supplier_id',
        'store_order',
        'order_date',
        'status',
        'total_amount',
        'discount',
        'payment_status',
        'payment_currency',
        'order_type',
        'order_channel_type',
        'payment_method',
        'shipping_address_id',
        'billing_address_id',
        'pickup_address_id',
        'is_cancelled',
        'cancelled_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_date' => 'datetime',
        'cancelled_at' => 'datetime',
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
            'order_number',
            'buyer_id',
            'supplier_id',
            'store_order',
            'order_date',
            'status',
            'total_amount',
            'discount',
            'payment_status',
            'payment_currency',
            'order_type',
            'order_channel_type',
            'payment_method',
            'shipping_address_id',
            'billing_address_id',
            'pickup_address_id',
            'is_cancelled',
            'cancelled_at',
        ])
        ->logOnlyDirty()
        ->useLogName('Order Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} order with ID: {$this->id}");
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function shippingAddress()
    {
        return $this->belongsTo(OrderAddress::class, 'shipping_address_id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function billingAddress()
    {
        return $this->belongsTo(OrderAddress::class, 'billing_address_id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function pickupAddress()
    {
        return $this->belongsTo(OrderAddress::class, 'pickup_address_id', 'id');
    }
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function orderItemsCharges()
    {
        return $this->hasMany(OrderItemAndCharges::class);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'order_id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function orderPayments()
    {
        return $this->hasMany(OrderPayment::class, 'order_id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function orderTransactions()
    {
        return $this->hasMany(OrderTransaction::class, 'order_id', 'id');
    }


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function orderTransactionsThrough()
    {
        return $this->hasManyThrough(OrderTransaction::class, OrderPayment::class, 'order_id', 'order_payment_id', 'id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function orderPaymentDistributions()
    {
        return $this->hasMany(OrderPaymentDistribution::class, 'order_id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function orderPaymentDistributionsThrough()
    {
        return $this->hasManyThrough(OrderPaymentDistribution::class, OrderPayment::class, 'order_id', 'order_payment_id', 'id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function orderCancellations()
    {
        return $this->hasMany(OrderCancellations::class, 'order_id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function orderCancellationsThrough()
    {
        return $this->hasManyThrough(OrderCancellations::class, OrderPayment::class, 'order_id', 'order_payment_id', 'id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function orderRefunds()
    {
        return $this->hasMany(OrderRefund::class, 'order_id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function orderRefundsThrough()
    {
        return $this->hasManyThrough(OrderRefund::class, OrderPayment::class, 'order_id', 'order_payment_id', 'id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function orderInvoices()
    {
        return $this->hasMany(OrderInvoice::class, 'order_id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function orderInvoicesThrough()
    {
        return $this->hasManyThrough(OrderInvoice::class, OrderPayment::class, 'order_id', 'order_payment_id', 'id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function supplierPayments()
    {
        return $this->hasMany(SupplierPayment::class, 'order_id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function supplierPaymentsThrough()
    {
        return $this->hasManyThrough(SupplierPayment::class, OrderPayment::class, 'order_id', 'order_payment_id', 'id', 'id');
    }
    
    /**
     * Scope a query to only include orders of a particular buyer.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $buyerId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByBuyer($query, $buyerId)
    {
        return $query->where('buyer_id', $buyerId);
    }

    /**
     * Scope a query to only include orders of a particular supplier.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $supplierId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySupplier($query, $supplierId)
    {
        return $query->where('supplier_id', $supplierId);
    }

    /**
     * Scope a query to only include orders of a particular status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */ 
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include orders of a particular payment status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $paymentStatus
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPaymentStatus($query, $paymentStatus)
    {
        return $query->where('payment_status', $paymentStatus);
    }

    /**
     * Scope a query to only include orders of a particular order type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $orderType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByOrderType($query, $orderType)
    {
        return $query->where('order_type', $orderType);
    }

    /**
     * Scope a query to only include orders of a particular order channel type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $orderChannelType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByOrderChannelType($query, $orderChannelType)
    {
        return $query->where('order_channel_type', $orderChannelType);
    }

    /**
     * Scope a query to only include orders of a particular payment method.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $paymentMethod
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPaymentMethod($query, $paymentMethod)
    {
        return $query->where('payment_method', $paymentMethod);
    }

    /**
     * Scope a query to only include orders that are cancelled.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCancelled($query)
    {
        return $query->where('is_cancelled', true);
    }

    /**
     * Scope a query to only include orders that are not cancelled.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotCancelled($query)
    {
        return $query->where('is_cancelled', false);
    }

    /**
     * Check if the order is cancelled.
     *
     * @return bool
     */
    public function isOrderCancelled()
    {
        return $this->is_cancelled;
    }

    /**
     * Check if the order is not cancelled.
     *
     * @return bool
     */
    public function isOrderNotCancelled()
    {
        return !$this->is_cancelled;
    }

    /**
     * Cancel the order.
     *
     * @return void
     */
    public function cancel()
    {
        $this->is_cancelled = true;
        $this->cancelled_at = now();
        $this->save();
    }

    /**
     * Uncancel the order.
     *
     * @return void
     */
    public function uncancel()
    {
        $this->is_cancelled = false;
        $this->cancelled_at = null;
        $this->save();
    }
    /**
     * Check if the order is draft.
     *
     * @return bool
     */
    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    /**
     * Check if the order is pending.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if the order is in progress.
     *
     * @return bool
     */
    public function isInProgress(): bool
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    /**
     * Check if the order is dispatched.
     *
     * @return bool
     */
    public function isDispatched(): bool
    {
        return $this->status === self::STATUS_DISPATCHED;
    }

    /**
     * Check if the order is in transit.
     *
     * @return bool
     */
    public function isInTransit(): bool
    {
        return $this->status === self::STATUS_IN_TRANSIT;
    }

    /**
     * Check if the order is delivered.
     *
     * @return bool
     */
    public function isDelivered(): bool
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    /**
     * Check if the order is cancelled.
     *
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Check if the order is RTO.
     *
     * @return bool
     */
    public function isRTO(): bool
    {
        return $this->status === self::STATUS_RTO;
    }

    /**
     * Check if the order is pending.
     *
     * @return bool
     */
    public function isPendingPayment(): bool
    {
        return $this->payment_status === self::PAYMENT_STATUS_PENDING;
    }

    /**
     * Check if the order is paid.
     *
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_STATUS_PAID;
    }

    /**
     * Check if the order is failed.
     *
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->payment_status === self::PAYMENT_STATUS_FAILED;
    }

    /**
     * Check if the order is in INR.
     *
     * @return bool
     */
    public function isInr(): bool
    {
        return $this->payment_currency === self::PAYMENT_CURRENCY_INR;
    }

    /**
     * Check if the order is in USD.
     *
     * @return bool
     */
    public function isUsd(): bool
    {
        return $this->payment_currency === self::PAYMENT_CURRENCY_USD;
    }

    /**
     * Check if the order is in EUR.
     *
     * @return bool
     */
    public function isEur(): bool
    {
        return $this->payment_currency === self::PAYMENT_CURRENCY_EUR;
    }

    /**
     * Check if the order is dropship.
     *
     * @return bool
     */
    public function isDropship(): bool
    {
        return $this->order_type === self::ORDER_TYPE_DROPSHIP;
    }

    /**
     * Check if the order is bulk.
     *
     * @return bool
     */
    public function isBulk(): bool
    {
        return $this->order_type === self::ORDER_TYPE_BULK;
    }

    /**
     * Check if the order is resell.
     *
     * @return bool
     */
    public function isResell(): bool
    {
        return $this->order_type === self::ORDER_TYPE_RESELL;
    }

    /**
     * Check if the order is manual.
     *
     * @return bool
     */
    public function isManual(): bool
    {
        return $this->order_channel_type === self::ORDER_CHANNEL_TYPE_MANUAL;
    }

    /**
     * Check if the order is store.
     *
     * @return bool
     */
    public function isStore(): bool
    {
        return $this->order_channel_type === self::ORDER_CHANNEL_TYPE_STORE;
    }

    /**
     * Check if the order is COD.
     *
     * @return bool
     */
    public function isCOD(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_COD;
    }

    /**
     * Check if the order is online.
     *
     * @return bool
     */
    public function isOnline(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_ONLINE;
    }

    /**
     * Check if the order has shipping address.
     *
     * @return bool
     */
    public function hasShippingAddress(): bool
    {
        return $this->shipping_address_id !== null;
    }

    /**
     * Check if the order has billing address.
     *
     * @return bool
     */
    public function hasBillingAddress(): bool
    {
        return $this->billing_address_id !== null;
    }

    /**
     * Check if the order has pickup address.
     *
     * @return bool
     */
    public function hasPickupAddress(): bool
    {
        return $this->pickup_address_id !== null;
    }

    /**
     * Get the order status.
     *
     * @return string
     */
    public function getStatus(): string
    {
        switch ($this->status) {
            case self::STATUS_DRAFT:
                return 'Draft';
            case self::STATUS_PENDING:
                return 'Pending';
            case self::STATUS_IN_PROGRESS:
                return 'In Progress';
            case self::STATUS_DISPATCHED:
                return 'Dispatched';
            case self::STATUS_IN_TRANSIT:
                return 'In Transit';
            case self::STATUS_DELIVERED:
                return 'Delivered';
            case self::STATUS_CANCELLED:
                return 'Cancelled';
            case self::STATUS_RTO:
                return 'RTO';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get the payment status.
     *
     * @return string
     */
    public function getPaymentStatus(): string
    {
        switch ($this->payment_status) {
            case self::PAYMENT_STATUS_PENDING:
                return 'Pending';
            case self::PAYMENT_STATUS_PAID:
                return 'Paid';
            case self::PAYMENT_STATUS_FAILED:
                return 'Failed';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get the payment currency.
     *
     * @return string
     */
    public function getPaymentCurrency(): string
    {
        switch ($this->payment_currency) {
            case self::PAYMENT_CURRENCY_INR:
                return 'INR';
            case self::PAYMENT_CURRENCY_USD:
                return 'USD';
            case self::PAYMENT_CURRENCY_EUR:
                return 'EUR';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get the order type.
     *
     * @return string
     */
    public function getOrderType(): string
    {
        switch ($this->order_type) {
            case self::ORDER_TYPE_DROPSHIP:
                return 'Dropship';
            case self::ORDER_TYPE_BULK:
                return 'Bulk';
            case self::ORDER_TYPE_RESELL:
                return 'Resell';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get the order channel type.
     *
     * @return string
     */
    public function getOrderChannelType(): string
    {
        switch ($this->order_channel_type) {
            case self::ORDER_CHANNEL_TYPE_MANUAL:
                return 'Manual Order';
            case self::ORDER_CHANNEL_TYPE_STORE:
                return 'Store Order';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get the payment method.
     *
     * @return string
     */
    public function getPaymentMethod(): string
    {
        switch ($this->payment_method) {
            case self::PAYMENT_METHOD_COD:
                return 'COD';
            case self::PAYMENT_METHOD_ONLINE:
                return 'Online Payment';
            default:
                return 'Unknown';
        }
    }
    
}

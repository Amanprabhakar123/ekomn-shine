<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderInvoice extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'supplier_id',
        'invoice_number',
        'invoice_date',
        'total_amount',
        'status',
        'uploaded_invoice_path',
        'refund_amount',
        'refund_status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'invoice_date' => 'datetime',
        'total_amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    const STATUS_PAID = 1;
    const STATUS_CANCELLED= 2;
    const STATUS_REFUNDED = 3;


    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    const REFUND_STATUS_NA = 0;
    const REFUND_STATUS_INITIATED = 1;
    const REFUND_STATUS_PROCESSING = 2;
    const REFUND_STATUS_COMPLETED = 3;
    const REFUND_STATUS_FAILED = 4;


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
            'buyer_id',
            'supplier_id',
            'invoice_number',
            'invoice_date',
            'total_amount',
            'status',
            'uploaded_invoice_path',
            'refund_amount',
            'refund_status'
        ])
        ->logOnlyDirty()
        ->useLogName('Order Invoice Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} order invoice with ID: {$this->id}");
    }

    /**
     * Get the order that owns the order invoice.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Get the supplier that owns the order invoice.
     */
    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id', 'id');
    }

    /**
     * Get the buyer that owns the order invoice.
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    /**
     * Get the refund status attribute.
     *
     * @return string|null
     */
    public function getRefundStatus(): ?string
    {
        switch ($this->refund_status) {
            case self::REFUND_STATUS_NA:
                return 'N/A';
            case self::REFUND_STATUS_INITIATED:
                return 'Initiated';
            case self::REFUND_STATUS_PROCESSING:
                return 'Processing';
            case self::REFUND_STATUS_COMPLETED:
                return 'Completed';
            case self::REFUND_STATUS_FAILED:
                return 'Failed';
            default:
                return null;
        }
    }

    /**
     * Get the status attribute.
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        switch ($this->status) {
            case self::STATUS_PAID:
                return 'Paid';
            case self::STATUS_CANCELLED:
                return 'Cancelled';
            case self::STATUS_REFUNDED:
                return 'Refunded';
            default:
                return null;
        }
    }

    /**
     * Get the total amount attribute.
     *
     * @return string|null
     */
    public function getTotalAmount(): ?string
    {
        return '₹ ' . number_format($this->total_amount, 2);
    }

    /**
     * Get the refund amount attribute.
     *
     * @return string|null
     */
    public function getRefundAmount(): ?string
    {
        return '₹ ' . number_format($this->refund_amount, 2);
    }

    /**
     * Check if the order invoice is refunded.
     *
     * @return bool
     */
    public function isRefunded(): bool
    {
        return $this->status === self::STATUS_REFUNDED;
    }

    /**
     * Check if the order invoice is cancelled.
     *
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Check if the order invoice is paid.
     *
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }


    /**
     * Check if the order invoice is NA refund status.
     *
     * @return bool
     */
    public function isNARefundStatus(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_NA;
    }
    
    /**
     * Check if the order invoice is due for refund.
     *
     * @return bool
     */
    public function isDueForRefund(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_INITIATED;
    }

    /**
     * Check if the order invoice is due for refund.
     *
     * @return bool
     */
    public function isRefundProcessing(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_PROCESSING;
    }

    /**
     * Check if the order invoice is due for refund.
     *
     * @return bool
     */
    public function isRefundCompleted(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_COMPLETED;
    }

    /**
     * Check if the order invoice is due for refund.
     *
     * @return bool
     */
    public function isRefundFailed(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_FAILED;
    }

    /**
     * Generate a unique invoice number.
     *
     * @return string
     */
    public function generateInvoiceNumber(): string
    {
        $invoiceNumber = 'INV-' . strtoupper(substr(md5(uniqid()), 0, 10));
        
        // Check if the generated invoice number already exists in the OrderInvoice table
        while (self::where('invoice_number', $invoiceNumber)->exists()) {
            $invoiceNumber = 'INV-' . strtoupper(substr(md5(uniqid()), 0, 10));
        }
        
        return $invoiceNumber;
    }

}

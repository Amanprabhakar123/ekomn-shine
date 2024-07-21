<?php

namespace App\Models;

use App\Models\SupplierPayment;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierPaymentInvoice extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supplier_payments_id',
        'invoice_number',
        'invoice_date',
        'total_amount',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'invoice_date' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Get the supplier payment that owns the invoice.
     */
    const STATUS_PAID = 1;
    const STATUS_CANCELLED = 2;
    const STATUS_REFUNDED = 3;

    /**
     * Get the supplier payment that owns the invoice.
     */
    public function supplierPayment()
    {
        return $this->belongsTo(SupplierPayment::class, 'supplier_payments_id');
    }

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'supplier_payments_id',
            'invoice_number',
            'invoice_date',
            'total_amount',
            'status',
        ])
        ->logOnlyDirty()
        ->useLogName('Supplier Payment Invoice Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} supplier payment invoice with ID: {$this->id}");
    }
    

    /**
     * Get the status name based on the payment status int value.
     *
     * @param int $value
     * @return string
     */
    public function getStatus() : ?string
    {
        switch ($this->status) {
            case self::STATUS_PAID:
                return 'Paid';
                break;
            case self::STATUS_CANCELLED:
                return 'Cancelled';
                break;
            case self::STATUS_REFUNDED:
                return 'Refunded';
                break;
            default:
                return null;
        }
    }

    /**
     * Get the status name based on the payment status int value.
     *
     * @param int $value
     * @return string
     */
    public function getStatusColor() : ?string
    {
        switch ($this->status) {
            case self::STATUS_PAID:
                return 'success';
                break;
            case self::STATUS_CANCELLED:
                return 'danger';
                break;
            case self::STATUS_REFUNDED:
                return 'warning';
                break;
            default:
                return null;
        }
    }
    
}

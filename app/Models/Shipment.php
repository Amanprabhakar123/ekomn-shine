<?php

namespace App\Models;

use App\Models\Order;
use App\Models\ShipmentAwb;
use Spatie\Activitylog\LogOptions;
use App\Models\OrderItemAndCharges;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'order_item_charges_id',
        'shipment_date',
        'delivery_date',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    const STATUS_PENDING = 1;
    const STATUS_SHIPPED = 2;
    const STATUS_DELIVERED = 3;
    const STATUS_CANCELLED = 4;
    const STATUS_RETURNED = 5;
    const STATUS_REFUNDED = 6;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'shipment_date' => 'datetime',
        'delivery_date' => 'datetime',
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
            'order_item_charges_id',
            'shipment_date',
            'delivery_date',
            'status',
        ])
        ->logOnlyDirty()
        ->useLogName('Shipment Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} shipment with ID: {$this->id}");
    }


    /**
     * The attributes that should be logged using Spatie activity log package.
     *
     * @var array<int, string>
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * The attributes that should be logged using Spatie activity log package.
     *
     * @var array<int, string>
     */
    public function orderItemCharges()
    {
        return $this->belongsTo(OrderItemAndCharges::class, 'order_item_charges_id', 'id');
    }

    public function shipmentAwb()
    {
        return $this->hasMany(ShipmentAwb::class, 'shipment_id', 'id');
    }
    
    /**
     * Check if the shipment is pending.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if the shipment is shipped.
     *
     * @return bool
     */
    public function isShipped(): bool
    {
        return $this->status === self::STATUS_SHIPPED;
    }

    /**
     * Check if the shipment is delivered.
     *
     * @return bool
     */
    public function isDelivered(): bool
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    /**
     * Check if the shipment is cancelled.
     *
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }
    

    /**
     * Check if the shipment is returned.
     *
     * @return bool
     */
    public function isReturned(): bool
    {
        return $this->status === self::STATUS_RETURNED;
    }

    /**
     * Check if the shipment is refunded.
     *
     * @return bool
     */
    public function isRefunded(): bool
    {
        return $this->status === self::STATUS_REFUNDED;
    }
    

}

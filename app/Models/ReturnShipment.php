<?php

namespace App\Models;

use App\Models\Order;
use App\Models\ReturnOrder;
use App\Models\CourierDetails;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnShipment extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'return_id',
        'courier_id',
        'awb_number',
        'shipment_date',
        'courier_type',
        'provider_name',
        'expected_delivery_date',
        'status',
        'file_path'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'shipment_date' => 'datetime',
        'expected_delivery_date' => 'datetime',
    ];


     /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'order_id',
            'return_id',
            'courier_id',
            'awb_number',
            'shipment_date',
            'courier_type',
            'provider_name',
            'expected_delivery_date',
            'status',
            'file_path'
        ])
        ->logOnlyDirty()
        ->useLogName('Return Shipment Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} return shipment with ID: {$this->id}");
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    const STATUS_CREATED = ShipmentAwb::STATUS_CREATED;
    const STATUS_SHIPPED_DISPATCHE = ShipmentAwb::STATUS_SHIPPED_DISPATCHE;
    const STATUS_DELIVERED = ShipmentAwb::STATUS_DELIVERED;
    const STATUS_CANCELLED = ShipmentAwb::STATUS_CANCELLED;
    const STATUS_RETURNED = ShipmentAwb::STATUS_RETURNED;
    const STATUS_REFUNDED = ShipmentAwb::STATUS_REFUNDED;
    const STATUS_IN_TRANSIT = 7;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    const COURIER_TYPE_SURFACE = 1;
    const COURIER_TYPE_AIR = 2;

    /**
     * Get the return that owns the ReturnShipment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function return()
    {
        return $this->belongsTo(ReturnOrder::class, 'return_id', 'id');
    }

    /**
     * Get the order that owns the ReturnShipment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Get the courier that owns the ReturnShipment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courier()
    {
        return $this->belongsTo(CourierDetails::class, 'courier_id', 'id');
    }

    /**
     * Get the status for the ReturnShipment
     *
     * @return string
     */
    public function isCreated()
    {
        return $this->status === self::STATUS_CREATED;
    }

    /**
     * Get the status for the ReturnShipment
     *
     * @return string
     */
    public function isShipped()
    {
        return $this->status === self::STATUS_SHIPPED_DISPATCHE;
    }

    /**
     * Get the status for the ReturnShipment
     *
     * @return string
     */
    public function isDelivered()
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    /**
     * Get the status for the ReturnShipment
     *
     * @return string
     */
    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Get the status for the ReturnShipment
     *
     * @return string
     */
    public function isReturned()
    {
        return $this->status === self::STATUS_RETURNED;
    }

    /**
     * Get the status for the ReturnShipment
     *
     * @return string
     */
    public function isRefunded()
    {
        return $this->status === self::STATUS_REFUNDED;
    }

    /**
     * Get the status for the ReturnShipment
     *
     * @return string
     */
    public function isTransist()
    {
        return $this->status === self::STATUS_IN_TRANSIT;
    }

    /**
     * Get the courier type for the ReturnShipment
     *
     * @return string
     */
    public function isSurface()
    {
        return $this->courier_type === self::COURIER_TYPE_SURFACE;
    }

    /**
     * Get the courier type for the ReturnShipment
     *
     * @return string
     */
    public function isAir()
    {
        return $this->courier_type === self::COURIER_TYPE_AIR;
    }

    /**
     * Get the shipment status
     *
     * @return string
     */
    public function getShipmentStatus()
    {
        switch ($this->status) {
            case self::STATUS_CREATED:
                return 'Created';
            case self::STATUS_SHIPPED_DISPATCHE:
                return 'Dispatch';
            case self::STATUS_DELIVERED:
                return 'Delivered';
            case self::STATUS_CANCELLED:
                return 'Cancelled';
            case self::STATUS_RETURNED:
                return 'Returned';
            case self::STATUS_REFUNDED:
                return 'Refunded';
            case self::STATUS_IN_TRANSIT:
                return 'In Transit';
            default:
                return null;
        }
    }

    /**
     * Get the courier type
     *
     * @return string
     */
    public function getCourierType()
    {
        switch ($this->courier_type) {
            case self::COURIER_TYPE_SURFACE:
                return 'Surface';
            case self::COURIER_TYPE_AIR:
                return 'Air';
            default:
                return null;
        }
    }
    
}

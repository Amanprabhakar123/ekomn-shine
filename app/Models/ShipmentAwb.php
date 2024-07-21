<?php

namespace App\Models;

use App\Models\Shipment;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShipmentAwb extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'shipment_id',
        'awb_number',
        'awb_date',
        'courier_type',
        'courier_provider_name',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    const STATUS_CREATED = 1;
    const STATUS_SHIPPED = 2;
    const STATUS_DELIVERED = 3;
    const STATUS_CANCELLED = 4;
    const STATUS_RETURNED = 5;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    const COURIER_TYPE_SURFACE = 1;
    const COURIER_TYPE_AIR = 2;
    

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'awb_date' => 'datetime',
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
            'shipment_id',
            'awb_number',
            'awb_date',
            'courier_type',
            'courier_provider_name',
            'status',
        ])
        ->logOnlyDirty()
        ->useLogName('Shipment AWB Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} shipment awb with ID: {$this->id}");
    }

    /**
     * Get the shipment that owns the shipment awb.
     */
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id', 'id');
    }
    
    /**
     * Get the status name based on the status int value.
     *
     * @param int $value
     * @return string
     */
    public function getShipmentStatus() : ?string
    {
        switch ($this->status) {
            case self::STATUS_CREATED:
                return 'Created';
            case self::STATUS_SHIPPED:
                return 'Shipped';
            case self::STATUS_DELIVERED:
                return 'Delivered';
            case self::STATUS_CANCELLED:
                return 'Cancelled';
            case self::STATUS_RETURNED:
                return 'Returned';
            default:
                return null;
        }
    }

    /**
     * Get the courier type name based on the courier type int value.
     *
     * @param int $value
     * @return string
     */
    public function getCourierType() : ?string
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

    /**
     * Check if the shipment is created.
     *
     * @return bool
     */
    public function isCreated(): bool
    {
        return $this->status === self::STATUS_CREATED;
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
    
}

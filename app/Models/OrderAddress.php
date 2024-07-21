<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderAddress extends Model
{
    use HasFactory, SoftDeletes;

    /**
    * The constant value for billing address type.
    */
    const TYPE_BILLING_ADDRESS = 1;

    /**
     * The constant value for shipping address type.
     */
     const TYPE_SHIPPING_ADDRESS = 2;
 
    /**
     * The constant value for delivery address type.
     */
    const TYPE_DELIVERY_ADDRESS = 3;
    const TYPE_PICKUP_ADDRESS = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'buyer_id',
        'street',
        'city',
        'state',
        'postal_code',
        'country',
        'address_type'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
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
     * Scope a query to only include billing addresses.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBilling($query)
    {
        return $query->where('address_type', self::TYPE_BILLING_ADDRESS);
    }

    /**
     * Scope a query to only include shipping addresses.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShipping($query)
    {
        return $query->where('address_type', self::TYPE_SHIPPING_ADDRESS);
    }

    /**
     * Scope a query to only include delivery addresses.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDelivery($query)
    {
        return $query->where('address_type', self::TYPE_DELIVERY_ADDRESS);
    }

    /**
     * Scope a query to only include pickup addresses.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePickup($query)
    {
        return $query->where('address_type', self::TYPE_PICKUP_ADDRESS);
    }

    /**
     * Check if the address is billing address.
     *
     * @return bool
     */
    public function isBilling()
    {
        return $this->address_type === self::TYPE_BILLING_ADDRESS;
    }

    /**
     * Check if the address is shipping address.
     *
     * @return bool
     */
    public function isShipping()
    {
        return $this->address_type === self::TYPE_SHIPPING_ADDRESS;
    }

    /**
     * Check if the address is delivery address.
     *
     * @return bool
     */
    public function isDelivery()
    {
        return $this->address_type === self::TYPE_DELIVERY_ADDRESS;
    }

    /**
     * Check if the address is pickup address.
     *
     * @return bool
     */
    public function isPickup()
    {
        return $this->address_type === self::TYPE_PICKUP_ADDRESS;
    }

    /**
     * Check if the address is primary.
     *
     * @return bool
     */
    public function isPrimary()
    {
        return $this->is_primary;
    }


    /**
     * Get the full address.
     *
     * @return string
     */
    public function getFullAddress()
    {
        return $this->street . ', ' . $this->city . ', ' . $this->state . ', ' . $this->postal_code . ', ' . $this->country;
    }

    /**
     * Get the address type.
     *
     * @return string
     */
    public function getAddressType()
    {
        switch ($this->address_type) {
            case self::TYPE_BILLING_ADDRESS:
                return 'Billing Address';
            case self::TYPE_SHIPPING_ADDRESS:
                return 'Shipping Address';
            case self::TYPE_DELIVERY_ADDRESS:
                return 'Delivery Address';
            case self::TYPE_PICKUP_ADDRESS:
                return 'Pickup Address';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get the address type.
     *
     * @return string
     */
    public function getAddressTypeLabel()
    {
        switch ($this->address_type) {
            case self::TYPE_BILLING_ADDRESS:
                return 'primary';
            case self::TYPE_SHIPPING_ADDRESS:
                return 'secondary';
            case self::TYPE_DELIVERY_ADDRESS:
                return 'secondary';
            case self::TYPE_PICKUP_ADDRESS:
                return 'secondary';
            default:
                return 'Unknown';
        }
    }
}

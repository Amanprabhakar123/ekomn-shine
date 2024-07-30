<?php

namespace App\Models;

use App\Models\User;
use App\Models\ProductVariation;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AddToCart extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'product_id',
        'buyer_id',
        'quantity',
        'added_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'added_at' => 'datetime',
    ];

    const DEFAULT_QUANTITY = 1;

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'product_id',
                'buyer_id',
                'quantity',
                'added_at',
            ])
            ->logOnlyDirty()
            ->useLogName('Buyer Add to Cart Log')
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName} buyer add to cart with ID: {$this->id}");
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    public function product()
    {
        return $this->belongsTo(ProductVariation::class, 'product_id', 'id');
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    /**
     * Get the price of the product based on the quantity.
     *
     * @param string $ranges
     * @param int $quantity
     * @return float
     */
    public function getPriceBasedOnQuantity($ranges, $quantity)
    {
        $ranges = json_decode($ranges, true);
        foreach ($ranges as $range) {
            if ($quantity >= $range['range']['min'] && $quantity <= $range['range']['max']) {
                return (float) number_format(($range['price']), 2);
            }
        }
        // If the quantity is less than the minimum range, return the price of the minimum range
        return (float) number_format((end($ranges)['price']), 2);
    }

    /**
     * Get the prices of the product based on the quantity.
     *
     * @param string $ranges
     * @param int $quantity
     * @return array
     */
    public function getPricesBasedOnQuantity($ranges, $quantity)
    {
        try {
            $ranges = json_decode($ranges, true);
            foreach ($ranges as $range) {
                if ($quantity >= $range['range']['min'] && $quantity <= $range['range']['max']) {
                    return [
                        'local' => $range['local'],
                        'regional' => $range['regional'],
                        'national' => $range['national'],
                    ];
                }
            }

            // If the quantity exceeds all ranges, return the prices of the maximum range
            $lastRange = end($ranges);
            return [
                'local' => $lastRange['local'],
                'regional' => $lastRange['regional'],
                'national' => $lastRange['national'],
            ];
        } catch (\Exception $e) {
            throw  $e;
        }
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    public function scopeByBuyer($query, $buyerId)
    {
        return $query->where('buyer_id', $buyerId);
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    public function scopeByBuyerAndProduct($query, $buyerId, $productId)
    {
        return $query->where('buyer_id', $buyerId)->where('product_id', $productId);
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    public function scopeByBuyerAndProductAndQuantity($query, $buyerId, $productId, $quantity)
    {
        return $query->where('buyer_id', $buyerId)->where('product_id', $productId)->where('quantity', $quantity);
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    public function scopeByBuyerAndProductAndQuantityAndAddedAt($query, $buyerId, $productId, $quantity, $addedAt)
    {
        return $query->where('buyer_id', $buyerId)->where('product_id', $productId)->where('quantity', $quantity)->where('added_at', $addedAt);
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    public function scopeByBuyerAndProductAndAddedAt($query, $buyerId, $productId, $addedAt)
    {
        return $query->where('buyer_id', $buyerId)->where('product_id', $productId)->where('added_at', $addedAt);
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    public function scopeByBuyerAndQuantity($query, $buyerId, $quantity)
    {
        return $query->where('buyer_id', $buyerId)->where('quantity', $quantity);
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    public function scopeByBuyerAndQuantityAndAddedAt($query, $buyerId, $quantity, $addedAt)
    {
        return $query->where('buyer_id', $buyerId)->where('quantity', $quantity)->where('added_at', $addedAt);
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    public function scopeByBuyerAndAddedAt($query, $buyerId, $addedAt)
    {
        return $query->where('buyer_id', $buyerId)->where('added_at', $addedAt);
    }


    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    public function scopeByProductAndQuantity($query, $productId, $quantity)
    {
        return $query->where('product_id', $productId)->where('quantity', $quantity);
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    public function scopeByProductAndQuantityAndAddedAt($query, $productId, $quantity, $addedAt)
    {
        return $query->where('product_id', $productId)->where('quantity', $quantity)->where('added_at', $addedAt);
    }
}

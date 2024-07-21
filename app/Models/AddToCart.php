<?php

namespace App\Models;

use App\Models\User;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AddToCart extends Model
{
    use HasFactory;

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

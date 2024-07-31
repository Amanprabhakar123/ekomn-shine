<?php

namespace App\Models;

use Razorpay\Api\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeedBack extends Model
{
    use HasFactory;
    
    protected $fillable = ['order_id', 'rating', 'comment'];

    /**
     * Get the product that owns the feedback.
     */
    public function product()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    /**
     * Get the order that owns the feedback.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyShine extends Model
{
    use HasFactory;

    protected $table = 'shine_products';

    protected $fillable = [
        'user_id',
        'batch_id', 
        'request_no', 
        'name', 
        'platform', 
        'url', 
        'product_id', 
        'seller_name', 
        'search_term', 
        'amount', 
        'feedback_title', 
        'feedback_comment', 
        'review_rating', 
        'status'
    ];

    /**
     * Get the user that owns the product.
     */
    public function requestor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigner_id');
    }

    public function productReview()
    {
        return $this->hasOne(ProductReview::class, 'product_id', 'id');
    }
}
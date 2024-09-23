<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShineProduct extends Model
{
    use HasFactory;

    // Define status constants
    const STATUS_DRAFT = 0;
    const STATUS_PENDING = 1;
    const STATUS_INPROGRESS = 2;
    const STATUS_ORDER_PLACED = 3;
    const STATUS_ORDER_CONFIRM = 4;
    const STATUS_REVIEW_SUBMITTED = 5;
    const STATUS_COMPLETE = 6;
    const STATUS_CANCELLED = 7;

    protected $fillable = [
        'user_id',
        'assigner_id',
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
        'status',
        'created_at',
        'updated_at',
    ];

    public function review()
    {
        return $this->hasOne(ShineProductReview::class, 'shine_product_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShineProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'shine_product_id',
        'assigner_id',
        'order_number',
        'order_invoice',
        'requestor_comment',
        'requestor_confirmation',
        'screenshots',
        'requestor_confirmation_complition',
        'feedback_comment',
    ];

    public function shineProduct()
    {
        return $this->belongsTo(ShineProduct::class, 'shine_product_id');
    }
}
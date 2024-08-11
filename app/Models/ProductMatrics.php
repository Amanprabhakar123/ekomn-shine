<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMatrics extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'view_count',
        'search_count',
        'click_count',
        'purchase_count',
    ];


    // Define the relationship with the product
    public function product()
    {
        return $this->belongsTo(ProductVariation::class, 'product_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariationMedia extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'product_variation_id',
        'media_type',
        'file_path',
        'is_master',
        'desc',
        'is_active'
    ];

    public function product()
    {
        return $this->belongsTo(ProductInventory::class);
    }

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }
}

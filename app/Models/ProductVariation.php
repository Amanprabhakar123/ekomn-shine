<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'size',
        'color',
        'length',
        'width',
        'height',
        'dimension_class',
        'weight',
        'weight_class',
        'volumetric_weight',
        'package_length',
        'package_width',
        'package_height',
        'package_dimension_class',
        'package_weight',
        'package_weight_class',
        'price_before_tax',
        'price_after_tax',
        'status',
        'dropship_rate',
        'potential_mrp',
        'tier_rate',
        'tier_shipping_rate'
    ];

    protected $casts = [
        'tier_rate' => 'array',
        'tier_shipping_rate' => 'array',
    ];
    public function product()
    {
        return $this->belongsTo(ProductInventory::class);
    }
}

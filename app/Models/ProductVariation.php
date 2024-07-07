<?php

namespace App\Models;

use App\Models\CompanyDetail;
use App\Models\ProductInventory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariation extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_OUT_OF_STOCK = 3;
    const STATUS_DRAFT = 4;

    const TILL_STOCK_LAST = 1;
    const REGULAR_AVAILABLE = 2;

    protected $fillable = [
        'product_id',
        'company_id',
        'product_slug_id',
        'slug',
        'title',
        'description',
        'sku',
        'size',
        'color',
        'length',
        'width',
        'height',
        'dimension_class',
        'weight',
        'weight_class',
        'package_volumetric_weight',
        'package_length',
        'package_width',
        'package_height',
        'package_dimension_class',
        'package_weight',
        'package_weight_class',
        'price_before_tax',
        'price_after_tax',
        'stock',    
        'status',
        'availability_status',
        'dropship_rate',
        'potential_mrp',
        'tier_rate',
        'tier_shipping_rate'
    ];

    protected $casts = [
        'tier_rate' => 'array',
        'tier_shipping_rate' => 'array',
    ];
   
    /**
     * Get the product that owns the feature.
     */
    public function product()
    {
        return $this->belongsTo(ProductInventory::class, 'product_id', 'id');
    }

    /**
     * Get the company that owns the feature.
     */
    public function company()
    {
        return $this->belongsTo(CompanyDetail::class);
    }

    /**
     * Get the ProductVariation's Media.
     */
    public function media()
    {
        return $this->hasMany(ProductVariationMedia::class, 'product_variation_id', 'id');
        // ->where('media_type', ProductVariationMedia::MEDIA_TYPE_IMAGE)
        // ->where('is_master', ProductVariationMedia::IS_MASTER_TRUE)
        // ->where('is_active', ProductVariationMedia::IS_ACTIVE_TRUE)
        // ->orderBy('id', 'asc')
        // ->limit(1);
    }
}

<?php

namespace App\Models;

use App\Models\FeedBack;
use App\Models\CompanyDetail;
use App\Models\BuyerInventory;
use App\Models\ProductInventory;
use App\Models\ChannelProductMap;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Razorpay\Api\Product;

class ProductVariation extends Model
{
    use HasFactory, LogsActivity;

    // Status
    const STATUS_ACTIVE = ProductInventory::STATUS_ACTIVE;
    const STATUS_INACTIVE = ProductInventory::STATUS_INACTIVE;
    const STATUS_OUT_OF_STOCK = ProductInventory::STATUS_OUT_OF_STOCK;
    const STATUS_DRAFT = ProductInventory::STATUS_DRAFT;

    const STATUS_ARRAY = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_OUT_OF_STOCK => 'Out of Stock',
        self::STATUS_DRAFT => 'Draft',
    ];

    // Availability Status
    const TILL_STOCK_LAST = 1;
    const REGULAR_AVAILABLE = 2;
    
    // Allow Editable
    const ALLOW_EDITABLE_TRUE = 1;
    const ALLOW_EDITABLE_FALSE = 0;

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
        'tier_shipping_rate',
        'allow_editable'
    ];

    protected $casts = [
        'tier_rate' => 'array',
        'tier_shipping_rate' => 'array',
    ];

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
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
            'tier_shipping_rate',
            'allow_editable'
        ])
        ->logOnlyDirty()
        ->useLogName('Product Variation Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} product variation with ID: {$this->id}");
        // Chain fluent methods for configuration options
    }
   
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

    /**
     * Get the ProductVariation's Media.
     */
    public function buyerInventories()
    {
        return $this->hasMany(BuyerInventory::class, 'product_id', 'id');
    }

    /**
     * Get the ProductVariation's Media.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItemAndCharges::class, 'product_id', 'id');
    }

    /**
     * Get the ProductVariation's Sales channel maping.
     */
    public function salesChannelProductMaps()
    {
        return $this->hasMany(ChannelProductMap::class, 'product_variation_id', 'id');
    }

    /**
     * Get the top ProductVariation's .
     */
    public function topProducts()
    {
        return $this->hasMany(TopProduct::class);
    }

    /**
     * get the product variation color
     *
     * @param int $product_id
     * @return void
     */
    public static function colorVariation($product_id)
    {
        return self::select('color', 'id')->where('product_id', $product_id)->groupBy('color')->get()->toArray();
    }

    /**
     * get the product variation size
     *
     * @param int $product_id
     * @return void
     */
    public static function sizeVariation($product_id)
    {
        return self::select('size', 'id')->where('product_id', $product_id)->groupBy('size')->get()->toArray();
    }


    
}

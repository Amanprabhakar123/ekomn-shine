<?php

namespace App\Models;

use App\Models\ProductInventory;
use App\Models\ProductVariation;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariationMedia extends Model
{
    use HasFactory, LogsActivity;

    const MEDIA_TYPE_IMAGE = 1;
    const MEDIA_TYPE_VIDEO = 2;

    const IS_MASTER_TRUE = 1;
    const IS_MASTER_FALSE = 0;

    const IS_ACTIVE_TRUE = 1;
    const IS_ACTIVE_FALSE = 0;

    const IS_COMPRESSED_TRUE = 1;
    const IS_COMPRESSED_FALSE = 0;

    protected $fillable = [
        'product_id',
        'product_variation_id',
        'media_type',
        'file_path',
        'thumbnail_path',
        'is_master',
        'desc',
        'is_active',
        'is_compressed',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'product_id',
            'product_variation_id',
            'media_type',
            'file_path',
            'thumbnail_path',
            'is_master',
            'desc',
            'is_active',
            'is_compressed',
        ])
        ->logOnlyDirty()
        ->useLogName('Product Variation Media Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} product variation media with ID: {$this->id}");
    }


    /**
     * Get the product that owns the product variation media.
     */
    public function product()
    {
        return $this->belongsTo(ProductInventory::class);
    }

    /**
     * Get the product variation that owns the product variation media.
     */
    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }
}

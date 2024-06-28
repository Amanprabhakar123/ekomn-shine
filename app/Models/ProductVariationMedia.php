<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariationMedia extends Model
{
    use HasFactory;

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

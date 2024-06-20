<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariationMedia extends Model
{
    use HasFactory;

    const MEDIA_TYPE_IMAGE = 'image';
    const MEDIA_TYPE_VIDEO = 'video';

    const IS_MASTER_TRUE = true;
    const IS_MASTER_FALSE = false;

    protected $fillable = [
        'product_id',
        'product_variation_id',
        'media_type',
        'file_path',
        'is_master',
        'desc',
        'is_active'
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

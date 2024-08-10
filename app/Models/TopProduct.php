<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopProduct extends Model
{
    use HasFactory;

    const TYPE_PREMIUM_PRODUCT = 1;
    const TYPE_NEW_ARRIVAL = 2;
    const TYPE_IN_DEMAND = 3;
    const TYPE_REGULAR_AVAILABLE = 4;

    const TYPE_ARRAY = [
        self::TYPE_PREMIUM_PRODUCT => 'Premium',
        self::TYPE_NEW_ARRIVAL => 'New Arrival',
        self::TYPE_IN_DEMAND => 'In Demand',
        self::TYPE_REGULAR_AVAILABLE => 'Regular Available',
    ];

    const TYPE_ARRAY_FOR_SELECT = [
        self::TYPE_PREMIUM_PRODUCT,
        self::TYPE_NEW_ARRIVAL,
        self::TYPE_IN_DEMAND,
        self::TYPE_REGULAR_AVAILABLE,
    ];

    protected $fillable = ['product_id', 'top_category_id', 'type', 'priority'];

    /**
     * Get the category that owns the TopProduct
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topCategory()
    {
        return $this->belongsTo(TopCategory::class, 'category_id', 'id');
    }

    /**
     * Get the productVarition that owns the TopProduct
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    
    public function productVarition()
    {
        return $this->belongsTo(ProductVariation::class, 'product_id', 'id');
    }


    /**
     * Get the type of the TopProduct
     *
     * @return string
     */
    public function getType()
    {
        return self::TYPE_ARRAY[$this->type];
    }


}

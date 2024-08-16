<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductInventory extends Model
{
    use HasFactory, LogsActivity;

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 2;

    const STATUS_OUT_OF_STOCK = 3;

    const STATUS_DRAFT = 4;

    const TILL_STOCK_LAST = 1;

    const REGULAR_AVAILABLE = 2;

    protected $fillable = [
        'title', // Product title copy this product variation title
        'company_id',
        'user_id', // User ID of the user who created the product or supplier ID
        'description', // copy this information product variation description
        'model',
        'gst_percentage',
        'hsn',
        'upc',
        'isbn',
        'mpin',
        'availability_status', // copy this information product variation availability status
        'status', // Status of the product listed or not default 0 and 1 means listed
        'product_category',
        'product_subcategory',
    ];

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'title',
                'company_id',
                'user_id',
                'description',
                'model',
                'gst_percentage',
                'hsn',
                'upc',
                'isbn',
                'mpin',
                'availability_status',
                'status',
                'product_category',
                'product_subcategory',
            ])
            ->logOnlyDirty()
            ->useLogName('Product Inventory Log')
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName} product inventory log with ID: {$this->id}");
    }

    /**
     * Get the variations for the product.
     */
    public function variations()
    {
        return $this->hasMany(ProductVariation::class, 'product_id', 'id');
    }

    /**
     * Get the features for the product.
     */
    public function features()
    {
        return $this->hasMany(ProductFeature::class, 'product_id', 'id');
    }

    /**
     * Get the keywords for the product.
     */
    public function keywords()
    {
        return $this->hasMany(ProductKeyword::class, 'product_id', 'id');
    }

    /**
     * Get the company that owns the product.
     */
    public function company()
    {
        return $this->belongsTo(CompanyDetail::class);
    }

    /**
     * Get the user that owns the product.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category', 'id');
    }

    /**
     * Get the product category that owns the product.
     */
    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'product_subcategory', 'id');
    }

    /**
     * Get the product metrics for the product.
     */
    public function productMatrics()
    {
        return $this->hasMany(ProductMatrics::class, 'product_id', 'id');
    }
}

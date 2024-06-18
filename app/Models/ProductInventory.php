<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company_id',
        'user_id', // User ID of the user who created the product or supplier ID
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
        'product_subcategory'
    ];

    /**
     * Get the variations for the product.
     */
    public function variations()
    {
        return $this->hasMany(ProductVariation::class, 'product_inventory_id', 'id');
    }

    /**
     * Get the features for the product.
     */
    public function features()
    {
        return $this->hasMany(ProductFeature::class, 'product_inventory_id', 'id');
    }

    /**
     * Get the keywords for the product.
     */
    public function keywords()
    {
        return $this->hasMany(ProductKeyword::class, 'product_inventory_id', 'id');
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
}

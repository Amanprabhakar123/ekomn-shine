<?php

namespace App\Models;

use App\Models\CompanyDetail;
use App\Models\ProductInventory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductFeature extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'company_id',
        'feature_name',
        'value'
    ];

    /**
     * Get the product that owns the feature.
     */
    public function product()
    {
        return $this->belongsTo(ProductInventory::class);
    }

    /**
     * Get the company that owns the feature.
     */
    public function company()
    {
        return $this->belongsTo(CompanyDetail::class);
    }
}

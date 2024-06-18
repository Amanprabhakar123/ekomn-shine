<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFeature extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'company_id',
        'feature_name',
        'value'
    ];

    public function product()
    {
        return $this->belongsTo(ProductInventory::class);
    }

    public function company()
    {
        // return $this->belongsTo(Company::class);
    }
}

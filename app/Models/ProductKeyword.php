<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductKeyword extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'company_id',
        'keyword'
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

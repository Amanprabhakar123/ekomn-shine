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
        'supplier_id',
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'sku',
        'l',
        'b',
        'h',
        'Weight',
        'color',
        'size',
        'price',
        'total_price',
        'tags',
        'address_id',
        'cgst',
        'cgst_amount',
        'sgst',
        'sgst_percentage',
        'igst_percentage',
        'total_tax',
        'total_tax_percentage',
        'discount',

    ];
}

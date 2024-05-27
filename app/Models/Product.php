<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'Name',
        'desc',
        'Sku',
        'L',
        'B',
        'H',
        'Weight',
        'Color',
        'size',
        'Price',
        'Total_price',
        'Tags',
        'Address_id',
        'Cgst',
        'Cgst_amount',
        'Sgst',
        'Sgst_percentage',
        'Igst_percentage',
        'Total_tax',
        'Total_tax_percentage',
        'Discount',

    ];
}

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
        'features',
        'model',
        'sku',
        'hsn',
        'gst',
        'size',
        'color',
        'upc',
        'isbn',
        'mpin',
        'stock',
        'gst_price',
        'igst',
        'igst_amount',
        'cgst',
        'cgst_amount',
        'sgst',
        'sgst_amount',
        'price_before_tax',
        'price_after_tax',
        'tier_pricing',
        'length',
        'breadth',
        'height',
        'dimension_class',
        'weight',
        'weight_class',
        'availability_status',
        'status',
        'packaging_detail',
        'shipping_cost_detail',
    ];

    protected $casts = [
        'gst' => 'decimal:2',
        'gst_price' => 'decimal:2',
        'igst' => 'decimal:2',
        'igst_amount' => 'decimal:2',
        'cgst' => 'decimal:2',
        'cgst_amount' => 'decimal:2',
        'sgst' => 'decimal:2',
        'sgst_amount' => 'decimal:2',
        'price_before_tax' => 'decimal:2',
        'price_after_tax' => 'decimal:2',
        'tier_pricing' => 'array',
        'packaging_detail' => 'array',
        'shipping_cost_detail' => 'array',
        'length' => 'decimal:2',
        'breadth' => 'decimal:2',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
    ];
}

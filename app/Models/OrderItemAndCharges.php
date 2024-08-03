<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\ProductVariation;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItemAndCharges extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'supplier_id',
        'quantity',
        'per_item_price',
        'total_price_inc_gst',
        'total_price_exc_gst',
        'gst_percentage',
        'igst',
        'cgst',
        'shipping_gst_percent', // Shipping Charges GST
        'shipping_charges', // Shipping Charges INC GST
        'packing_charges', // Packaging Charges INC GST
        'packaging_gst_percent', // Packaging Charges GST
        'labour_charges', // Labour Charges INC GST
        'labour_gst_percent', // Labour Charges GST
        'processing_charges',  // Referal Charges INC GST
        'processing_gst_percent', // Referal Charges GST
        'payment_gateway_percentage', // Payment Gateway Charges
        'payment_gateway_charges', // Payment Gateway Charges INC GST
        'payment_gateway_gst_percent' // Payment Gateway Charges GST
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'per_item_price' => 'decimal:2',
        'total_price_inc_gst' => 'decimal:2',
        'total_price_exc_gst' => 'decimal:2',
        'gst_percentage' => 'decimal:2',
        'igst' => 'decimal:2',
        'cgst' => 'decimal:2',
        'shipping_gst_percent' => 'decimal:2',
        'shipping_charges' => 'decimal:2',
        'packing_charges' => 'decimal:2',
        'packaging_gst_percent' => 'decimal:2',
        'labour_charges' => 'decimal:2',
        'labour_gst_percent' => 'decimal:2',
        'processing_charges' => 'decimal:2',
        'processing_gst_percent' => 'decimal:2',
        'payment_gateway_percentage' => 'decimal:2',
        'payment_gateway_charges' => 'decimal:2',
        'payment_gateway_gst_percent' => 'decimal:2'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];

     /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'order_id',
            'product_id',
            'supplier_id',
            'quantity',
            'per_item_price',
            'total_price_inc_gst',
            'total_price_exc_gst',
            'gst_percentage',
            'igst',
            'cgst',
            'shipping_gst_percent',
            'shipping_charges',
            'packing_charges',
            'packaging_gst_percent',
            'labour_charges',
            'labour_gst_percent',
            'processing_charges',
            'processing_gst_percent',
            'payment_gateway_percentage',
            'payment_gateway_charges',
            'payment_gateway_gst_percent'
        ])
        ->logOnlyDirty()
        ->useLogName('Order Item And Charges Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} order item and charges with ID: {$this->id}");
    }

    /**
     * Get the order that owns the OrderItemAndCharges
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Get the product that owns the OrderItemAndCharges
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(ProductVariation::class, 'product_id', 'id');
    }

    /**
     * Get the supplier that owns the OrderItemAndCharges
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id', 'id');
    }

    /**
     * Get the shipment associated with the OrderItemAndCharges
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shipments()
    {
        return $this->hasOne(Shipment::class, 'order_item_charges_id', 'id');
    }
    

    /**
     * Get the order item and charges for the given order.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $orderId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }
    
    /**
     * Scope a query to only include order items.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderItems($query)
    {
        return $query->where('product_id', '!=', null);
    }

    /**
     * Scope a query to only include charges.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCharges($query)
    {
        return $query->where('product_id', null);
    }
}


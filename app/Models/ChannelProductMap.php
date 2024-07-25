<?php

namespace App\Models;

use App\Models\SalesChannel;
use App\Models\ProductVariation;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChannelProductMap extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sales_channel_id',
        'product_variation_id',
        'sales_channel_product_sku',
    ];

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'sales_channel_id',
            'product_variation_id',
            'sales_channel_product_sku',
        ])
        ->logOnlyDirty()
        ->useLogName('Channel Product Map Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} channel product map with ID: {$this->id}");
        
    }

    /**
     * Get the sales channel that owns the channel product map.
     */
    public function salesChannel()
    {
        return $this->belongsTo(SalesChannel::class, 'sales_channel_id', 'id');
    }

    /**
     * Get the product variation that owns the channel product map.
     */
    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id', 'id');
    }
}

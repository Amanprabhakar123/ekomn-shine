<?php

namespace App\Models;

use App\Models\CompanyDetail;
use App\Models\ProductInventory;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductKeyword extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
        'product_id',
        'company_id',
        'keyword'
    ];

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'product_id',
            'company_id',
            'keyword'
        ])
        ->logOnlyDirty()
        ->useLogName('Product Keyword Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} product keyword log with ID: {$this->id}");
    }

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

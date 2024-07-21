<?php

namespace App\Models;

use App\Models\CompanyDetail;
use App\Models\ProductInventory;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductFeature extends Model
{
    use HasFactory, LogsActivity;
    
    protected $fillable = [
        'product_id',
        'company_id',
        'feature_name',
        'value'
    ];

    /**
     * Get the options for logging changes to the model.
     */
    protected static $logAttributes = [
        'product_id',
        'company_id',
        'feature_name',
        'value'
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
                'feature_name',
                'value'
            ]) // Specify the attributes you want to log
            ->logOnlyDirty()
            ->useLogName('Product Feature Log')
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} product feature with ID: {$this->id}");
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

<?php

namespace App\Models;

use App\Models\CompanyDetail;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyProductCategory extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * @property int $company_id
     * @property int $product_category_id
     */
    protected $fillable = [
        'company_id',
        'product_category_id'
    ];

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'company_id',
            'product_category_id'
        ])
        ->logOnlyDirty()
        ->useLogName('Company Product Category Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} company product category with ID: {$this->id}");
    }
    /**
     * Get the company details associated with the product category.
     */
    public function companyDetails()
    {
        return $this->belongsTo(CompanyDetail::class, 'company_id', 'id');
    }
}

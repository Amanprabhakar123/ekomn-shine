<?php

namespace App\Models;

use App\Models\CompanyDetail;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyBusinessType extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'company_id',
        'business_type_id'
    ];

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'company_id',
            'business_type_id'
        ])
        ->useLogName('Company Business Type Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} company business type with ID: {$this->id}");
    }

    /**
     * Get the company details associated with the business type.
     */
    public function companyDetail()
    {
        return $this->belongsTo(CompanyDetail::class, 'company_id');
    }
}

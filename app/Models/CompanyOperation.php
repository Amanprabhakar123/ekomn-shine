<?php

namespace App\Models;

use App\Models\CompanyDetail;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyOperation extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
   
    /**
     * Constants for how the company heard about the operation.
     */
    const HEARD_ABOUT_SMS = 1; // Heard about through SMS
    const HEARD_ABOUT_EMAIL = 2; // Heard about through email
    const HEARD_ABOUT_GOOGLE_SEARCH = 3; // Heard about through Google search
    const HEARD_ABOUT_SOCIAL_MEDIA = 4; // Heard about through social media
    const HEARD_ABOUT_REFERRED = 5; // Heard about through referral
    const HEARD_ABOUT_OTHERS = 6; // Heard about through other means

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'bulk_dispatch_time',
        'bulk_dispatch_time_unit',
        'product_quality_confirm',
        'business_compliance_confirm',
        'product_qty',
        'heard_about',
    ];

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'company_id',
                'bulk_dispatch_time',
                'bulk_dispatch_time_unit',
                'product_quality_confirm',
                'business_compliance_confirm',
                'product_qty',
                'heard_about',
            ])
            ->logOnlyDirty()
            ->useLogName('Company Operation Log')
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} company operation with ID: {$this->id}");
    }

    /**
     * Get the company that owns the operation.
     */
    public function company()
    {
        return $this->belongsTo(CompanyDetail::class);
    }
}

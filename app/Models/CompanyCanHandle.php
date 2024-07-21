<?php

namespace App\Models;

use App\Models\CompanyDetail;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyCanHandle extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * @property int $can_handles_id
     * @property int $company_id
     */
    protected $fillable = [
        'can_handles_id',
        'company_id',
    ];

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'can_handles_id',
                'company_id',
            ])
            ->useLogName('Company Can Handle Log')
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} company can handle with ID: {$this->id}");
    }
    /**
     * Get the company details associated with the can handle.
     */
    public function companyDetail()
    {
        return $this->belongsTo(CompanyDetail::class, 'company_id');
    }
}

<?php

namespace App\Models;

use App\Models\CompanyDetail;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyPlanPermission extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'inventory_count',
        'download_count',
    ];

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'inventory_count',
                'download_count',
            ])
            ->logOnlyDirty()
            ->useLogName('Company Plan Subscripton Log')
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName} company plan subscription with ID: {$this->id}");

    }

    /**
     * Get the company that owns the plan permission.
     */
    public function company()
    {
        return $this->belongsTo(CompanyDetail::class);
    }
}

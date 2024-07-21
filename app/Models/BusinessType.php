<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessType extends Model
{
    use HasFactory, LogsActivity;

    const TYPE_SUPPLIER = 0; // Supplier
    const TYPE_BUYER = 1; // Buyer

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'is_active',
    ];

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'name',
            'is_active',
        ])
        ->logOnlyDirty()
        ->useLogName('Business Type Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} business type with ID: {$this->id}");
    }
}

<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pincode extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pincode',
        'district',
        'state',
        'latitude',
        'longitude',
    ];

    
     /**
     * Get the options for logging changes to the model.
     */
   public function getActivitylogOptions(): LogOptions
   {
       return LogOptions::defaults()
       ->logOnly([
            'pincode',
            'district',
            'state',
            'latitude',
            'longitude',
       ])
       ->logOnlyDirty()
       ->useLogName('Pincode Log')
       ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} pincode with ID: {$this->id}");
   }

}

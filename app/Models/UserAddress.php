<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAddress extends Model
{
    use HasFactory, LogsActivity;

    /**
     * @property int $user_id
     * @property string $address_line1
     * @property string $address_line2
     * @property string $city
     * @property string $address_type
     * @property string $postal_code
     * @property string $country
     * @property int $is_primary
     * @property string $telephone
     * @property int $status
     */
    protected $fillable = [
        'user_id',
        'address_line1',
        'address_line2',
        'city',
        'address_type',
        'postal_code',
        'country',
        'is_primary',
        'telephone',
        'status',
    ];

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'user_id',
            'address_line1',
            'address_line2',
            'city',
            'address_type',
            'postal_code',
            'country',
            'is_primary',
            'telephone',
            'status',
        ])
        ->logOnlyDirty()
        ->useLogName('User Address Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} user address with ID: {$this->id}");
    }
}

<?php

namespace App\Models;

use App\Models\CompanyDetail;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyAddressDetail extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
    * The constant value for billing address type.
    */
   const TYPE_BILLING_ADDRESS = 1;

   /**
    * The constant value for shipping address type.
    */
    const TYPE_SHIPPING_ADDRESS = 2;

   /**
    * The constant value for delivery address type.
    */
   const TYPE_DELIVERY_ADDRESS = 3;
   const TYPE_PICKUP_ADDRESS = 4;

   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'pincode',
        'country',
        'landmark',
        'address_type',
        'location_link',
        'is_location_verified',
        'is_primary'
    ];

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'company_id',
            'address_line1',
            'address_line2',
            'city',
            'state',
            'pincode',
            'country',
            'landmark',
            'address_type',
            'location_link',
            'is_location_verified',
            'is_primary'
        ])
        ->logOnlyDirty()
        ->useLogName('Company Address Details Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} company address details with ID: {$this->id}");
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_location_verified' => 'boolean',
        'is_primary' => 'boolean'
    ];

    /**
     * Get the company that owns the address.
     */
    public function company()
    {
        return $this->belongsTo(CompanyDetail::class);
    }
}

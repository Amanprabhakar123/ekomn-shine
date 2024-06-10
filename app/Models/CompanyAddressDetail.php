<?php

namespace App\Models;

use App\Models\CompanyDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyAddressDetail extends Model
{
    use HasFactory, SoftDeletes;

    /**
    * The constant value for billing address type.
    */
   const TYPE_BILLING_ADDRESS = 1;

   /**
    * The constant value for shipping address type.
    */
    //const TYPE_SHIPPING_ADDRESS = 2;

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

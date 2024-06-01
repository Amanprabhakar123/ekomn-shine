<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAddressDetail extends Model
{
    use HasFactory;

    /**
     * @property string $street_address
     * @property string $state
     * @property string $nearby_landmark
     * @property string $location_link
     * @property string $type
     * @property string $pincode
     * @property bool $is_location_verified
     */

     protected $fillable = [
        'street_address',
        'state',
        'nearby_landmark',
        'location_link',
        'type',
        'pincode',
        'is_location_verified'
    ];
}

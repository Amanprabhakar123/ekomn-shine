<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerRegistrationTemp extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'first_name',
        'last_name',
        'mobile',
        'designation',
        'address',
        'state',
        'city',
        'pin_code',
        'business_name',
        'gst',
        'pan',
        'email',
        'password',
        'product_channel'
    ];
}

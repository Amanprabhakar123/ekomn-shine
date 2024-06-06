<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierRegistrationTemp extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'business_name',
        'gst',
        'website_url',
        'first_name',
        'last_name',
        'mobile',
        'designation',
        'address',
        'state',
        'city',
        'pin_code',
        'bulk_dispatch_time',
        'dropship_dispatch_time',
        'product_quality_confirm',
        'business_compliance_confirm',
        'product_qty',
        'product_category',
        'product_channel',
        'email',
        'password'
    ];
}

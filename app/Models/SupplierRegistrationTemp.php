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
        'stationery',
        'furniture',
        'food_and_bevrage',
        'electronics',
        'groceries',
        'baby_products',
        'gift_cards',
        'cleaining_supplies',
        'through_sms',
        'through_email',
        'google_search',
        'social_media',
        'referred',
        'others',
        'email',
        'password'
    ];
}

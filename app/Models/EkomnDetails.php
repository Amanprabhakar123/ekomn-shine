<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkomnDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'ekomn_name',
        'address',
        'pincode',
        'city',
        'state',
        'contact',
        'email',
        'gst',
    ];
}

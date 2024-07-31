<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierDetails extends Model
{
    use HasFactory;

    protected $fillable = ['courier_name', 'tracking_url'];
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_address extends Model
{
    use HasFactory;

    protected $fillable = [
        'User_id',
        'Address_line1',
        'Address_line2',
        'City',
        'Address_type',
        'Postal_code',
        'Country',
        'Is_primary',
        'Telephone',
        'Status',
    ];
}

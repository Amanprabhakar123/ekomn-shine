<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySalesChannel extends Model
{
    use HasFactory;

    /**
     * @property int $company_id
     * @property int $sales_channel_id
     */

     protected $fillable = [
        'company_id',
        'sales_channel_id',
    ];

}

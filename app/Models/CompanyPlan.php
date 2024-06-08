<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'plan_id',
        'subscription_start_date',
        'subscription_end_date',
        'status',
    ];

    protected $casts = [
        'subscription_start_date' => 'date',
        'subscription_end_date' => 'date',
        'status' => 'string',
    ];

   
}

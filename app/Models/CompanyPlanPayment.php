<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPlanPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'purchase_id',
        'plan_id',
        'currency',
        'user_email',
        'mobile_no',
        'amount',
        'payment_status',
        'json_response',
    ];

    protected $casts = [
        'json_response' => 'array',
    ];
}

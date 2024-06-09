<?php

namespace App\Models;

use App\Models\CompanyDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'plan_id',
        'subscription_start_date',
        'subscription_end_date',
    ];

    protected $casts = [
        'subscription_start_date' => 'date',
        'subscription_end_date' => 'date',
    ];

    /**
     * Get the company that owns the plan.
     */
    public function company()
    {
        return $this->belongsTo(CompanyDetail::class);
    }

   
}

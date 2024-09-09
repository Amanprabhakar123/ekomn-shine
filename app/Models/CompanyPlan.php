<?php

namespace App\Models;

use App\Models\CompanyDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyPlan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'company_plan_paymnet_id',
        'plan_id',
        'subscription_start_date',
        'subscription_end_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'subscription_start_date' => 'date',
        'subscription_end_date' => 'date',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * Get the company that owns the plan.
     */
    public function company()
    {
        return $this->belongsTo(CompanyDetail::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    /**
     * Get the plan type.
     *
     * @return string
     */
    public function isPlanActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    /**
     * Get the plan type.
     *
     * @return string
     */
    public function isPlanActiveInActive()
    {
        return $this->status == self::STATUS_INACTIVE;
    }

   
}

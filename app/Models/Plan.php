<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 0;

    protected $fillable = [
        'name',
        'is_trial_plan',
        'description',
        'price',
        'duration',
        'features',
        'status',
    ];

    /**
     * Get the plan type.
     *
     * @return string
     */
    public function getPlanType()
    {
        if ($this->is_trial_plan == 1) {
            return 'Trial';
        } else {
            return 'Paid';
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyCanHandle extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @property int $can_handles_id
     * @property int $company_id
     */
        protected $fillable = [
            'can_handles_id',
            'company_id',
        ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCanHandle extends Model
{
    use HasFactory;

    /**
     * @property int $can_handles_id
     * @property int $company_id
     */
        protected $fillable = [
            'can_handles_id',
            'company_id',
        ];
}

<?php

namespace App\Models;

use App\Models\CompanyDetail;
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
        
        /**
         * Get the company details associated with the can handle.
         */
        public function companyDetail()
        {
            return $this->belongsTo(CompanyDetail::class, 'company_id');
        }
    }

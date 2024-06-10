<?php

namespace App\Models;

use App\Models\CompanyDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyBusinessType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'business_type_id'
    ];

    /**
     * Get the company details associated with the business type.
     */
    public function companyDetail()
    {
        return $this->belongsTo(CompanyDetail::class, 'company_id');
    }
}

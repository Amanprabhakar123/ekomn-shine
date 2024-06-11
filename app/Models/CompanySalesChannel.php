<?php

namespace App\Models;

use App\Models\CompanyDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    /**
     * Get the company details associated with the product category.
     */
    public function companyDetails()
    {
        return $this->belongsTo(CompanyDetail::class, 'company_id', 'id');
    }
}

<?php

namespace App\Models;

use App\Models\CompanyDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Import extends Model
{
    use HasFactory;

    protected $table = 'import';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'filename',
        'file_type',
        'file_path',
        'company_id',
        'status',
        'success_count',
        'fail_count',
        'error_file',
    ];

    const STATUS_PENDING = BULK_UPLOAD_STATUS_PENDING;
    const STATUS_INPROGRESS = BULK_UPLOAD_STATUS_PROCESSING;
    const STATUS_SUCCESS = BULK_UPLOAD_STATUS_COMPLETED;
    const STATUS_FAILED = BULK_UPLOAD_STATUS_FAILED;
    const STATUS_QUEUED = BULK_UPLOAD_STATUS_QUEUED;
    const STATUS_VALIDATION = BULK_UPLOAD_STATUS_VALIDATION_ERROR;


    /**
     * Get the company details associated with the product category.
     */
    public function companyDetails()
    {
        return $this->belongsTo(CompanyDetail::class, 'company_id', 'id');
    }


        /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'success_count' => 'integer',
        'fail_count' => 'integer',
        'company_id' => 'integer',
    ];
}

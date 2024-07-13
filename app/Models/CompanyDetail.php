<?php

namespace App\Models;

use App\Models\Import;
use App\Models\CompanyPlan;
use App\Models\CompanyCanHandle;
use App\Models\CompanyOperation;
use App\Models\CompanyBusinessType;
use App\Models\CompanySalesChannel;
use App\Models\CompanyAddressDetail;
use App\Models\CompanyProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyDetail extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @property string $business_name
     * @property string $display_name
     * @property string $first_name
     * @property string $last_name
     * @property string $email
     * @property string $mobile_no
     * @property string $pan_no
     * @property string $gst_no
     * @property string $pan_no_file_path
     * @property string $gst_no_file_path
     * @property bool $pan_verified
     * @property bool $gst_verified
     * @property string $language_i_can_read
     * @property string $language_i_can_understand
     * @property string $alternate_business_contact
     * @property string $bank_name
     * @property string $bank_account_no
     * @property string $ifsc_code
     * @property string $swift_code
     * @property string $cancelled_cheque_file_path
     * @property string $signature_image_file_path
     * @property bool $bank_account_verified
     */
    protected $fillable = [
        'user_id', // 'user_id' is the id of the user table
        'company_serial_id', // 'company_serial_id' is the id of the company table
        'business_name',
        'display_name',
        'designation',
        'first_name',
        'last_name',
        'email',
        'mobile_no',
        'pan_no',
        'gst_no',
        'pan_no_file_path',
        'gst_no_file_path',
        'pan_verified',
        'gst_verified',
        'language_i_can_read',
        'language_i_can_understand',
        'alternate_business_contact',
        'bank_name',
        'bank_account_no',
        'ifsc_code',
        'swift_code',
        'cancelled_cheque_file_path',
        'signature_image_file_path',
        'bank_account_verified',
    ];
    /**
     * Get the addresses associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function address()
    {
        return $this->hasMany(CompanyAddressDetail::class, 'company_id', 'id');
    }

    /**
     * Get the operations associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operation()
    {
        return $this->hasMany(CompanyOperation::class, 'company_id', 'id');
    }

    /**
     * Get the subscriptions associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscription()
    {
        return $this->hasMany(CompanyPlan::class, 'company_id', 'id');
    }

    /**
     * Get the product categories associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productCategory()
    {
        return $this->hasMany(CompanyProductCategory::class, 'company_id', 'id');
    }

    /**
     * Get the business types associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function businessType()
    {
        return $this->hasMany(CompanyBusinessType::class, 'company_id', 'id');
    }

    /**
     * Get the company that owns the company detail.
     */
    public function canHandle()
    {
        return $this->hasMany(CompanyCanHandle::class, 'company_id', 'id');
    }

    /**
     * Get the sales channels associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function salesChannel()
    {
        return $this->hasMany(CompanySalesChannel::class, 'company_id', 'id');
    }

    /**
     * Get the user that owns the company detail.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the variations for the product.
     */
    public function variations()
    {
        return $this->hasMany(ProductVariation::class, 'company_id', 'id');
    }

    /**
     * Get the features for the product.
     */
    public function features()
    {
        return $this->hasMany(ProductFeature::class, 'company_id', 'id');
    }

    /**
     * Get the keywords for the product.
     */
    public function keywords()
    {
        return $this->hasMany(ProductKeyword::class, 'company_id', 'id');
    }

    /**
     * Get the products for the company.
     */
    public function products()
    {
        return $this->hasMany(ProductInventory::class, 'company_id', 'id');
    }

    /**
     * Get the company that owns the company detail.
     */
    public function import()
    {
        return $this->hasMany(Import::class, 'company_id', 'id');
    }
}

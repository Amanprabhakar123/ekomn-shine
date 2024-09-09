<?php

namespace App\Models;

use App\Models\User;
use App\Models\Import;
use App\Models\CompanyPlan;
use App\Models\BuyerInventory;
use App\Models\ProductFeature;
use App\Models\ProductKeyword;
use App\Models\CompanyCanHandle;
use App\Models\CompanyOperation;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use App\Models\UserLoginHistory;
use Spatie\Activitylog\LogOptions;
use App\Models\CompanyBusinessType;
use App\Models\CompanySalesChannel;
use App\Models\CompanyAddressDetail;
use App\Models\CompanyPlanPermission;
use App\Models\CompanyProductCategory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyDetail extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

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
        'razorpay_subscription_id',
        'razorpay_plan_id',
        'subscription_status',
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

    // Pan and GST verification status
    const PAN_VERIFIED = 1;
    const PAN_NOT_VERIFIED = 0;
    const GST_VERIFIED = 1;
    const GST_NOT_VERIFIED = 0;

    // Subscription status
    const SUBSCRIPTION_STATUS_IN_ACTIVE = 0;
    const SUBSCRIPTION_STATUS_ACTIVE = 1;
    const SUBSCRIPTION_STATUS_PENDING = 2;
    const SUBSCRIPTION_STATUS_CANCELLED = 3;
    const SUBSCRIPTION_STATUS_EXPIRED = 4;
    const SUBSCRIPTION_STATUS_CREATED = 5;
    const SUBSCRIPTION_STATUS_COMPLETED = 6; 
    const SUBSCRIPTION_STATUS_AUTH = 7;

    /**
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'user_id',
                'company_serial_id',
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
                'razorpay_subscription_id',
                'razorpay_plan_id',
                'subscription_status',
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
            ])
            ->logOnlyDirty()
            ->useLogName('Company Details Log')
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName} company details with ID: {$this->id}");

    }

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

    /**
     * Get the company that owns the company detail.
     */
    public function buyerInventory()
    {
        return $this->hasMany(BuyerInventory::class, 'company_id', 'id');
    }

    /**
     * Get the company that owns the company plan subscription detail.
     */
    public function planSubscription(){
        return $this->hasOne(CompanyPlanPermission::class, 'company_id', 'id');
    }


    /**
     * Get the full name of the user.
     */
    public function getFullName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * Get the login history associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loginHistory()
    {
        return $this->hasMany(UserLoginHistory::class, 'user_id', 'user_id')->latest();
    }

    /**
     * Get the subscription status.
     */
    public function subscriptionStatus()
    {
        switch ($this->subscription_status) {
            case self::SUBSCRIPTION_STATUS_IN_ACTIVE:
                return 'Paused';
            case self::SUBSCRIPTION_STATUS_ACTIVE:
                return 'Active';
            case self::SUBSCRIPTION_STATUS_PENDING:
                return 'Pending';
            case self::SUBSCRIPTION_STATUS_CANCELLED:
                return 'Cancelled';
            case self::SUBSCRIPTION_STATUS_EXPIRED:
                return 'Expired';
            case self::SUBSCRIPTION_STATUS_CREATED:
                return 'Created';
            case self::SUBSCRIPTION_STATUS_COMPLETED:
                return 'Completed';
            case self::SUBSCRIPTION_STATUS_AUTH:
                return 'Authorized';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get the pan verification status.
     */
    public function panVerificationStatus()
    {
        return $this->pan_verified ? 'Verified' : 'Not Verified';
    }

    /**
     * Get the gst verification status.
     */
    public function gstVerificationStatus()
    {
        return $this->gst_verified ? 'Verified' : 'Not Verified';
    }
    
    /**
     * Get the pan verification status.
     */
    public function isPanVerified()
    {
        return $this->pan_verified == self::PAN_VERIFIED;
    }

    /**
     * Get the GST verification status.
     */
    public function isGstVerified()
    {
        return $this->gst_verified == self::GST_VERIFIED;
    }

    /**
     * Get the pan verification status.
     */
    public function isPanNotVerified()
    {
        return $this->pan_verified == self::PAN_NOT_VERIFIED;
    }

    /**
     * Get the GST verification status.
     */
    public function isGstNotVerified()
    {
        return $this->gst_verified == self::GST_NOT_VERIFIED;
    }


    /**
     * Get the subscription status.
     */
    public function isSubscriptionInActive()
    {
        return $this->subscription_status == self::SUBSCRIPTION_STATUS_IN_ACTIVE;
    }

    /**
     * Get the subscription status.
     */
    public function isSubscriptionActive()
    {
        return $this->subscription_status == self::SUBSCRIPTION_STATUS_ACTIVE;
    }

    /**
     * Get the subscription status.
     */
    public function isSubscriptionPending()
    {
        return $this->subscription_status == self::SUBSCRIPTION_STATUS_PENDING;
    }

    /**
     * Get the subscription status.
     */
    public function isSubscriptionCancelled()
    {
        return $this->subscription_status == self::SUBSCRIPTION_STATUS_CANCELLED;
    }

    /**
     * Get the subscription status.
     */
    public function isSubscriptionExpired()
    {
        return $this->subscription_status == self::SUBSCRIPTION_STATUS_EXPIRED;
    }

    /**
     * Get the subscription status.
     */
    public function isSubscriptionCreated()
    {
        return $this->subscription_status == self::SUBSCRIPTION_STATUS_CREATED;
    }

    /**
     * Get the subscription status.
     */
    public function isSubscriptionCompleted()
    {
        return $this->subscription_status == self::SUBSCRIPTION_STATUS_COMPLETED;
    }

    /**
     * Get the subscription status.
     */
    public function isSubscriptionAuth()
    {
        return $this->subscription_status == self::SUBSCRIPTION_STATUS_AUTH;
    }

    /**
     * Get the companyPlan tabel data.
     */
    public function companyPlanPayment()
    {
        return $this->hasOne(CompanyPlanPayment::class, 'company_id', 'id');
    }
    
}

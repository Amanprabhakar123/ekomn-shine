<?php

namespace App\Models;

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
        'business_name',
        'display_name',
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
}

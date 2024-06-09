<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\CompanyDetail;
use App\Models\CompanyAddressDetail;
use App\Models\CompanyOperation;
use App\Models\CompanyProductCategory;
use Carbon\Carbon;

class SupplierRegistrationTemp extends Model
{
    use HasFactory, SoftDeletes;

      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'business_name',
        'gst',
        'website_url',
        'first_name',
        'last_name',
        'mobile',
        'designation',
        'address',
        'state',
        'city',
        'pin_code',
        'bulk_dispatch_time',
        'dropship_dispatch_time',
        'product_quality_confirm',
        'business_compliance_confirm',
        'product_qty',
        'product_category',
        'product_channel',
        'email',
        'password'
    ];

    public function makeNewSupplierRegisteration($data){
        $supplier_id=  $this->createNewSupplierAndAttachRole($data);
        $this->createSupplierCompany($supplier_id, $data);
    }

    private function createNewSupplierAndAttachRole($data){
        $supplier=  User::updateOrCreate(
            ['email' => $data['email']],
            [
            'name' => trim($data['first_name'].' '.$data['last_name']),
            'email' => $data['email'],
            'password' => $data['password'],
            'email_verified_at' => Carbon::now()
        ]);
        $supplier_id =  $supplier->id;
        $supplier->assignRole(User::ROLE_SUPPLIER);
        return $supplier_id;
    }
    private function createSupplierCompany($supplier_id, $data){
        $business_name = trim($data['business_name']);
      $company =  CompanyDetail::updateOrCreate(
        [            'email' => $data['email'],
    ],  
        [
            'user_id' => $supplier_id,
            'business_name' =>  $business_name,
            'display_name' => generateUniqueCompanyUsername($business_name),
            'first_name' => trim($data['first_name']),
            'last_name' => trim($data['last_name']),
            'email' => trim($data['email']),
            'mobile_no' => trim($data['mobile']),
            'gst_no' => $data['gst'],
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at']
        ]);

        
    CompanyAddressDetail::updateOrCreate(
        ['company_id' => $company->id,'address_type' => CompanyAddressDetail::TYPE_PICKUP_ADDRESS,'is_primary' => 1],
        [
        'company_id' => $company->id,
        'address_line1' => $data['address'],
        'city' => $data['city'],
        'state' => $data['state'],
        'pincode' => $data['pin_code'],
        'country' => 'India',
        'address_type' => CompanyAddressDetail::TYPE_PICKUP_ADDRESS,
        'is_primary' => 1
    ]);

    CompanyOperation::updateOrCreate(
        ['company_id' =>$company->id],
       [ 'company_id' =>$company->id,
        'bulk_dispatch_time' => $data['bulk_dispatch_time'],
        'dropship_dispatch_time' => $data['dropship_dispatch_time'],
        'product_quality_confirm' => $data['product_quality_confirm'],
        'business_compliance_confirm' => $data['business_compliance_confirm'],
        'product_qty' => $data['product_qty']]
    );
    $data['product_category'] = json_decode($data['product_category'], true) ?? [];

    if(count($data['product_category']) > 0){
    foreach ($data['product_category'] as $key => $value) {
        if($value == 0){
            continue;
        }
        CompanyProductCategory::updateOrCreate(
            [
                'product_category_id' => $key,
                'company_id' => $company->id
            ],
            [
            'product_category_id' => $key,
            'company_id' => $company->id
        ]);   
    }
}

    }

}

<?php

namespace App\Services;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CompanyDetail;
use App\Models\CompanyCanHandle;
use App\Models\CompanyBusinessType;
use App\Models\CompanySalesChannel;
use Illuminate\Support\Facades\Log;
use App\Models\CompanyAddressDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyProductCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;


class CompanyService
{
    /**
     * Update company details based on user role.
     *
     * @param Request $request
     * @return array
     * @throws ValidationException
     * @throws Exception
     */
    public function updateCompanyDetails(Request $request): array
    {
        $user = Auth::user();
        $companyId = $user->companyDetails->id;

        if ($user->hasRole(User::ROLE_SUPPLIER)) {
            return $this->updateSupplierCompanyProfile($request, $companyId);
        } elseif ($user->hasRole(User::ROLE_BUYER)) {
            return $this->updateBuyerCompanyProfile($request, $companyId);
        }

        throw new Exception('User does not have the required role.');
    }

    /**
     * Update supplier company profile.
     *
     * @param Request $request
     * @param int $companyId
     * @return array
     * @throws ValidationException
     */
    private function updateSupplierCompanyProfile(Request $request, int $companyId): array
    {
        $validator = Validator::make($request->all(), $this->getSupplierValidationRules($companyId));

        if ($validator->fails()) {
            $errors = $validator->errors();
            $field = $errors->keys()[0]; // Get the first field that failed validation
            $errorMessage = $errors->first($field);
            $message = ValidationException::withMessages([$field => "{$errorMessage} - {$field}"]);
            throw $message;
        }
        $validatedData = $validator->validated();
        $company = CompanyDetail::find($companyId);
        $paths = $this->storeFiles($request, $companyId, $company);

        $data = $this->extractAlternateBusinessContactData($validatedData);

        $companyDetails = $this->buildCompanyDetailsArray($validatedData, $companyId, $paths, $data);

        $company->update($companyDetails);

        $this->handleCompanyProductCatgoriesOnUpdate($companyId, $validatedData["product_categories"] ?? null);
        $this->handleCompanyBusinessTypeOnUpdate($companyId, $validatedData["business_type"] ?? null);
        $this->handleCompanyCanHandleOnUpdate($companyId, $validatedData["can_handle"] ?? null);
        $this->handleAddressOnUpdate($companyId, $validatedData['shipping_address'], CompanyAddressDetail::TYPE_PICKUP_ADDRESS);
        $this->handleAddressOnUpdate($companyId, $validatedData['billing_address'], CompanyAddressDetail::TYPE_BILLING_ADDRESS);

        return [
            'message' => 'Company details updated successfully',
            'data' => $companyDetails,
        ];
    }

    /**
     * Update buyer company profile.
     *
     * @param Request $request
     * @param int $companyId
     * @return array
     * @throws ValidationException
     */
    private function updateBuyerCompanyProfile(Request $request, int $companyId): array
    {
        $validator = Validator::make($request->all(), $this->getBuyerValidationRules($companyId));

        if ($validator->fails()) {
            $errors = $validator->errors();
            $field = $errors->keys()[0]; // Get the first field that failed validation
            $errorMessage = $errors->first($field);
            $message = ValidationException::withMessages([$field => "{$errorMessage} - {$field}"]);
            throw $message;
        }
        $validatedData = $validator->validated();

        $company = CompanyDetail::find($companyId);
        $paths = $this->storeFiles($request, $companyId, $company);

        $data = $this->extractAlternateBusinessContactData($validatedData, 'buyer');

        $companyDetails = $this->buildCompanyDetailsArray($validatedData, $companyId, $paths, $data);
        // dd($companyDetails);
        $company->update($companyDetails);

        $this->handleCompanyProductCatgoriesOnUpdate($companyId, $validatedData["product_categories"] ?? null);
        $this->handleCompanyBusinessTypeOnUpdate($companyId, $validatedData["business_type"] ?? null);
        $this->handleAddressOnUpdate($companyId, $validatedData['delivery_address'], CompanyAddressDetail::TYPE_DELIVERY_ADDRESS);
        $this->handleAddressOnUpdate($companyId, $validatedData['billing_address'], CompanyAddressDetail::TYPE_BILLING_ADDRESS);
        $this->handleCompanySalesChannelsOnUpdate($companyId, $validatedData["sales_channel"] ?? null);

        
        return [
            'message' => 'Company details updated successfully',
            'data' => $companyDetails,
        ];
    }

    /**
     * Get validation rules for supplier.
     *
     * @return array
     */
    private function getSupplierValidationRules($companyId): array
    {
        return [
            'business_name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_no' => 'required|string|max:15',
            'pan_no' => 'required|string|max:15',
            'gst_no' => [
                'required',
                'string',
                'max:15',
                'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
                Rule::unique('company_details')->ignore($companyId),
            ],
            'pan_verified' => 'boolean',
            'gst_verified' => 'boolean',
            'shipping_address.id' => 'integer|nullable',
            'shipping_address.address_line1' => 'required|string|max:255',
            'shipping_address.state' => 'required|string|max:255',
            'shipping_address.city' => 'required|string|max:255',
            'shipping_address.pincode' => 'required|string|max:10',
            'shipping_address.address_type' => 'required|string|max:50',
            'shipping_address.is_primary' => 'boolean',
            'shipping_address.location_link' => 'required|string|max:190',
            'billing_address.id' => 'integer|nullable',
            'billing_address.address_line1' => 'required|string|max:255',
            'billing_address.city' => 'required|string|max:255',
            'billing_address.state' => 'required|string|max:255',
            'billing_address.pincode' => 'required|string|max:10',
            'billing_address.address_type' => 'required|string|max:50',
            'billing_address.is_primary' => 'boolean',
            'billing_address.location_link' => 'required|string|max:190',
            'bank_name' => 'required|string|max:255',
            'bank_account_no' => 'required|string|max:20|confirmed',
            'ifsc_code' => 'required|string|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            'swift_code' => 'required|string|regex:/^[A-Z]{4}[A-Z]{2}[A-Z0-9]{2}([A-Z0-9]{3})?$/',
            'alternate_business_contact.BusinessPerformanceAndCriticalEvents.name' => 'nullable|string|max:255',
            'alternate_business_contact.BusinessPerformanceAndCriticalEvents.mobile_no' => 'nullable|string|max:15',
            'alternate_business_contact.OrderDeliveryEnquiry.name' => 'nullable|string|max:255',
            'alternate_business_contact.OrderDeliveryEnquiry.mobile_no' => 'nullable|string|max:15',
            'alternate_business_contact.ProductListings.name' => 'nullable|string|max:255',
            'alternate_business_contact.ProductListings.mobile_no' => 'nullable|string|max:15',
            'language_i_can_read' => 'nullable|string',
            'language_i_can_understand' => 'nullable|string',
            'pan_file' => 'required|file|mimes:jpeg,png,pdf,webp|max:2048',
            'gst_file' => 'required|file|mimes:jpeg,png,pdf,webp|max:2048',
            'cancelled_cheque_image' => 'required|file|mimes:jpeg,png,pdf,webp|max:2048',
            'signature_image' => 'required|file|mimes:jpeg,png,pdf,webp|max:2048',
            'product_categories' => 'nullable|string',
            'business_type' => 'nullable|string',
            'can_handle' => 'nullable|string'
        ];
    }

    /**
     * Get validation rules for buyer.
     *
     * @return array
     */
    private function getBuyerValidationRules($companyId): array
    {
        return [
            'business_name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_no' => 'required|string|max:15',
            'pan_no' => 'required|string|max:15',
            'gst_no' => [
                'nullable',
                'string',
                'max:15',
                'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
                Rule::unique('company_details')->ignore($companyId),
            ],
            'pan_verified' => 'boolean',
            'gst_verified' => 'boolean',
            'delivery_address.id' => 'nullable|integer',
            'delivery_address.address_line1' => 'required|string|max:255',
            'delivery_address.city' => 'required|string|max:255',
            'delivery_address.state' => 'required|string|max:255',
            'delivery_address.pincode' => 'required|string|max:10',
            'delivery_address.address_type' => 'required|string|max:50',
            'delivery_address.is_primary' => 'boolean',
            'delivery_address.landmark' => 'nullable|string|max:150',
            'delivery_address.location_link' => 'required|string|max:190',
            'billing_address.id' => 'nullable|integer',
            'billing_address.address_line1' => 'required|string|max:255',
            'billing_address.city' => 'required|string|max:255',
            'billing_address.state' => 'required|string|max:255',
            'billing_address.pincode' => 'required|string|max:10',
            'billing_address.address_type' => 'required|string|max:50',
            'billing_address.is_primary' => 'boolean',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:20|confirmed',
            'ifsc_code' => 'nullable|string|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            'swift_code' => 'nullable|string|regex:/^[A-Z]{4}[A-Z]{2}[A-Z0-9]{2}([A-Z0-9]{3})?$/',
            'alternate_business_contact.BusinessPerformanceAndCriticalEvents.name' => 'nullable|string|max:255',
            'alternate_business_contact.BusinessPerformanceAndCriticalEvents.mobile_no' => 'nullable|string|max:15',
            'alternate_business_contact.ProductSourcingAlert.name' => 'nullable|string|max:255',
            'alternate_business_contact.ProductSourcingAlert.mobile_no' => 'nullable|string|max:15',
            'alternate_business_contact.BulkOrderContact.name' => 'nullable|string|max:255',
            'alternate_business_contact.BulkOrderContact.mobile_no' => 'nullable|string|max:15',
            'language_i_can_read' => 'nullable|string',
            'language_i_can_understand' => 'nullable|string',
            'pan_file' => 'required|file|mimes:jpeg,png,pdf,webp|max:2048',
            'gst_file' => 'required|file|mimes:jpeg,png,pdf,webp|max:2048',
            'cancelled_cheque_image' => 'required|file|mimes:jpeg,png,pdf,webp|max:2048',
            'signature_image' => 'required|file|mimes:jpeg,png,pdf,webp|max:2048',
            'product_categories' => 'nullable|string',
            'business_type' => 'nullable|string',
            'sales_channel' => 'nullable|string'
        ];
    }

    /**
     * Store files and return their paths.
     *
     * @param Request $request
     * @param int $companyId
     * @return array
     */
    private function storeFiles(Request $request, int $companyId, $company): array
    {
        $paths = [];

        foreach (['pan_file', 'signature_image', 'gst_file', 'cancelled_cheque_image'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $filename = md5(Str::random(40)) . '.' . $request->file($fileField)->getClientOriginalExtension();        
                // Get the file contents
                $fileContents = $request->file($fileField)->get();
                // Define the path
                $path = "company_{$company->id}/documents/{$filename}";                
                // Store the file
                Storage::disk('public')->put($path, $fileContents);

            }
        }
        return $paths;
    }

    /**
     * Extract alternate business contact data from validated data.
     *
     * @param array $validatedData
     * @return array
     */
    private function extractAlternateBusinessContactData(array $validatedData, $type = 'supplier'): array
    {
        if($type == 'supplier'){
            return ['alternate_business_contact' => [
                'BusinessPerformanceAndCriticalEvents' => [
                    'name' => $validatedData['alternate_business_contact']['BusinessPerformanceAndCriticalEvents']['name'] ?? '',
                    'mobile_no' => $validatedData['alternate_business_contact']['BusinessPerformanceAndCriticalEvents']['mobile_no'] ?? '',
                ],
                'ProductListings' => [
                    'name' => $validatedData['alternate_business_contact']['ProductListings']['name'] ?? '',
                    'mobile_no' => $validatedData['alternate_business_contact']['ProductListings']['mobile_no'] ?? '',
                ],
                'OrderDeliveryEnquiry' => [
                    'name' => $validatedData['alternate_business_contact']['OrderDeliveryEnquiry']['name'] ?? '',
                    'mobile_no' => $validatedData['alternate_business_contact']['OrderDeliveryEnquiry']['mobile_no'] ?? '',
                ],
            ]];
        } else {
            return ['alternate_business_contact' => [
                'BusinessPerformanceAndCriticalEvents' => [
                    'name' => $validatedData['alternate_business_contact']['BusinessPerformanceAndCriticalEvents']['name'] ?? '',
                    'mobile_no' => $validatedData['alternate_business_contact']['BusinessPerformanceAndCriticalEvents']['mobile_no'] ?? '',
                ],
                'ProductSourcingAlert' => [
                    'name' => $validatedData['alternate_business_contact']['ProductSourcingAlert']['name'] ?? '',
                    'mobile_no' => $validatedData['alternate_business_contact']['ProductSourcingAlert']['mobile_no'] ?? '',
                ],
                'BulkOrderContact' => [
                    'name' => $validatedData['alternate_business_contact']['BulkOrderContact']['name'] ?? '',
                    'mobile_no' => $validatedData['alternate_business_contact']['BulkOrderContact']['mobile_no'] ?? '',
                ],
            ]];
        }

    }

    /**
     * Build company details array from validated data and paths.
     *
     * @param array $validatedData
     * @param int $companyId
     * @param array $paths
     * @param array $data
     * @return array
     */
    private function buildCompanyDetailsArray(array $validatedData, int $companyId, array $paths, array $data): array
    {
        return [
            'id' => $companyId,
            'business_name' => $validatedData['business_name'],
            'display_name' => generateUniqueCompanyUsername($validatedData['business_name']),
            'first_name' => $validatedData['first_name'],
            'last_name' => isset($validatedData['last_name']) ? $validatedData['last_name'] : null,
            'email' => $validatedData['email'],
            'mobile_no' => $validatedData['mobile_no'],
            'pan_no' => $validatedData['pan_no'] ?? null,
            'gst_no' => $validatedData['gst_no'] ?? null,
            'pan_verified' => isset($validatedData['pan_verified']) ? $validatedData['pan_verified'] : false,
            'gst_verified' => isset($validatedData['gst_verified']) ? $validatedData['gst_verified'] : false,
            'bank_name' => $validatedData['bank_name'] ?? null,
            'bank_account_no' => $validatedData['bank_account_no'] ?? null,
            'ifsc_code' => $validatedData['ifsc_code'] ?? null,
            'swift_code' => $validatedData['swift_code'] ?? null,
            'alternate_business_contact' => json_encode($data),
            'language_i_can_read' => $validatedData['language_i_can_read'] ?? null,
            'language_i_can_understand' => $validatedData['language_i_can_understand'] ?? null,
            'pan_no_file_path' => isset($paths['pan_file']) ? Storage::url($paths['pan_file']) : null,
            'gst_no_file_path' => isset($paths['gst_file']) ? Storage::url($paths['gst_file']) : null,
            'cancelled_cheque_file_path' => isset($paths['cancelled_cheque_image']) ? Storage::url($paths['cancelled_cheque_image']) : null,
            'signature_image_file_path' => isset($paths['signature_image']) ? Storage::url($paths['signature_image']) : null,
        ];
    }

    /**
     * Handle company product categories update.
     *
     * @param int $company_id
     * @param string|null $categories
     */
    private function handleCompanyProductCatgoriesOnUpdate(int $company_id, ?string $categories): void
    {
        try {
            if (empty($categories)) {
                CompanyProductCategory::where('company_id', $company_id)->forceDelete();
            } else {
                // Decode the JSON string into a PHP array
                $categoriesArray = json_decode($categories, true);
                CompanyProductCategory::where('company_id', $company_id)->whereNotIn('product_category_id', $categoriesArray)->forceDelete();
                foreach ($categoriesArray as $value) {
                    CompanyProductCategory::updateOrCreate(
                        ['company_id' => $company_id, 'product_category_id' => $value],
                        ['company_id' => $company_id, 'product_category_id' => $value]
                    );
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Log::error('Line: ' . $e->getLine());
        }
    }


    
    /**
     * Handle company sales channels update.
     *
     * @param int $company_id
     * @param string|null $sales_channels
     */
    private function handleCompanySalesChannelsOnUpdate(int $company_id, ?string $sales_channels): void
    {
        try {
            if (empty($sales_channels)) {
                CompanySalesChannel::where('company_id', $company_id)->forceDelete();
            } else {
                // Decode the JSON string into a PHP array
                $salesChannelArray = json_decode($sales_channels, true);
                CompanySalesChannel::where('company_id', $company_id)->whereNotIn('sales_channel_id', $salesChannelArray)->forceDelete();
                foreach ($salesChannelArray as $value) {
                    CompanySalesChannel::updateOrCreate(
                        ['company_id' => $company_id, 'sales_channel_id' => $value],
                        ['company_id' => $company_id, 'sales_channel_id' => $value]
                    );
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Log::error('Line: ' . $e->getLine());
        }
    }



    /**
     * Handle company business type update.
     *
     * @param int $company_id
     * @param string|null $business_type
     */
    private function handleCompanyBusinessTypeOnUpdate(int $company_id, ?string $business_type): void
    {
        if (empty($business_type)) {
            CompanyBusinessType::where('company_id', $company_id)->forceDelete();
        } else {
            $businessTypeArray = json_decode($business_type, true);
            CompanyBusinessType::where('company_id', $company_id)->whereNotIn('business_type_id', $businessTypeArray)->forceDelete();
            foreach ($businessTypeArray as $value) {
                CompanyBusinessType::updateOrCreate(
                    ['company_id' => $company_id, 'business_type_id' => $value],
                    ['company_id' => $company_id, 'business_type_id' => $value]
                );
            }
        }
    }

    /**
     * Handle company can handle update.
     *
     * @param int $company_id
     * @param string|null $can_handle
     */
    private function handleCompanyCanHandleOnUpdate(int $company_id, ?string $can_handle): void
    {
        if (empty($can_handle)) {
            CompanyCanHandle::where('company_id', $company_id)->forceDelete();
        } else {
            $canHandleArray = json_decode($can_handle, true);
            CompanyCanHandle::where('company_id', $company_id)->whereNotIn('can_handles_id', $canHandleArray)->forceDelete();
            foreach ($canHandleArray as $value) {
                CompanyCanHandle::updateOrCreate(
                    ['company_id' => $company_id, 'can_handles_id' => $value],
                    ['company_id' => $company_id, 'can_handles_id' => $value]
                );
            }
        }
    }

    /**
     * Handle address update.
     *
     * @param int $company_id
     * @param array $address
     * @param string $address_type
     */
    private function handleAddressOnUpdate(int $company_id, array $address, string $address_type): void
    {
        if (!empty($address['id'])) {
            CompanyAddressDetail::updateOrCreate(
                ['id' => $address['id']],
                $address
            );
        } else {
            CompanyAddressDetail::updateOrCreate(
                ['company_id' => $company_id, 'address_type' => $address_type],
                $address
            );
        }
    }
}

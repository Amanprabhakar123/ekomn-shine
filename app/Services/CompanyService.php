<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CompanyDetail;
use App\Models\CompanyCanHandle;
use App\Models\CompanyBusinessType;
use App\Models\CompanyAddressDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyProductCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Exception;

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
        $companyId = $user->company_id;
        
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
        $validatedData = $request->validate($this->getSupplierValidationRules());

        $paths = $this->storeFiles($request, $companyId);

        $data = $this->extractAlternateBusinessContactData($validatedData);

        $companyDetails = $this->buildCompanyDetailsArray($validatedData, $companyId, $paths, $data);

        $company = CompanyDetail::find($companyId);
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
        $validatedData = $request->validate($this->getBuyerValidationRules());

        $paths = $this->storeFiles($request, $companyId);

        $data = $this->extractAlternateBusinessContactData($validatedData);

        $companyDetails = $this->buildCompanyDetailsArray($validatedData, $companyId, $paths, $data);

        $company = CompanyDetail::find($companyId);
        $company->update($companyDetails);

        $this->handleCompanyProductCatgoriesOnUpdate($companyId, $validatedData["product_categories"] ?? null);
        $this->handleCompanyBusinessTypeOnUpdate($companyId, $validatedData["business_type"] ?? null);
        $this->handleAddressOnUpdate($companyId, $validatedData['delivery_address'], CompanyAddressDetail::TYPE_DELIVERY_ADDRESS);
        $this->handleAddressOnUpdate($companyId, $validatedData['billing_address'], CompanyAddressDetail::TYPE_BILLING_ADDRESS);

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
    private function getSupplierValidationRules(): array
    {
        return [
            'business_name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_no' => 'required|string|max:15',
            'pan_no' => 'required|string|max:15',
            'gst_no' => 'required|string|max:15',
            'pan_verified' => 'boolean',
            'gst_verified' => 'boolean',
            'shipping_address.company_id' => 'required|integer',
            'shipping_address.address_line1' => 'required|string|max:255',
            'shipping_address.city' => 'required|string|max:255',
            'shipping_address.state' => 'required|string|max:255',
            'shipping_address.pincode' => 'required|string|max:10',
            'shipping_address.address_type' => 'required|string|max:50',
            'shipping_address.is_primary' => 'boolean',
            'billing_address.company_id' => 'required|integer',
            'billing_address.address_line1' => 'required|string|max:255',
            'billing_address.city' => 'required|string|max:255',
            'billing_address.state' => 'required|string|max:255',
            'billing_address.pincode' => 'required|string|max:10',
            'billing_address.address_type' => 'required|string|max:50',
            'billing_address.is_primary' => 'boolean',
            'bank_name' => 'required|string|max:255',
            'bank_account_no' => 'required|string|max:20',
            'ifsc_code' => 'required|string|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            'swift_code' => 'required|string|regex:/^[A-Z]{4}[A-Z]{2}[A-Z0-9]{2}([A-Z0-9]{3})?$/',
            'business_performance_and_critical_events.name' => 'nullable|string|max:255',
            'business_performance_and_critical_events.mobile_no' => 'nullable|string|max:15',
            'product_listings.name' => 'nullable|string|max:255',
            'product_listings.mobile_no' => 'nullable|string|max:15',
            'order_delivery_enquiry.name' => 'nullable|string|max:255',
            'order_delivery_enquiry.mobile_no' => 'nullable|string|max:15',
            'language_i_can_read' => 'nullable|string',
            'language_i_can_understand' => 'nullable|string',
            'pan_file' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'gst_file' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'cancelled_cheque_image' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'signature_image' => 'required|file|mimes:jpeg,png,pdf|max:2048',
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
    private function getBuyerValidationRules(): array
    {
        return [
            'business_name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_no' => 'required|string|max:15',
            'pan_no' => 'required|string|max:15',
            'gst_no' => 'nullable|string|max:15',
            'pan_verified' => 'boolean',
            'gst_verified' => 'boolean',
            'delivery_address.company_id' => 'required|integer',
            'delivery_address.address_line1' => 'required|string|max:255',
            'delivery_address.city' => 'required|string|max:255',
            'delivery_address.state' => 'required|string|max:255',
            'delivery_address.pincode' => 'required|string|max:10',
            'delivery_address.address_type' => 'required|string|max:50',
            'delivery_address.is_primary' => 'boolean',
            'delivery_address.landmark' => 'required|string|max:150',
            'delivery_address.location_link' => 'required|string|max:190',
            'billing_address.company_id' => 'required|integer',
            'billing_address.address_line1' => 'required|string|max:255',
            'billing_address.city' => 'required|string|max:255',
            'billing_address.state' => 'required|string|max:255',
            'billing_address.pincode' => 'required|string|max:10',
            'billing_address.address_type' => 'required|string|max:50',
            'billing_address.is_primary' => 'boolean',
            'bank_name' => 'required|string|max:255',
            'bank_account_no' => 'required|string|max:20',
            'ifsc_code' => 'required|string|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            'swift_code' => 'required|string|regex:/^[A-Z]{4}[A-Z]{2}[A-Z0-9]{2}([A-Z0-9]{3})?$/',
            'business_performance_and_critical_events.name' => 'nullable|string|max:255',
            'business_performance_and_critical_events.mobile_no' => 'nullable|string|max:15',
            'product_listings.name' => 'nullable|string|max:255',
            'product_listings.mobile_no' => 'nullable|string|max:15',
            'order_delivery_enquiry.name' => 'nullable|string|max:255',
            'order_delivery_enquiry.mobile_no' => 'nullable|string|max:15',
            'language_i_can_read' => 'nullable|string',
            'language_i_can_understand' => 'nullable|string',
            'pan_file' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'gst_file' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'cancelled_cheque_image' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'signature_image' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'product_categories' => 'nullable|string',
            'business_type' => 'nullable|string'
        ];
    }

    /**
     * Store files and return their paths.
     *
     * @param Request $request
     * @param int $companyId
     * @return array
     */
    private function storeFiles(Request $request, int $companyId): array
    {
        $paths = [];

        foreach (['pan_file', 'signature_image', 'gst_file', 'cancelled_cheque_image'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $paths[$fileField] = $request->file($fileField)->storeAs(
                    "public/company_{$companyId}/documents",
                    md5(Str::random(40)) . '.' . $request->file($fileField)->getClientOriginalExtension()
                );
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
    private function extractAlternateBusinessContactData(array $validatedData): array
    {
        return [
            'business_performance_and_critical_events' => [
                'name' => $validatedData['business_performance_and_critical_events']['name'] ?? '',
                'mobile_no' => $validatedData['business_performance_and_critical_events']['mobile_no'] ?? '',
            ],
            'product_listings' => [
                'name' => $validatedData['product_listings']['name'] ?? '',
                'mobile_no' => $validatedData['product_listings']['mobile_no'] ?? '',
            ],
            'order_delivery_enquiry' => [
                'name' => $validatedData['order_delivery_enquiry']['name'] ?? '',
                'mobile_no' => $validatedData['order_delivery_enquiry']['mobile_no'] ?? '',
            ],
        ];
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
            'display_name' => $validatedData['display_name'],
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'mobile_no' => $validatedData['mobile_no'],
            'pan_no' => $validatedData['pan_no'] ?? null,
            'gst_no' => $validatedData['gst_no'] ?? null,
            'pan_verified' => $validatedData['pan_verified'],
            'gst_verified' => $validatedData['gst_verified'],
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
        if (empty($categories)) {
            CompanyProductCategory::where('company_id', $company_id)->forceDelete();
        } else {
            $categoriesArray = explode(",", $categories);
            CompanyProductCategory::where('company_id', $company_id)->whereNotIn('product_category_id', $categoriesArray)->forceDelete();
            foreach ($categoriesArray as $value) {
                CompanyProductCategory::updateOrCreate(
                    ['company_id' => $company_id, 'product_category_id' => $value],
                    ['company_id' => $company_id, 'product_category_id' => $value]
                );
            }
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
            $businessTypeArray = explode(",", $business_type);
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
            $canHandleArray = explode(",", $can_handle);
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

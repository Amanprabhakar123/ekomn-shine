<?php

namespace App\Http\Controllers\APIAuth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\SupplierRegistrationTemp;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ApiRegistraionController extends Controller
{
    /**
     * Handle the data setting process for supplier registration.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function setData(Request $request): JsonResponse
    {
        try {
            // printR($request->all());
            if ($request->step_1) {
                $this->validateStep1($request);

                $supplier = SupplierRegistrationTemp::updateOrCreate(
                    $this->getStep1Data($request)
                );

                return $this->successResponse($supplier->id);
            } elseif ($request->step_2) {
                $supplier = SupplierRegistrationTemp::find($request->input('hiddenField'));

                if ($supplier) {
                    $supplier->update($this->getStep2Data($request));
                    return $this->successResponse();
                }
            } elseif ($request->step_3) {
                $supplier = SupplierRegistrationTemp::find($request->input('hiddenField'));

                if ($supplier) {
                    $supplier->update($this->getStep3Data($request));
                    return $this->successResponse();
                }
            } elseif ($request->step_4) {
                $this->validateStep4($request);

                $supplier = SupplierRegistrationTemp::find($request->input('hiddenField'));

                if ($supplier) {
                    $supplier->update($this->getStep4Data($request));
                    return $this->successResponse();
                }
            }

            return $this->errorResponse(__('auth.invalidInputData'));
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Validate request data for step 1.
     *
     * @param Request $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */

    private function validateStep1(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'business_name' => 'required|string',
            'gst' => 'required|string|max:16',
            'website_url' => 'nullable|url|max:255',
            'first_name' => 'required|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'mobile' => 'required|string|max:10',
            'designation' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'state' => 'nullable|string|max:60',
            'city' => 'nullable|string|max:60',
            'pin_code' => 'nullable|integer|min:6',
        ]);

        // Customize the validation error messages
        $validator->setAttributeNames([
            'business_name' => 'Business Name',
            'gst' => 'GST',
            'website_url' => 'Website URL',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'mobile' => 'Mobile',
            'designation' => 'Designation',
            'address' => 'Address',
            'state' => 'State',
            'city' => 'City',
            'pin_code' => 'Pin Code',
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            // Get the validation errors and throw the exception with modified error message
            $errors = $validator->errors();
            $field = $errors->keys()[0]; // Get the first field that failed validation
            $errorMessage = $errors->first($field);
            $message = ValidationException::withMessages([$field => $errorMessage.'-'.$field]);
            throw $message;
        }
    }

    /**
     * Get data array for step 1.
     *
     * @param Request $request
     * @return array
     */
    private function getStep1Data(Request $request): array
    {
        return [
            'business_name' => $request->input('business_name'),
            'gst' => $request->input('gst'),
            'website_url' => $request->input('website_url'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'mobile' => $request->input('mobile'),
            'designation' => $request->input('designation'),
            'address' => $request->input('address'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pin_code' => $request->input('pin_code'),
        ];
    }

    /**
     * Get data array for step 2.
     *
     * @param Request $request
     * @return array
     */
    private function getStep2Data(Request $request): array
    {
        return [
            'bulk_dispatch_time' => $request->input('bulk_dispatch_time') ? 1 : 0,
            'dropship_dispatch_time' => $request->input('dropship_dispatch_time') ? 1 : 0,
            'product_quality_confirm' => $request->input('product_quality_confirm') ? 1 : 0,
            'business_compliance_confirm' => $request->input('business_compliance_confirm') ? 1 : 0,
        ];
    }

    /**
     * Get data array for step 3.
     *
     * @param Request $request
     * @return array
     */
    private function getStep3Data(Request $request): array
    {
        return [
            'stationery' => $request->input('category1') ? 1 : 0,
            'furniture' => $request->input('category2') ? 1 : 0,
            'food_and_bevrage' => $request->input('category3') ? 1 : 0,
            'electronics' => $request->input('category4') ? 1 : 0,
            'groceries' => $request->input('category5') ? 1 : 0,
            'baby_products' => $request->input('category6') ? 1 : 0,
            'gift_cards' => $request->input('category7') ? 1 : 0,
            'cleaining_supplies' => $request->input('category8') ? 1 : 0,
            'through_sms' => $request->input('channel1') ? 1 : 0,
            'through_email' => $request->input('channel2') ? 1 : 0,
            'google_search' => $request->input('channel3') ? 1 : 0,
            'social_media' => $request->input('channel4') ? 1 : 0,
            'referred' => $request->input('channel5') ? 1 : 0,
            'others' => $request->input('channel6') ? 1 : 0,
        ];
    }

    /**
     * Validate request data for step 4.
     *
     * @param Request $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateStep4(Request $request): void
    {
        Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@_.]).*$/|confirmed',
        ])->validate();
    }

    /**
     * Get data array for step 4.
     *
     * @param Request $request
     * @return array
     */
    private function getStep4Data(Request $request): array
    {
        return [
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ];
    }

    /**
     * Generate a success response.
     *
     * @param int|null $id
     * @return JsonResponse
     */
    private function successResponse(int $id = null): JsonResponse
    {
        $response = [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'message' => __('auth.registerSuccess'),
        ];

        if ($id) {
            $response['id'] = $id;
        }

        return response()->json(['data' => $response],  __('statusCode.statusCode200'));
    }

    /**
     * Generate an error response.
     *
     * @param string $message
     * @return JsonResponse
     */
    private function errorResponse(string $message, string $key = null): JsonResponse
    {
        $response = [
            'statusCode' => __('statusCode.statusCode400'),
            'status' => __('statusCode.status400'),
            'message' => $message
        ];
        if ($key) {
            $response['key'] = $key;
        }
        return response()->json(['data' => $response], __('statusCode.statusCode400'));
    }
}

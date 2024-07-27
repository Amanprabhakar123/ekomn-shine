<?php

namespace App\Http\Controllers\APIAuth;

use App\Events\ExceptionEvent;
use App\Http\Controllers\Controller;
use App\Models\SupplierRegistrationTemp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SupplierRegistraionController extends Controller
{
    /**
     * Handle the data setting process for supplier registration.
     */
    public function supplierPostData(Request $request): JsonResponse
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
                $this->validateStep2($request);
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
                    $supplier->refresh();
                    (new SupplierRegistrationTemp())->makeNewSupplierRegisteration($supplier->toArray());

                    return $this->successResponse();
                }
            }

            return $this->errorResponse(__('auth.invalidInputData'));
        } catch (\Exception $e) {

            // Log the exception details and trigger an ExceptionEvent
            $message = $e->getMessage(); // Get the error message
            $file = $e->getFile(); // Get the file
            $line = $e->getLine(); // Get the line number where the exception occurred
            event(new ExceptionEvent($message, $line, $file)); // Trigger an event with exception details

            return $this->errorResponse($e->getMessage());
        }
    }

    // private function

    /**
     * Validate request data for step 1.
     *
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

        try {
            $validator->validate();
        } catch (ValidationException $e) {

            // Log the exception details and trigger an ExceptionEvent
            $message = $e->getMessage(); // Get the error message
            $file = $e->getFile(); // Get the file
            $line = $e->getLine(); // Get the line number where the exception occurred
            event(new ExceptionEvent($message, $line, $file)); // Trigger an event with exception details

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
     * Validate request data for step 2.
     *
     * @return voidid
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateStep2(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'bulk_dispatch_time' => 'required|boolean',
            'dropship_dispatch_time' => 'required|boolean',
            'product_quality_confirm' => 'required|boolean',
            'business_compliance_confirm' => 'required|boolean',
        ]);
        try {
            $validator->validate();
        } catch (ValidationException $e) {

            // Log the exception details and trigger an ExceptionEvent
            $message = $e->getMessage(); // Get the error message
            $file = $e->getFile(); // Get the file
            $line = $e->getLine(); // Get the line number where the exception occurred
            event(new ExceptionEvent($message, $line, $file)); // Trigger an event with exception details

            $errors = $validator->errors();
            $field = $errors->keys()[0]; // Get the first field that failed validation
            $errorMessage = $errors->first($field);
            $message = ValidationException::withMessages([$field => $errorMessage.'-'.$field]);
            throw $message;
        }
    }

    /**
     * Get data array for step 2.
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
     */
    private function getStep3Data(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'product_qty' => 'required|integer',
            'product_category' => 'required|array',
            'product_channel' => 'string',
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            // Log the exception details and trigger an ExceptionEvent
            $message = $e->getMessage(); // Get the error message
            $file = $e->getFile(); // Get the file
            $line = $e->getLine(); // Get the line number where the exception occurred
            event(new ExceptionEvent($message, $line, $file)); // Trigger an event with exception details

            $errors = $validator->errors();
            $field = $errors->keys()[0]; // Get the first field that failed validation
            $errorMessage = $errors->first($field);
            $message = ValidationException::withMessages([$field => $errorMessage.'-'.$field]);
            throw $message;
        }

        return [
            'product_qty' => $request->input('product_qty'),
            'product_category' => $request->input('product_category'),
            'product_channel' => $request->input('product_channel'),
        ];
    }

    /**
     * Validate request data for step 4.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateStep4(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@_.]).*$/|confirmed',
            'product_channel' => 'string',
        ]);
        try {
            $validator->validate();
        } catch (ValidationException $e) {

            // Log the exception details and trigger an ExceptionEvent
            $message = $e->getMessage(); // Get the error message
            $file = $e->getFile(); // Get the file
            $line = $e->getLine(); // Get the line number where the exception occurred
            event(new ExceptionEvent($message, $line, $file)); // Trigger an event with exception details

            $errors = $validator->errors();
            $field = $errors->keys()[0]; // Get the first field that failed validation
            $errorMessage = $errors->first($field);
            $message = ValidationException::withMessages([$field => $errorMessage.'-'.$field]);
            throw $message;
        }
    }

    /**
     * Get data array for step 4.
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
     */
    private function successResponse(?int $id = null): JsonResponse
    {
        $response = [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'message' => __('auth.registerSuccess'),
        ];

        if ($id) {
            $response['id'] = $id;
        }

        return response()->json(['data' => $response], __('statusCode.statusCode200'));
    }

    /**
     * Generate an error response.
     */
    private function errorResponse(string $message): JsonResponse
    {
        $parts = explode('-', $message);
        $key = '';
        if (! empty($parts)) {
            $message = $parts[0];
            $key = $parts[1] ?? null;
        }
        $response = [
            'statusCode' => __('statusCode.statusCode422'),
            'status' => __('statusCode.status422'),
            'message' => $message,
        ];
        if ($key) {
            $response['key'] = $key;
        }

        return response()->json(['data' => $response], __('statusCode.statusCode200'));
    }
}

<?php

namespace App\Http\Controllers\APIAuth;

use Illuminate\Http\Request;
use App\Models\CompanyDetail;
use App\Events\ExceptionEvent;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\BuyerRegistrationTemp;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BuyerRegistrationController extends Controller
{
    /**
     * Handle the data setting process for supplier registration.
     */
    public function buyerPostData(Request $request): JsonResponse
    {
        try {
            // printR($request->all());
            if ($request->step_1) {
                $this->validateStep1($request);
                $is_buyer = false;

                if(!is_null($request->input('gst'))){
                    $gstNo =  CompanyDetail::where('gst_no', $request->input('gst'))->select('id', 'user_id', 'gst_no')->get();
                    if($gstNo->isNotEmpty()){
                        foreach($gstNo as $c){
                            $role = $c->user->getRoleNames()->first();  
                            if($role == ROLE_BUYER){
                                $is_buyer = true;
                            }
                        }
                    }
                    if($is_buyer){
                        $message = ValidationException::withMessages(['gst_no' => 'GST Number already exists'.'-'.'gst']);
                        throw $message;
                    }
                }
                if(!is_null($request->input('pan'))){
                $panNo =  CompanyDetail::where('pan_no', $request->input('pan'))->select('id', 'user_id', 'pan_no')->get();
                    if($panNo->isNotEmpty()){
                        foreach($panNo as $c){
                            $role = $c->user->getRoleNames()->first();  
                            if($role == ROLE_BUYER){
                                $is_buyer = true;
                            }
                        }
                        if($is_buyer){
                            $message = ValidationException::withMessages(['pan_no' => 'PAN Number already exists'.'-'.'pan']);
                            throw $message;
                        }
                    }
                }

                $buyer = BuyerRegistrationTemp::updateOrCreate(
                    $this->getStep1Data($request)
                );

                return $this->successResponse($buyer->id);
            } elseif ($request->step_2) {
                $this->validateStep2($request);
                $buyer = BuyerRegistrationTemp::find(salt_decrypt($request->input('hiddenField')));

                if ($buyer) {
                    $buyer->update($this->getStep2Data($request));

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
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateStep1(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'mobile' => 'required|string|max:10',
            'designation' => 'nullable|string|max:50',
            'address' => 'required|string',
            'business_name' => 'nullable|string',
            'state' => 'required|string|max:60',
            'city' => 'required|string|max:60',
            'pin_code' => 'required|integer|min:6',
            'gst' => 'nullable|string|max:16',
            'pan' => 'nullable|min:10|max:10',
        ]);
        try {
            $validator->after(function ($validator) use ($request) {
                $data = $request->all();
                if (empty($data['gst']) && empty($data['pan'])) {
                    $validator->errors()->add('gst', 'Please enter either a GST ID or PAN.');
                    $validator->errors()->add('pan', 'Please enter either a GST ID or PAN.');
                }
            });
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
     */
    private function getStep1Data(Request $request): array
    {
        return [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'mobile' => $request->input('mobile'),
            'designation' => $request->input('designation'),
            'address' => $request->input('address'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pin_code' => $request->input('pin_code'),
            'business_name' => $request->input('business_name'),
            'gst' => $request->input('gst'),
            'pan' => $request->input('pan'),
        ];
    }

    /**
     * Validate request data for step 2.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateStep2(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@_.]).*$/|confirmed',
            'product_channel' => 'string',
        ]);
        try {
            $validator->validate();
        } catch (ValidationException $e) {

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
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'product_channel' => $request->input('product_channel'),
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
            $response['id'] = salt_encrypt($id);
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

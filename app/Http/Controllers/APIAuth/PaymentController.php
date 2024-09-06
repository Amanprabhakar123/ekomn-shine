<?php

namespace App\Http\Controllers\APIAuth;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use Razorpay\Api\Api;
use App\Models\Receipt;
use App\Models\CompanyPlan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CompanyDetail;
use App\Events\ExceptionEvent;
use App\Models\CompanyPlanPayment;
use App\Notifications\VerifyEmail;
use App\Traits\ReceiptIdGenerator;
use App\Http\Controllers\Controller;
use App\Models\CompanyAddressDetail;
use App\Models\BuyerRegistrationTemp;

class PaymentController extends Controller
{
    use ReceiptIdGenerator;

    public function __construct()
    {
        //
    }

    /**
     * Create a payment request.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     *
     * @OA\Post(
     *     path="/api/create-payment",
     *     summary="Create a payment request",
     *     description="Create a payment request and return the order details.",
     *     tags={"Payment"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(ref="#/components/schemas/PaymentCreateRequest")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Payment request created",
     *
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Invalid request",
     *
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function createPayment(Request $request)
    {
        $plan = $request->input('plan');
        $plan_details = Plan::where('id', salt_decrypt($plan))->where('status', Plan::STATUS_ACTIVE)->first();
        if (! empty($plan_details)) {
            $currency = $request->input('currency', 'INR');
            $hiddenField = salt_decrypt($request->input('hiddenField')) ?? null;
            $user_detail = BuyerRegistrationTemp::find($hiddenField);
            $receiptId = $this->getNextReceiptId($hiddenField);
            $amount_with_gst = $plan_details->price + ($plan_details->price * $plan_details->gst / 100);
            if ($plan_details->is_trial_plan == 0) {
                $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                $order = $api->order->create([
                    'amount' => round($amount_with_gst) * 100, // Amount in paise
                    'currency' => $currency,
                    'receipt' => (string) $receiptId,
                    'notes' => [
                        'plan' => $plan_details->description,
                    ],
                ]);
                CompanyPlanPayment::create([
                    'transaction_id' => $order->id,
                    'purchase_id' => Str::uuid(),
                    'plan_id' => $plan_details->id,
                    'amount' => $plan_details->price,
                    'amount_with_gst' => $amount_with_gst,
                    'gst_percent' => $plan_details->gst,
                    'currency' => $currency,
                    'receipt_id' => $receiptId,
                    'is_trial_plan' => $plan_details->is_trial_plan,
                    'payment_status' => CompanyPlanPayment::PAYMENT_STATUS_PENDING,
                    'email' => $user_detail->email,
                    'mobile' => $user_detail->mobile,
                    'buyer_id' => $hiddenField, // this is the buyer temp id
                    'json_response' => json_encode($order->toArray()),
                ]);

                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'is_trial_plan' => $plan_details->is_trial_plan,
                    'message' => __('auth.paymentOrder'),
                    'order' => $order->toArray(),
                ]], __('statusCode.statusCode200'));
            } else {
                $payment = CompanyPlanPayment::create([
                    'transaction_id' => 'pay_'.Str::random(8),
                    'purchase_id' => Str::uuid(),
                    'plan_id' => $plan_details->id,
                    'amount' => $plan_details->price,
                    'amount_with_gst' => $amount_with_gst,
                    'gst_percent' => $plan_details->gst,
                    'currency' => $currency,
                    'receipt_id' => $receiptId,
                    'is_trial_plan' => $plan_details->is_trial_plan,
                    'payment_status' => CompanyPlanPayment::PAYMENT_STATUS_SUCCESS,
                    'email' => $user_detail->email,
                    'mobile' => $user_detail->mobile,
                    'buyer_id' => $hiddenField, // this is the buyer temp id
                    'json_response' => json_encode([]),
                ]);

                $this->storePaymentDetails($payment);

                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'is_trial_plan' => $plan_details->is_trial_plan,
                    'message' => __('auth.paymentOrder'),
                    'order' => [],
                ]], __('statusCode.statusCode200'));
            }
        }
    }

    /**
     * Handle the successful payment request.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request object.
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse The JSON response or redirect response.
     *
     * @throws \Exception If an error occurs during the payment process.
     *
     * @OA\Post(
     *     path="/api/payment-success/callback",
     *     summary="Handle successful payment",
     *     description="Handle the successful payment request and perform necessary actions.",
     *     tags={"Payment"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(ref="#/components/schemas/PaymentSuccessRequest")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Payment success",
     *
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Payment failed",
     *
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function paymentSuccess(Request $request)
    {
        // Store request all value in logs
        \Log::info('Request data: '.json_encode($request->all()));
        $paymentId = $request->input('razorpay_payment_id');
        $orderId = $request->input('razorpay_order_id');
        $signature = $request->input('razorpay_signature');

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $attributes = [
            'razorpay_order_id' => $orderId,
            'razorpay_payment_id' => $paymentId,
            'razorpay_signature' => $signature,
        ];
        try {
            $api->utility->verifyPaymentSignature($attributes);
            $payment = CompanyPlanPayment::where('transaction_id', $orderId)->first();
            $payment->razorpay_payment_id = $paymentId;
            $payment->razorpay_signature = $signature;
            $payment->payment_status = CompanyPlanPayment::PAYMENT_STATUS_SUCCESS;
            $payment->save();

            return $this->storePaymentDetails($payment);
        } catch (\Exception $e) {

            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            \Log::info('Request data: '.$e->getMessage().'---- '.$e->getLine());
            if (config('app.front_end_tech') == false) {
                return redirect()->route('payment.failed');
            }

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => __('auth.paymentFailed'),
            ]], __('statusCode.statusCode422'));
        }
    }

    /**
     * Handle the failed payment request.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    private function storePaymentDetails($payment)
    {
        try {
            // Delete receipt information because that is used for the next receipt id
            Receipt::where('last_receipt_id', $payment->receipt_id)->delete();

            $user = BuyerRegistrationTemp::where('id', $payment->buyer_id)->first();

            // Register User
            $buyer = User::create([
                'name' => $user->first_name.' '.$user->last_name,
                'email' => $user->email,
                'password' => $user->password,
            ]);

            // assign role to the buyer
            $buyer->assignRole(User::ROLE_BUYER);

            // Register Business
            $company_detail = CompanyDetail::create([
                'user_id' => $buyer->id,
                'business_name' => $user->business_name,
                'display_name' => generateUniqueCompanyUsername($user->business_name), // this is the display name of the business
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'mobile_no' => $user->mobile,
                'email' => $user->email,
                'gst_no' => $user->gst,
                'pan_no' => $user->pan,
                'designation' => $user->designation,
            ]);
            $payment->company_id = $company_detail->id;
            $payment->save();

            $company_detail->company_serial_id = generateCompanySerialId($company_detail->id, 'B');
            $company_detail->save();

            $plan_details = Plan::where(['id' => $payment->plan_id, 'status' => Plan::STATUS_ACTIVE])->first();
            // Register Company Subscription Details
            $company_detail->subscription()->create([
                'company_id' => $company_detail->id,
                'plan_id' => $payment->plan_id,
                'subscription_start_date' => Carbon::now(),
                'subscription_end_date' => Carbon::now()->addDays($plan_details->duration)->subDay(),
                'status' => CompanyPlan::STATUS_ACTIVE,
            ]);

            // Register Business Address Details
            $company_detail->address()->create([
                'company_id' => $company_detail->id,
                'address_line1' => $user->address,
                'state' => $user->state,
                'city' => $user->city,
                'pincode' => $user->pin_code,
                'address_type' => CompanyAddressDetail::TYPE_DELIVERY_ADDRESS,
                'is_primary' => true,
            ]);

            $company_detail->address()->create([
                'company_id' => $company_detail->id,
                'address_line1' => $user->address,
                'state' => $user->state,
                'city' => $user->city,
                'pincode' => $user->pin_code,
                'address_type' => CompanyAddressDetail::TYPE_BILLING_ADDRESS,
                'is_primary' => false,
            ]);

            // Register Business Operation Details
            $company_detail->operation()->create([
                'company_id' => $company_detail->id,
                'product_channel' => $user->product_channel,
            ]);

            if (config('app.front_end_tech') == false) {
                // Trigger email verification notification
                $buyer->notify(new VerifyEmail);

                return redirect()->route('thankyou');
            }

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.paymentSuccess'),
            ]], __('statusCode.statusCode200'));
        } catch (\Exception $e) {

            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            \Log::error('Error in storePaymentDetails: '.$e->getMessage());
            if (config('app.front_end_tech') == false) {
                return redirect()->route('payment.failed');
            }

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => __('auth.paymentFailed'),
            ]], __('statusCode.statusCode422'));
        }
        
    }
}

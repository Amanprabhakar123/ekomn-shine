<?php

namespace App\Http\Controllers\APIAuth;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use Razorpay\Api\Api;
use App\Models\Receipt;
use App\Models\CompanyPlan;
use Illuminate\Support\Str;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Models\CompanyDetail;
use App\Events\ExceptionEvent;
use App\Models\CompanyPlanPayment;
use App\Notifications\VerifyEmail;
use App\Traits\ReceiptIdGenerator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CompanyAddressDetail;
use App\Models\BuyerRegistrationTemp;
use App\Models\CompanyPlanPermission;
use League\Fractal\Resource\Collection;
use App\Transformers\SubscriptionListTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class PaymentController extends Controller
{
    use ReceiptIdGenerator;

    protected $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
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
                'subscription_end_date' => Carbon::now()->addDays($plan_details->duration),
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

            // Add the user download and inventory count
            CompanyPlanPermission::create([
                'company_id' => $company_detail->id,
                'inventory_count' => 0,
                'download_count' => 0,
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

    /**
     * get the value payement information.
     * 
     * @param  \Illuminate\Http\Request  $request  The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public function getPaymentInfo(Request $request)
    {
        try{
        $perPage = $request->get('per_page', 10);
        $serchTerm = $request->input('query', null);
        $sort_by_status = $request->input('sort_by_status', null);
        $sort_by_plan_name = $request->input('sort_by_plan_name', null);
        $start_date = $request->input('start_date', null);
        $last_date = $request->input('last_date', null);

        if (!empty($sort_by_plan_name)) {
            // Assuming you have a way to detect if the value is encrypted
            $plan_id = salt_decrypt($sort_by_plan_name);
        } else {
            // Handle the case where the value is not provided
            $decrypted_value = null;
        }

        
        $payments = CompanyPlanPayment::with('companyDetails.subscription', 'companyDetails.planSubscription', 'plan')
        ->where('payment_status', CompanyPlanPayment::PAYMENT_STATUS_SUCCESS);

        if (!empty($serchTerm)) {
            $payments = $payments->whereHas('companyDetails', function ($query) use ($serchTerm) {
                $query->where('business_name', 'like', '%' . $serchTerm . '%')
                    ->orWhere('company_serial_id', 'like', '%' . $serchTerm . '%')
                    ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $serchTerm . '%')
                    ->orWhere('first_name', 'like', '%' . $serchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $serchTerm . '%');
            });
        }

        if (!empty($plan_id)) {
            $payments = $payments->whereHas('plan', function ($query) use ($plan_id) {
                $query->where('id', 'like', '%' . $plan_id . '%');
            });
        }

        if (!is_null($sort_by_status)) {
            $payments = $payments->whereHas('companyDetails.subscription', function ($query) use ($sort_by_status) {
                $query->where('status', 'like', '%' . $sort_by_status . '%');
            });
        }
        
        if(!is_null($start_date) && !is_null($last_date)) {
            $payments = $payments->whereHas( 'companyDetails.subscription', function ($query) use ($start_date, $last_date) {
                $query->where('subscription_start_date', '>=', $start_date)
                ->where('subscription_end_date', '<=', $last_date);
            });
        }

        $payments = $payments->orderBy('id', 'desc');
        // Filter the payments based on the request
        $payments = $payments->paginate($perPage);
            

        // Transform the paginated results using Fractal
        $resource = new Collection($payments, new SubscriptionListTransformer);

        // Add pagination information to the resource
        $resource->setPaginator(new IlluminatePaginatorAdapter($payments));

        // Create the data array using Fractal
        $data = $this->fractal->createData($resource)->toArray();

        return response()->json($data);

        }catch(\Exception $e){
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
        }
        dd($exceptionDetails);
        event(new ExceptionEvent($exceptionDetails));

   


    }
}

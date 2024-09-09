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
use App\Models\BuyerInventory;
use App\Models\CompanyPlanPayment;
use App\Notifications\VerifyEmail;
use App\Traits\ReceiptIdGenerator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CompanyAddressDetail;
use App\Models\BuyerRegistrationTemp;
use App\Models\CompanyPlanPermission;
use App\Services\PaymentSubscription;
use League\Fractal\Resource\Collection;
use Elastic\Elasticsearch\Endpoints\Cat;
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
                // create subscription for buyer
                if(env('RAZORPAY_PAY_SUBSCRIPTION') == true){
                    $subscription  = new PaymentSubscription();
                    if($plan_details->duration == 30){
                        $total_count = 12;
                    }else{
                        $total_count = 1;
                    }
                    $subscriptionData = $subscription->createNewSubscription($plan_details->razorpay_plan_id, $total_count);
                }
                $order = $api->order->create([
                    'amount' => (int) ($amount_with_gst * 100), // Amount in paise
                    'currency' => $currency,
                    'receipt' => (string) $receiptId,
                    'notes' => [
                        'plan' => $plan_details->description,
                    ]
                ]);
                if(env('RAZORPAY_PAY_SUBSCRIPTION') == true){
                    $order['subscription_id'] = $subscriptionData['id'];
                }
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
        // \Log::info('Request data: '.json_encode($request->all()));
        if(env('RAZORPAY_PAY_SUBSCRIPTION') == true){
            $paymentId = $request->input('razorpay_payment_id');
            $signature = $request->input('razorpay_signature');
            $subscription_id = $request->input('razorpay_subscription_id');
        }else{
            $paymentId = $request->input('razorpay_payment_id');
            $signature = $request->input('razorpay_signature');
            $orderId = $request->input('razorpay_order_id');
        }

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        
        try {
            if(env('RAZORPAY_PAY_SUBSCRIPTION') == true){
                 // Update Subscription status
                $subscription = $api->subscription->fetch($subscription_id);
                // Verify the payment
                $payment = $api->payment->fetch($paymentId);
                $orderId = $payment->order_id;
                $subscriptionData = ['razorpay_subscription_id' => $subscription_id, 'razorpay_plan_id' => $subscription->plan_id];

            }else{
                $attributes = [
                    'razorpay_order_id' => $orderId,
                    'razorpay_payment_id' => $paymentId,
                    'razorpay_signature' => $signature,
                ];
                $api->utility->verifyPaymentSignature($attributes);
                $subscriptionData = null;
            }
           
            // Update the payment status
            $payment = CompanyPlanPayment::where('transaction_id', $orderId)->first();
            $payment->razorpay_payment_id = $paymentId;
            $payment->razorpay_signature = $signature;
            $payment->payment_status = CompanyPlanPayment::PAYMENT_STATUS_SUCCESS;
            $payment->save();

            return $this->storePaymentDetails($payment, $subscriptionData);
        } catch (\Exception $e) {

            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Update the payment status
            $payment = CompanyPlanPayment::where('transaction_id', $orderId)->first();
            $payment->razorpay_payment_id = $paymentId;
            $payment->razorpay_signature = $signature;
            $payment->payment_status = CompanyPlanPayment::PAYMENT_STATUS_FAILED;
            $payment->save();

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
    private function storePaymentDetails($payment, $subscriptionData = null)
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
            if(env('RAZORPAY_PAY_SUBSCRIPTION') == true){
                if(!is_null($subscriptionData)) {
                    $company_detail->razorpay_subscription_id = $subscriptionData['razorpay_subscription_id'];
                    $company_detail->razorpay_plan_id = $subscriptionData['razorpay_plan_id'];
                    $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_ACTIVE;
                }
            }
           
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

        
        // $payments = CompanyPlanPayment::with('companyDetails.subscription', 'companyDetails.planSubscription', 'plan',)
        // ->where('payment_status', CompanyPlanPayment::PAYMENT_STATUS_SUCCESS);

        $payments = CompanyPlanPayment::with([
            'companyDetails.subscription' => function ($query) {
            $query->orderBy('id', 'desc')->limit(1); // Fetch the latest subscription with status 1
            },
            'companyDetails',
            'companyDetails.planSubscription',
            'plan',
        ])->where('payment_status', CompanyPlanPayment::PAYMENT_STATUS_SUCCESS);
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
                $query->where('status', $sort_by_status);
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
        // dd($data);
        return response()->json($data);

        }catch(\Exception $e){
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
        }
        event(new ExceptionEvent($exceptionDetails));
    }

    /**
     * change staus subscription.
     * 
     * @param  \Illuminate\Http\Request  $request  The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public function changeSubscriptionStatus(Request $request)
    {
        try{
        $company_id = salt_decrypt($request->input('company_id'));
        $company_detail = CompanyDetail::find($company_id);
        $subscription = new PaymentSubscription();
        if($request->is_cancel){
            $subscription = $subscription->cancelSubscription($company_detail->razorpay_subscription_id);
            if($subscription['status'] == 'cancelled'){
                $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_CANCELLED;
                $company_detail->save();
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.subscriptionCancelled'),
                ]], __('statusCode.statusCode200'));
            }
        }else{
            $subscription = $subscription->changeSubscriptionStatus($company_detail->razorpay_subscription_id, !$company_detail->subscription_status);
            if($subscription['status'] == 'active'){
                $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_ACTIVE;
            }elseif($subscription['status'] == 'paused'){
                $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_IN_ACTIVE;
            }elseif($subscription['status'] == 'completed'){
                $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_COMPLETED;
            }elseif($subscription['status'] == 'cancelled'){
                $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_CANCELLED;
            }elseif($subscription['status'] == 'expired'){
                $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_EXPIRED;
            }elseif($subscription['status'] == 'authenticated'){
                $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_AUTH;
            }
            $company_detail->save();
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.subscriptionStatusChanged'),
            ]], __('statusCode.statusCode200'));
        }
        }catch(\Exception $e){
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
            event(new ExceptionEvent($exceptionDetails));
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => __('auth.subscriptionStatusFailed'),
            ]], __('statusCode.statusCode422'));
        }
    }

    /**
     * enable subscription.
     * 
     * @param  \Illuminate\Http\Request  $request  The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public function enableSubscription(Request $request)
    {
        try{
        $company_id = salt_decrypt($request->input('company_id'));
        $plan_id = salt_decrypt($request->input('plan_id'));
        $company_detail = CompanyDetail::find($company_id);
        $plan_details = Plan::find($plan_id);
        if($plan_details->is_trial_plan == 1) {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => __('auth.planNotEligible'),
            ]], __('statusCode.statusCode422'));
        }
        $subscription = new PaymentSubscription();
        if($plan_details->duration == 30){
            $total_count = 12;
        }else{
            $total_count = 1;
        }
        $subscriptionData = $subscription->createNewSubscription($plan_details->razorpay_plan_id, $total_count, $request->subscription_end_date);
        
        if($subscriptionData['status'] == 'created'){
            $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_CREATED;
            $company_detail->razorpay_subscription_id = $subscriptionData['id'];
            $company_detail->razorpay_plan_id = $subscriptionData['plan_id'];
        }
        $company_detail->save();
        
        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'payment_link' => $subscriptionData['short_url'],
        ]], __('statusCode.statusCode200'));

        }catch(\Exception $e){
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
            event(new ExceptionEvent($exceptionDetails));
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => __('auth.subscriptionStatusFailed'),
            ]], __('statusCode.statusCode422'));
        }
    }

    /**
     * active subscription.
     * 
     * @param  \Illuminate\Http\Request  $request  The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public function activeSubscription(Request $request)
    {
        try{
        $data = $request->all();
        $subscription_id = $data['payload']['subscription']['entity']['id'];
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        // Update Subscription status
        $subscription = $api->subscription->fetch($subscription_id);
        $company_detail = CompanyDetail::where('razorpay_subscription_id', $subscription_id)->first();
        if(empty($company_detail)){
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => __('auth.subscriptionStatusFailed'),
            ]], __('statusCode.statusCode422'));
        }
        if($subscription->status == 'authenticated'){
            $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_AUTH;
            $company_detail->save();
        }elseif($subscription->status == 'active'){
            $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_ACTIVE;
            $company_detail->save();
        }elseif($subscription->status == 'completed'){
            $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_COMPLETED;
            $company_detail->save();
        }elseif($subscription->status == 'pending'){
            $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_PENDING;
            $company_detail->save();
        }
        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'message' => __('auth.subscriptionStatusChanged'),
        ]], __('statusCode.statusCode200'));
        }catch(\Exception $e){
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
            event(new ExceptionEvent($exceptionDetails));
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => __('auth.subscriptionStatusFailed'),
            ]], __('statusCode.statusCode422'));
        }
    }

    /**
     * get the value payement information.
     * 
     * @param  \Illuminate\Http\Request  $request  The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public function renewPayment(Request $request){
        try{
            $company_id = salt_decrypt($request->input('company_id'));
            $last_plan = salt_decrypt($request->input('last_plan'));
            $new_plan = salt_decrypt($request->input('plan'));
            $is_downgrade = $request->input('is_downgrade', false);

            // check plan is downgrade or upgrade
            if($is_downgrade){
                $isPlanStatus = $this->planDowngradeUpgrade($company_id, $last_plan, $new_plan, false);
            }else{
                $isPlanStatus = false;
            }
            if($isPlanStatus){
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => __('auth.downgradePlan'),
                ]], __('statusCode.statusCode200'));
            }
            $receiptId = $this->getNextReceiptId(rand(1, 9999999999999));
            $currency = $request->input('currency', 'INR');
            $plan_details = Plan::where('id', $new_plan)->where('status', Plan::STATUS_ACTIVE)->first();
            $company_detail = CompanyDetail::find($company_id);
            $amount_with_gst = $plan_details->price + ($plan_details->price * $plan_details->gst / 100);

            $subscriptionData = [];
            // check current subscription status
            if($company_detail->subscription_status == CompanyDetail::SUBSCRIPTION_STATUS_ACTIVE){
                // check current subscription razorpay_plan_id
                if($company_detail->razorpay_plan_id != $plan_details->razorpay_plan_id){
                    $razorpay_subscription_id = $company_detail->razorpay_subscription_id;
                    $subscription = new PaymentSubscription();
                    if($plan_details->duration == 30){
                        $total_count = 12;
                    }else{
                        $total_count = 1;
                    }
                    $subscriptionData = $subscription->changeSubscription($razorpay_subscription_id, $plan_details->razorpay_plan_id, $total_count);
                    $company_detail->razorpay_subscription_id = $subscriptionData['id'];
                    $company_detail->razorpay_plan_id = $subscriptionData['plan_id'];
                    $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_CREATED;
                    $company_detail->save();
                }    
            }
            if ($plan_details->is_trial_plan == 0) {
                $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                $order = $api->order->create([
                    'amount' => (int) ($amount_with_gst * 100), // Amount in paise
                    'currency' => $currency,
                    'receipt' => (string) $receiptId,
                    'notes' => [
                        'plan' => $plan_details->description,
                    ]
                ]);

                if(!empty($subscriptionData)){
                    $order['subscription_id'] = $subscriptionData['id'];
                }

                CompanyPlanPayment::create([
                    'transaction_id' => $order->id,
                    'purchase_id' => Str::uuid(),
                    'plan_id' => $plan_details->id,
                    'company_id' => $company_detail->id,
                    'amount' => $plan_details->price,
                    'amount_with_gst' => $amount_with_gst,
                    'gst_percent' => $plan_details->gst,
                    'currency' => $currency,
                    'receipt_id' => $receiptId,
                    'is_trial_plan' => $plan_details->is_trial_plan,
                    'payment_status' => CompanyPlanPayment::PAYMENT_STATUS_PENDING,
                    'email' => $company_detail->email,
                    'mobile' => $company_detail ->mobile_no,
                    'buyer_id' => $company_detail->user_id, // this is the buyer temp id or user_id
                    'json_response' => json_encode($order->toArray()),
                ]);

                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'is_trial_plan' => $plan_details->is_trial_plan,
                    'message' => __('auth.paymentOrder'),
                    'order' => $order->toArray(),
                ]], __('statusCode.statusCode200'));
            }
        }catch(\Exception $e){
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
            event(new ExceptionEvent($exceptionDetails));
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
     *     path="/api/renewal-payment-success/callback",
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
    public function renewalPaymentSuccess(Request $request)
    {
        // Store request all value in logs
        // \Log::info('Request data: '.json_encode($request->all()));
        try {
            $data = $request->all();
            if(isset($data['event']) && $data['event'] == 'subscription.charged'){
                $subscription = $data['payload']['subscription']['entity'];
                $subscription_id = $subscription['id'];
                $paymentData = $data['payload']['payment']['entity'];
                $orderId = $paymentData['order_id'];
                $paymentId = $paymentData['id'];
                $signature = $paymentData['description'];
                $plan_id = $subscription['plan_id'];
                $company_detail = CompanyDetail::where('razorpay_subscription_id', $subscription_id)->first();
                if(empty($company_detail)){
                    return response()->json(['data' => [
                        'statusCode' => __('statusCode.statusCode422'),
                        'status' => __('statusCode.status422'),
                        'message' => __('auth.subscriptionStatusFailed'),
                    ]], __('statusCode.statusCode422'));
                }
                $plan_details = Plan::where('razorpay_plan_id', $plan_id)->where('status', Plan::STATUS_ACTIVE)->first();
                $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_ACTIVE;
                $company_detail->save();
                $amount_with_gst = $plan_details->price + ($plan_details->price * $plan_details->gst / 100);
                $receiptId = $this->getNextReceiptId(rand(1, 9999999999999));
                $currency = $request->input('currency', 'INR');
                CompanyPlanPayment::create([
                    'transaction_id' => $orderId,
                    'purchase_id' => Str::uuid(),
                    'plan_id' => $plan_details->id,
                    'company_id' => $company_detail->id,
                    'amount' => $plan_details->price,
                    'amount_with_gst' => $amount_with_gst,
                    'gst_percent' => $plan_details->gst,
                    'currency' => $currency,
                    'receipt_id' => $receiptId,
                    'is_trial_plan' => $plan_details->is_trial_plan,
                    'payment_status' => CompanyPlanPayment::PAYMENT_STATUS_SUCCESS,
                    'email' => $company_detail->email,
                    'mobile' => $company_detail ->mobile_no,
                    'buyer_id' => $company_detail->user_id, // this is the buyer temp id or user_id 
                    'json_response' => json_encode($data),
                ]);
                 // In active last plan
                 $last_plan = CompanyPlan::where('company_id', $company_detail->id)
                 //  ->where('status', CompanyPlan::STATUS_ACTIVE)
                 ->orderBy('id', 'desc')
                 ->first();
                 if(!empty($last_plan)){
                     $last_plan->status = CompanyPlan::STATUS_INACTIVE;
                     $last_plan->save();
                 }

                 // Create new plan for the company
                CompanyPlan::create([
                    'company_id' => $company_detail->id,
                    'plan_id' => $plan_details->id,
                    'subscription_start_date' => Carbon::now(),
                    'subscription_end_date' => Carbon::now()->addDays($plan_details->duration),
                    'status' => CompanyPlan::STATUS_ACTIVE,
                ]);
    
                 // update the download count
                 CompanyPlanPermission::updateOrCreate(['company_id' => $company_detail->id],[
                    'company_id' => $company_detail->id,
                    'download_count' => 0,
                ]);
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.paymentSuccess'),
                ]], __('statusCode.statusCode200'));
    
            }else{
                $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                if(isset($data['razorpay_subscription_id'])){
                    $paymentId = $request->input('razorpay_payment_id');
                    $signature = $request->input('razorpay_signature');
                    $subscription_id = $request->input('razorpay_subscription_id');
                     // Update Subscription status
                    $subscription = $api->subscription->fetch($subscription_id);
                    // Verify the payment
                    $payment = $api->payment->fetch($paymentId);
                    $orderId = $payment->order_id;
                    $subscriptionData = ['razorpay_subscription_id' => $subscription_id, 'razorpay_plan_id' => $subscription->plan_id];
                }else{
                    $paymentId = $request->input('razorpay_payment_id');
                    $signature = $request->input('razorpay_signature');
                    $orderId = $request->input('razorpay_order_id');
                    $attributes = [
                        'razorpay_order_id' => $orderId,
                        'razorpay_payment_id' => $paymentId,
                        'razorpay_signature' => $signature,
                    ];
                    $api->utility->verifyPaymentSignature($attributes);
                    $subscriptionData = null;
                }
                // Update the payment status
                $payment = CompanyPlanPayment::where('transaction_id', $orderId)->first();
                $payment->razorpay_payment_id = $paymentId;
                $payment->razorpay_signature = $signature;
                $payment->payment_status = CompanyPlanPayment::PAYMENT_STATUS_SUCCESS;
                $payment->save();
                $company_detail = CompanyDetail::find($payment->company_id);

                if(!is_null($subscriptionData)){
                    $company_detail->razorpay_subscription_id = $subscriptionData['razorpay_subscription_id'];
                    $company_detail->razorpay_plan_id = $subscriptionData['razorpay_plan_id'];
                    $company_detail->subscription_status = CompanyDetail::SUBSCRIPTION_STATUS_ACTIVE;
                    $company_detail->save();
                }
    
                // In active last plan
                $last_plan = CompanyPlan::where('company_id', $company_detail->id)
                // ->where('status', CompanyPlan::STATUS_ACTIVE)
                ->orderBy('id', 'desc')
                ->first();
                if(!empty($last_plan)){
                    $last_plan->status = CompanyPlan::STATUS_INACTIVE;
                    $last_plan->save();
                }
    
                // get new plan details
                $plan_details = Plan::where('id', $payment->plan_id)->where('status', Plan::STATUS_ACTIVE)->first();
                // Create new plan for the company
                CompanyPlan::create([
                    'company_id' => $company_detail->id,
                    'plan_id' => $payment->plan_id,
                    'subscription_start_date' => Carbon::now(),
                    'subscription_end_date' => Carbon::now()->addDays($plan_details->duration),
                    'status' => CompanyPlan::STATUS_ACTIVE,
                ]);
    
                $is_downgrade = $this->planDowngradeUpgrade($company_detail->id, $last_plan->plan_id, $payment->plan_id, true);
                    if($is_downgrade['status']){
                        $current_inventory_count = $is_downgrade['current_inventory_count'];
                        $last_inventory_count = $is_downgrade['last_inventory_count'];
    
                        // which inventory count is bigger
                        if($last_inventory_count < $current_inventory_count){
                            $inventory_count = $last_inventory_count;
                        }else{
                            $inventory_count = $current_inventory_count;
                        }
                        // Update the company plan permission
                        CompanyPlanPermission::updateOrCreate(['company_id' => $company_detail->id],[
                            'company_id' => $company_detail->id,
                            'inventory_count' => $inventory_count,
                            'download_count' => 0,
                        ]);
                
                        // Step 1: Retrieve the IDs of all records except the first 100
                        $idsToDelete = BuyerInventory::where('company_id', $company_detail->id)
                        ->orderBy('id', 'asc')  // Order by ascending to get the first records first
                        ->limit($current_inventory_count)            // Skip the first 100 records
                        ->pluck('id');          // Get the IDs of the remaining records
    
                        if($idsToDelete->isNotEmpty()){
                            // Step 2: Delete the records with the retrieved IDs
                            BuyerInventory::whereNotIn('id', $idsToDelete)->delete();
                        }
                    }else{
                        CompanyPlanPermission::updateOrCreate(['company_id' => $company_detail->id],[
                            'company_id' => $company_detail->id,
                            'download_count' => 0,
                        ]);
                    }
                return redirect()->route('subscription.view');
            }
    
        } catch (\Exception $e) {
    
            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
    
            // Update the payment status
            $payment = CompanyPlanPayment::where('transaction_id', $orderId)->first();
            $payment->razorpay_payment_id = $paymentId;
            $payment->razorpay_signature = $signature;
            $payment->payment_status = CompanyPlanPayment::PAYMENT_STATUS_FAILED;
            $payment->save();
    
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
    
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
     * check the plan is downgrade or upgrade.
     * 
     * @param  int  $company_id  The company id.
     * @param  int  $last_plan  The last plan id.
     * @param  int  $new_plan  The new plan id.
     * @return bool The JSON response.
     */
    public function planDowngradeUpgrade($company_id, $last_plan, $new_plan, $respose = false){
        $last_plan_details = Plan::find($last_plan);
        $last_features = json_decode($last_plan_details->features, true);
        $last_download_count = $last_features['download_count'];
        $last_inventory_count = $last_features['inventory_count'];

        $new_plan_details = Plan::find($new_plan);
        $features = json_decode($new_plan_details->features, true);
        $current_download_count = $features['download_count'];
        $current_inventory_count = $features['inventory_count'];
        $permission = CompanyPlanPermission::where('company_id', $company_id)->get();
        if($permission->isNotEmpty()){
            $permission = $permission->first();
            $inventory_count = $permission->inventory_count;
        }else{
            $inventory_count = 0;
        }

        if(($current_download_count < $last_download_count) && ($current_inventory_count < $last_inventory_count)){
            if($respose){
               return ['status' => true,
                'last_download_count' => $last_download_count,
                'last_inventory_count' => $inventory_count,
                'current_download_count' => $current_download_count,
                'current_inventory_count' => $current_inventory_count
               ];
            }
           return true;
        }
        if($respose){
            return [
            'status' => false,
             'last_download_count' => $last_download_count,
             'last_inventory_count' => $inventory_count,
             'current_download_count' => $current_download_count,
             'current_inventory_count' => $current_inventory_count
            ];
         }
        return false;
    }
}

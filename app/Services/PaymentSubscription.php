<?php

namespace App\Services;

use Carbon\Carbon;
use Razorpay\Api\Api;
use App\Models\CompanyDetail;

class PaymentSubscription
{
    // Set the API key
    protected $razorpay;
    
    /**
     * PaymentSubscription constructor.
     */
    public function __construct()
    {
       $this->razorpay = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }

    /**
     * Fetch subscription details
     * @param $subscriptionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchSubscription($subscriptionId)
    {
        $subscription = $this->razorpay->subscription->fetch($subscriptionId);
        return $subscription;
    }

    /**
     * Cancel subscription
     * @param $subscriptionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelSubscription($subscriptionId)
    {
        $subscription = $this->razorpay->subscription->fetch($subscriptionId);
        $subscription->cancel(['cancel_at_cycle_end' => 0]); // Immediate cancellation
        return ['status' => 'cancelled'];
    }

    /**
     * Create new subscription
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNewSubscription($plan_id, $total_count, $start_at = null)
    {
        $total_count = $total_count ? $total_count : 12;
        $subscriptionData = [
            'plan_id' => $plan_id, // New plan ID
            'customer_notify' => 1,
            'total_count' => $total_count * 10, // Number of billing cycles
            'expire_by' => now()->addYears(10)->timestamp, // End time in Unix timestamp
        ];

        if(!is_null($start_at)){
            $subscriptionData['start_at'] = Carbon::parse($start_at)->timestamp;
        }

        $newSubscription = $this->razorpay->subscription->create($subscriptionData);
        return $newSubscription;
    }

    /**
     * Change subscription
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeSubscription($request, $total_count)
    {
        $currentSubscriptionId = $request->current_subscription_id;
        $newPlanId = $request->new_plan_id;

        // Fetch current subscription
        $currentSubscription = $this->fetchSubscription($currentSubscriptionId);

        // Cancel current subscription
        $this->cancelSubscription($currentSubscriptionId);

        // Create new subscription
        $newSubscription = $this->createNewSubscription($newPlanId, $total_count);

        return $newSubscription;
    }

    /**
     * Change subscription status
     * @param $subscriptionId
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeSubscriptionStatus($subscriptionId, $status)
    {
        $subscription = $this->razorpay->subscription->fetch($subscriptionId);

        if($status == CompanyDetail::SUBSCRIPTION_STATUS_ACTIVE && $subscription->status == 'paused'){
            $subscription = $this->razorpay->subscription->fetch($subscriptionId)->resume(['resume_at' => 'now']);  
        }elseif($status == CompanyDetail::SUBSCRIPTION_STATUS_IN_ACTIVE && $subscription->status == 'active'){
            $subscription = $this->razorpay->subscription->fetch($subscriptionId)->pause(['pause_at' => 'now']);  
        }elseif($subscription->status == 'completed'){
            return ['status' => 'completed'];
        }
        return $subscription;
    }
}
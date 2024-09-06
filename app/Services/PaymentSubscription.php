<?php

namespace App\Services;

use Razorpay\Api\Api;

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
    public function createNewSubscription($plan_id, $total_count)
    {
        $total_count = $total_count ? $total_count : 12;
        $subscriptionData = [
            'plan_id' => $plan_id, // New plan ID
            'customer_notify' => 1,
            'total_count' => $total_count * 10, // Number of billing cycles
            // 'start_at' => now()->addMinutes(5)->timestamp, // Start time in Unix timestamp
            'expire_by' => now()->addYears(10)->timestamp, // End time in Unix timestamp
        ];

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
}
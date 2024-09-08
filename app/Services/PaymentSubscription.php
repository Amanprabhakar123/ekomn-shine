<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Plan;
use Razorpay\Api\Api;
use App\Models\CompanyPlan;
use App\Models\EkomnDetails;
use App\Models\CompanyDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

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
        }
        else{
            return ['status' => $subscription->status];
        }
        return $subscription;
    }

    /**
     * subscription invoice
     * 
     * @param $subscriptionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscriptionInvoice($subscriptionId)
    {
        $companyDetail = CompanyDetail::where('id', $subscriptionId)->with([
            'subscription' => function ($query) {
                $query->orderBy('id', 'desc')
                      ->limit(1);  // Fetch the latest subscription with status 1
            },
            'address',
            'subscription.plan',
            'planSubscription',
            'companyPlanPayment' => function ($query) {
                $query->orderBy('id', 'desc')
                      ->limit(1);  // Fetch the latest payment
            },
        ])
        ->first();

        $ekomn = EkomnDetails::get()->first();
        // Get the logo image from the storage
        $logo = 'data:image/png;base64,' . base64_encode(file_get_contents('assets/images/logo_b.png'));
        // Get the rupee image from the storage
        $rupee = 'data:image/png;base64,' . base64_encode(file_get_contents('assets/images/icon/rupee.png'));
        // Prepare data for the PDF
            $data = [
                'ekomn' => $ekomn->ekomn_name,
                'ekomn_address' => $ekomn->address,
                'ekomn_pincode' => $ekomn->pincode,
                'ekomn_city' => $ekomn->city,
                'ekomn_state' => $ekomn->state,
                'ekomn_gst' => $ekomn->gst,
                'first_name' => $companyDetail->first_name,
                'last_name' => $companyDetail->last_name,
                'gst_no' => $companyDetail->gst_no,
                'address' => $companyDetail->address[0]->address_line1,
                'city' => $companyDetail->address[0]->city,
                'state' => $companyDetail->address[0]->state,
                'pincode' => $companyDetail->address[0]->pincode,
                'plane_name' => $companyDetail->subscription[0]->plan->name,
                'hsn' =>$companyDetail->subscription[0]->plan->hsn,
                'gst' =>$companyDetail->subscription[0]->plan->gst,
                'price' =>$companyDetail->subscription[0]->plan->price,
                'receipt_id' => $companyDetail->companyPlanPayment->receipt_id,
                'date' => $companyDetail->companyPlanPayment,
                'subscription_start_date' => $companyDetail->subscription[0]->subscription_start_date->toDateString(),
                'subscription_end_date' => $companyDetail->subscription[0]->subscription_end_date->toDateString(),
                'amount_with_gst' => $companyDetail->companyPlanPayment->amount_with_gst,
                'logo' => $logo,
                'rupee' => $rupee,
            ];
            // Generate the PDF
            $pdf = PDF::loadView('pdf.subscription', $data);
            // Set the PDF coordinates
            $pdf->setOptions([
                'dpi' => 110,
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true,
                'isJavascriptEnabled' => true,
                'isHtmlImagesEnabled' => true,
            ]);

            $fileName = 'invoice_subscription.pdf';
            $pdf->render();
            // Save the PDF to the storage

            Storage::disk('public')->put('subscription/'.$companyDetail->subscription[0]->subscription_id.'/'.$fileName, $pdf->output());
            return 'subscription/'.$companyDetail->subscription[0]->subscription_id.'/'.$fileName;
    }
}
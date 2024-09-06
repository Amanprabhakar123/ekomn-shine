<?php

namespace App\Transformers;

use App\Models\SubscriptionList;
use App\Models\CompanyPlanPayment;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class SubscriptionListTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param SubscriptionList $subscriptionList
     * @return array<string, mixed>
     */
    public function transform(CompanyPlanPayment $CompanyPlanPayment): array
    {
        $status = !empty($CompanyPlanPayment->companyDetails->subscription) ? $CompanyPlanPayment->companyDetails->subscription->first()->status : 0;
        try{
        $data = [
            'id' => salt_encrypt($CompanyPlanPayment->id),
            'email' => $CompanyPlanPayment->email,
            'name' => !empty($CompanyPlanPayment->companyDetails) ? $CompanyPlanPayment->companyDetails->first_name . ' ' . $CompanyPlanPayment->companyDetails->last_name : '',
            'business_name' => !empty($CompanyPlanPayment->companyDetails->business_name) ? $CompanyPlanPayment->companyDetails->business_name : 'Null',
            'company_serial_id' => !empty($CompanyPlanPayment->companyDetails) ? $CompanyPlanPayment->companyDetails->company_serial_id : '',
            'type' => $CompanyPlanPayment->plan->getPlanType(),
            'plan_name' => $CompanyPlanPayment->plan->name,
            'amount' => $CompanyPlanPayment->amount,
            'amount_with_gst' => isset($CompanyPlanPayment->amount_with_gst) ? $CompanyPlanPayment->amount_with_gst : $CompanyPlanPayment->amount,
            'subscription_start_date' => !empty($CompanyPlanPayment->companyDetails->subscription) ? $CompanyPlanPayment->companyDetails->subscription->first()->subscription_start_date->toDateString() : '',
            'subscription_end_date' => !empty($CompanyPlanPayment->companyDetails->subscription) ? $CompanyPlanPayment->companyDetails->subscription->first()->subscription_end_date->toDateString() : '',
            'inventory_count' => isset($CompanyPlanPayment->companyDetails->planSubscription->inventory_count) ? $CompanyPlanPayment->companyDetails->planSubscription->inventory_count : 0,
            'download_count' => isset($CompanyPlanPayment->companyDetails->planSubscription->download_count) ? $CompanyPlanPayment->companyDetails->planSubscription->download_count : 0,
            'status' =>  getCompanyPlanStatus($status),
            
        ];

        return $data;
    }catch(\Exception $e){
        dd($e->getMessage(), $e->getLine());
        Log::error('Error transforming Subscription list: ' . $e->getMessage());
        return [];
    }
    }

}
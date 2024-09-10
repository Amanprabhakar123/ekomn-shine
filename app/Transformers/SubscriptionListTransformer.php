<?php

namespace App\Transformers;

use App\Models\SubscriptionList;
use App\Models\CompanyPlanPayment;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class SubscriptionListTransformer extends TransformerAbstract
{
    protected $export = false;

    public function __construct($export)
    {
        $this->export = $export;
    }
    /**
     * A Fractal transformer.
     *
     * @param SubscriptionList $subscriptionList
     * @return array<string, mixed>
     */
    public function transform(CompanyPlanPayment $CompanyPlanPayment): array
    {
        $status = !empty($CompanyPlanPayment->companyPlans) ? $CompanyPlanPayment->companyPlans->status : 0;
        try{
            $data = [
                'name' => !empty($CompanyPlanPayment->companyDetails) ? $CompanyPlanPayment->companyDetails->first_name . ' ' . $CompanyPlanPayment->companyDetails->last_name : '',
                'business_name' => !empty($CompanyPlanPayment->companyDetails->business_name) ? $CompanyPlanPayment->companyDetails->business_name : 'Null',
                'company_serial_id' => !empty($CompanyPlanPayment->companyDetails) ? $CompanyPlanPayment->companyDetails->company_serial_id : '',
                'type' => $CompanyPlanPayment->plan->getPlanType(),
                'plan_name' => $CompanyPlanPayment->plan->name,
                'amount' => $CompanyPlanPayment->amount,
                'amount_with_gst' => isset($CompanyPlanPayment->amount_with_gst) ? $CompanyPlanPayment->amount_with_gst : $CompanyPlanPayment->amount,
                'subscription_start_date' => !empty($CompanyPlanPayment->companyPlans) ? $CompanyPlanPayment->companyPlans->subscription_start_date->toDateString() : '',
                'subscription_end_date' => !empty($CompanyPlanPayment->companyPlans) ? $CompanyPlanPayment->companyPlans->subscription_end_date->toDateString() : '',
                'inventory_count' => isset($CompanyPlanPayment->companyDetails->planSubscription->inventory_count) ? $CompanyPlanPayment->companyDetails->planSubscription->inventory_count : 0,
                'download_count' => isset($CompanyPlanPayment->companyDetails->planSubscription->download_count) ? $CompanyPlanPayment->companyDetails->planSubscription->download_count : 0,
                'transaction_id' => $CompanyPlanPayment->transaction_id,
                'status' =>  getCompanyPlanStatus($status),
                
            ];
        if(!$this->export){
            $data['id'] = salt_encrypt($CompanyPlanPayment->id);
        }

        return $data;
    }catch(\Exception $e){
        dd($e->getMessage(), $e->getLine());
        Log::error('Error transforming Subscription list: ' . $e->getMessage());
        return [];
    }
    }

}
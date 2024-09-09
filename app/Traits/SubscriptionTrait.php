<?php

namespace App\Traits;

use App\Models\CompanyPlan;
use App\Models\BuyerInventory;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Models\CompanyPlanPermission;

trait SubscriptionTrait

{

    /**
     * Check if the buyer has a subscription
     *
     * @param int $company_id
     * @param int $count
     * @return bool
     */
    public function isBuyerDownloadCount($company_id, $count)
    {
        // get the permission of the plan
        $company_plan = CompanyPlan::with('plan')->where('company_id', $company_id)
            ->where('status', CompanyPlan::STATUS_ACTIVE)->orderBy('id', 'desc')->first();
        if ($company_plan) {
            $permission = CompanyPlanPermission::where('company_id', $company_id)->first();
            // check plan download count
            $feature = json_decode($company_plan->plan->features);
            $download_count = $feature->download_count;
            if ($permission) {
                if ($permission->download_count < $download_count) {
                    $remaining_count = $download_count - $permission->download_count;
                    if ($remaining_count >= $count) {
                        $permission->download_count = $permission->download_count + $count;
                        $permission->save();

                        return ['data' => [
                            'statusCode' => __('statusCode.statusCode200'),
                            'status' => __('statusCode.status200'),
                            'message' => __('auth.downloadSuccess'),
                        ]];
                    } else {
                        return ['data' => [
                            'statusCode' => __('statusCode.statusCode422'),
                            'status' => __('statusCode.status422'),
                            'message' => __('auth.downloadCountExceeded', ['count' => $remaining_count]),
                        ]];
                    }
                } else {
                    return ['data' => [
                        'statusCode' => __('statusCode.statusCode422'),
                        'status' => __('statusCode.status422'),
                        'message' => __('auth.downloadCountExceeded', ['count' => 0]),
                    ]];
                }
            } else {
                return ['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => __('auth.planNotEligible'),
                ]];
            }
        } else {
            return ['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => __('auth.planNotEligible'),
            ]];
        }
    }

    /**
     * Check if the buyer has a subscription
     *
     * @param int $company_id
     * @param int $count
     * @return bool
     */
    public function isBuyerAddedInventoryCount($company_id, $count)
    {
        // get the permission of the plan
        $company_plan = CompanyPlan::with('plan')->where('company_id', $company_id)
            ->where('status', CompanyPlan::STATUS_ACTIVE)->orderBy('id', 'desc')->first();
        if ($company_plan) {
            $permission = CompanyPlanPermission::where('company_id', $company_id)->first();
            // check plan download count
            $feature = json_decode($company_plan->plan->features);
            $inventory_count = $feature->inventory_count;
            if ($permission) {
                if ($permission->inventory_count < $inventory_count) {
                    $remaining_count = $inventory_count - $permission->inventory_count;
                    if ($remaining_count >= $count) {
                        $permission->inventory_count = $permission->inventory_count + $count;
                        $permission->save();
                        return ['data' => [
                            'statusCode' => __('statusCode.statusCode200'),
                            'status' => __('statusCode.status200'),
                            'message' => __('auth.downloadSuccess'),
                        ]];
                    } else {
                        return ['data' => [
                            'statusCode' => __('statusCode.statusCode422'),
                            'status' => __('statusCode.status422'),
                            'message' => __('auth.InventoryCountExceeded', ['count' => $remaining_count]),
                        ]];
                    }
                } else {
                    return ['data' => [
                        'statusCode' => __('statusCode.statusCode422'),
                        'status' => __('statusCode.status422'),
                        'message' => __('auth.InventoryCountExceeded', ['count' => 0]),
                    ]];
                }
            } else {
                return ['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => __('auth.planNotEligibleInventory'),
                ]];
            }
        } else {
            return ['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => __('auth.planNotEligibleInventory'),
            ]];
        }
    }


    /**
     * Get the buyer inventory count
     *
     * @return int
     */
    public function getMyInventoryCount()
    {
        $inventory_count = BuyerInventory::join('product_variations', 'buyer_inventories.product_id', '=', 'product_variations.id')
            ->where('buyer_inventories.buyer_id', auth()->user()->id)
            ->whereIn('product_variations.status', [ProductVariation::STATUS_ACTIVE, ProductVariation::STATUS_OUT_OF_STOCK, ProductVariation::STATUS_INACTIVE])
            ->groupBy('product_variations.product_id')
            ->select('product_variations.product_id')
            ->get()->count();
        return $inventory_count;
    }

    /**
     * Get the inventory count
     *
     * @param array $variation_ids
     * @return int
     */
    public function getInventoryCount($variation_ids)
    {
        $inventory_count = ProductVariation::whereIn('id', $variation_ids)
            ->whereIn('product_variations.status', [ProductVariation::STATUS_ACTIVE, ProductVariation::STATUS_OUT_OF_STOCK, ProductVariation::STATUS_INACTIVE])
            ->groupBy('product_variations.product_id')
            ->select('product_variations.product_id')
            ->get()->count();
        return $inventory_count;
    }
}

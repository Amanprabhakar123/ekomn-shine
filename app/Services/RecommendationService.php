<?php

namespace App\Services;

use App\Models\UserActivity;
use App\Models\ProductMatrics;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;

class RecommendationService
{

    /**
     * Get the product recommendations
     *
     * @param int $userId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecommendations($userId = null, $limit = null)
    {
        try{
            if ($userId) {
                // Fetch recommendations based on user activity
                $productIds = UserActivity::where('user_id', $userId)
                    ->select('product_id', DB::raw('count(*) as activity_count'))
                    ->groupBy('product_id')
                    ->orderBy('activity_count', 'desc');
                    if(!is_null($limit)){
                        $productIds = $productIds->limit(12);
                    }
                    $productIds = $productIds->pluck('product_id');
            } else {
                // Fetch popular products for guest users
                $productIds = ProductMatrics::select('product_id')
                    ->orderBy('view_count', 'desc')
                    ->orderBy('click_count', 'desc')
                    ->orderBy('purchase_count', 'desc');
                    if(!is_null($limit)){
                        $productIds = $productIds->limit(12);
                    }
                    $productIds = $productIds->pluck('product_id');
            }
            // Fetch the remaining products
            if (count($productIds) < $limit) {
                $remainingProductIds = $limit - count($productIds);
                $productList = ProductVariation::whereIn('product_id', function ($query) {
                    $query->selectRaw('MAX(id)')
                        ->from('product_inventories')
                        ->groupBy('product_category')
                        ->groupBy('product_subcategory');
                })->whereIn('status', [ProductVariation::STATUS_ACTIVE, ProductVariation::STATUS_OUT_OF_STOCK])
                ->whereNotIn('id', $productIds)
                ->limit($remainingProductIds)
                ->pluck('id');
                $productIds = $productIds->merge($productList);
            }
            $productList = ProductVariation::whereIn('id', $productIds)->with('media')->get();
           
            if($productList->isNotEmpty()){
                return $productList;
            }else{
                $productList = ProductVariation::whereIn('product_id', function ($query) {
                    $query->selectRaw('MAX(id)')
                        ->from('product_inventories')
                        ->groupBy('product_category')
                        ->groupBy('product_subcategory');
                })->whereIn('status', [ProductVariation::STATUS_ACTIVE, ProductVariation::STATUS_OUT_OF_STOCK])->with('media');
                if(!is_null($limit)){
                    $productList = $productList->limit($limit);
                }
                $productList = $productList->get();
                return $productList;
            }
        }catch(\Exception $e){
            throw new \Exception($e);
        }
        
    }
}

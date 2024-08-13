<?php

namespace App\Services;

use App\Models\UserActivity;
use App\Models\ProductMatrics;
use Illuminate\Support\Facades\DB;

class UserActivityService
{
    /**
     * Log the user activity
     *
     * @param int $productId
     * @param int $activityType
     * @return void
     */
    public function logActivity($productId, $activityType)
    {
        $userId = auth()->id();
        if (!$userId) {
            // Update the product metrics
            $this->updateProductMetrics($productId, $activityType);
        }else{
            // Log the activity
            UserActivity::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'activity_type' => $activityType,
            ]);
            $this->updateProductMetrics($productId, $activityType);
        }
    }

    /**
     * Update the product metrics
     *
     * @param int $productId
     * @param int $activityType
     * @return void
     */
    protected function updateProductMetrics($productId, $activityType)
    {
        $metricColumn = ProductMatrics::getActivityType($activityType) . '_count';
        ProductMatrics::updateOrCreate(
            ['product_id' => $productId],
            [$metricColumn => DB::raw("$metricColumn + 1")]
        );
    }
}
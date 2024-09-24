<?php

namespace App\Http\Controllers\Shine;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShineProduct;
use App\Models\MyShine;

class ShineController extends Controller
{
    public function shine()
    {
        if (auth()->user()->hasPermissionTo(User::PERMISSION_SHINE)) {
            return view('dashboard.admin.shine');
        }
    }

    public function fetchShineProducts()
    {
    $shineProducts = ShineProduct::withCount([
        'review as pending' => function($query) {
            $query->where('status', ShineProduct::STATUS_PENDING);
        },
        'review as inprogress' => function($query) {
            $query->where('status', ShineProduct::STATUS_INPROGRESS);
        },
        'review as order_placed' => function($query) {
            $query->where('status', ShineProduct::STATUS_ORDER_PLACED);
        },
        'review as order_confirm' => function($query) {
            $query->where('status', ShineProduct::STATUS_ORDER_CONFIRM);
        },
        'review as review_submitted' => function($query) {
            $query->where('status', ShineProduct::STATUS_REVIEW_SUBMITTED);
        },
        'review as complete' => function($query) {
            $query->where('status', ShineProduct::STATUS_COMPLETE);
        },
        'review as cancelled' => function($query) {
            $query->where('status', ShineProduct::STATUS_CANCELLED);
        },
    ])->get();

    // Calculate the combined total for inprogress, order_placed, order_confirm, and review_submitted
    $shineProducts->each(function ($product) {
        $product->inprogress_total = $product->inprogress + $product->order_placed + $product->order_confirm + $product->review_submitted;
    });

    // Calculate the overall batch status
    $batchStatuses = [];
    foreach ($shineProducts as $product) {
        if (!isset($batchStatuses[$product->batch_id])) {
            $batchStatuses[$product->batch_id] = 'Pending';
        }

        if ($product->status >= ShineProduct::STATUS_INPROGRESS && $product->status <= ShineProduct::STATUS_REVIEW_SUBMITTED) {
            $batchStatuses[$product->batch_id] = 'Inprogress';
        }
    }

    // Attach the overall batch status to each product
    $shineProducts->each(function ($product) use ($batchStatuses) {
        $product->overall_status = $batchStatuses[$product->batch_id];
    });


    return response()->json($shineProducts);
    }

    public function showBatchDetails($batch_id)
    {
    // Fetch the products with the specified batch_id
    $products = ShineProduct::where('batch_id', $batch_id)->get();

    // Pass the products to the view
    return view('dashboard.admin.batch', compact('products', 'batch_id'));
    }

    /**
     * This function is used to Show New Shine.
     * @param Request $request
     * @return void
     */
    public function newshine()
    {
        if (auth()->user()->hasPermissionTo(User::PERMISSION_SHINE)) {
            return view('dashboard.common.new_shine');
        }
    }

    /**
     * This function is used to New request.
     * @param Request $request
     * @return void
     */
    public function addShine(Request $request) {
        $shineProducts = [];
        $shineProductReviews = [];
        $userId = auth()->id(); // Get the currently authenticated user's ID
    
        $batchIds = $request->input('batchid');
        $requestNos = $request->input('request_no');
        $productNames = $request->input('product_name');
        $platforms = $request->input('platform');
        $productLinks = $request->input('product_link');
        $productIds = $request->input('product_id');
        $sellerNames = $request->input('seller_name');
        $searchTerms = $request->input('search_term');
        $amounts = $request->input('amount');
        $feedbackTitles = $request->input('feedback_title');
        $reviewRatings = $request->input('review_rating');
        $feedbackComments = $request->input('feedback_comment');
        $statuses = $request->input('status', array_fill(0, count($requestNos), 1));
    
        foreach ($requestNos as $index => $requestNo) {
            $shineProducts[] = [
                'user_id' => $userId,
                'batch_id' => $batchIds[$index],
                'request_no' => $requestNos[$index],
                'name' => $productNames[$index],
                'platform' => $platforms[$index],
                'url' => $productLinks[$index],
                'product_id' => $productIds[$index],
                'seller_name' => $sellerNames[$index],
                'search_term' => $searchTerms[$index],
                'amount' => $amounts[$index],
                'feedback_title' => $feedbackTitles[$index],
                'review_rating' => $reviewRatings[$index],
                'feedback_comment' => $feedbackComments[$index],
                'status' => $statuses[$index],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::beginTransaction();
        try {
            // Insert shine products
            ShineProduct::insert($shineProducts);
    
            // Retrieve the IDs of the inserted shine products
            $insertedShineProducts = ShineProduct::where('user_id', $userId)
                                                 ->whereIn('request_no', $requestNos)
                                                 ->get();
    
            $shineProductReviews = [];
            foreach ($insertedShineProducts as $shineProduct) {
                $shineProductReviews[] = [
                    'shine_product_id' => $shineProduct->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert reviews
            ShineProductReview::insert($shineProductReviews);
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'data' => $shineProducts
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error adding shine products and reviews: ' . $e->getMessage()
            ], 500);
        }
    }

}

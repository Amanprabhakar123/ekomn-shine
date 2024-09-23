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
        if (auth()->user()->hasRole(User::ROLE_ADMIN)) {
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

}

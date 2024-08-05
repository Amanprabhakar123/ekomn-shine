<?php

namespace App\Http\Controllers\web;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductInventory;
use App\Models\ProductVariation;

class HomeController extends Controller
{

    public function index(){
        return view('dashboard.admin.category-list');
    }


     // create Cotegory api function 
     public function getCategory(Request $request)
     {
        try {
            $categories = Category::whereIn('depth', [0, 1])
            ->where('id', '!=', 1)
            ->get();
            $priority = [1,2,3,4,5,6];

            // $TopCategory =)
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    // 'message' => __('auth.categoryCreate'),
                    'data' => $categories,
                ],
            ], __('statusCode.statusCode200'));
        

        } catch (\Exception $e) {
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    // 'message' => __('auth.categoryNotCreate'),
                ],
            ]);
        }
    }

    // create find category api function

    public function findCategory(Request $request)
    {
        try {
            // dd($request->category);
            $product_ids = ProductInventory::where('product_category', $request->category)
            ->OrWhere('product_subcategory', $request->category)
            ->groupBy('id')
            ->pluck('id');

            $product = ProductVariation::whereIn('product_id', $product_ids)->select('title', 'id')->get()->toArray();
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    // 'message' => __('auth.categoryCreate'),
                    'data' => $product,
                ],
            ], __('statusCode.statusCode200'));
        

        } catch (\Exception $e) {
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    // 'message' => __('auth.categoryNotCreate'),
                ],
            ]);
        }
    }

    // create find category by product api function

    public function findCategoryByProduct(Request $request)
    {
        try {
            // dd($request->categoryBy);
            $category = ProductVariation::where('product_id', $request->categoryBy)
            ->limit(3) // Limit the result to 2 items
            ->get();

            // dd($category);
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    // 'message' => __('auth.categoryCreate'),
                    'data' => $category,
                ],
            ], __('statusCode.statusCode200'));
        

        } catch (\Exception $e) {
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    // 'message' => __('auth.categoryNotCreate'),
                ],
            ]);
        }
    }
}

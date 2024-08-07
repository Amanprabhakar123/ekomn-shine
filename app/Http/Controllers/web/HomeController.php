<?php

namespace App\Http\Controllers\web;

use App\Models\Category;
use App\Models\TopProduct;
use App\Models\TopCategory;
use Illuminate\Http\Request;
use App\Models\TopProductTable;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use App\Http\Controllers\Controller;

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

            $topCategoryPriority = TopCategory::pluck('priority')->toArray();
            $p = array_values(array_diff($priority, $topCategoryPriority));
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    // 'message' => __('auth.categoryCreate'),
                    'data' => $categories,
                    'priority' => $p,
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

    public function productView()
    {
        return view('dashboard.admin.top-product');
    }

    // create find category by product api function

    public function getTopProduct(Request $request)
    {
        try {
            // dd($request->categoryBy);
            $product = ProductVariation::all();
             $typeProduct = TopProduct::TYPE_ARRAY;
            // dd($category);
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    // 'message' => __('auth.categoryCreate'),
                    'data' => $product,
                    'typeProduct' => $typeProduct,
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

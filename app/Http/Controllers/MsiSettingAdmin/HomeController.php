<?php

namespace App\Http\Controllers\MsiSettingAdmin;

use App\Models\User;
use App\Models\Category;
use App\Models\TopProduct;
use App\Models\TopCategory;
use Illuminate\Http\Request;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /** 
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */

     public function index()
     {
        if (!auth()->user()->hasPermissionTo(User::PERMISSION_TOP_CATEGORY)) {
            abort(403);
         }
         return view('dashboard.admin.category-list');
     }

     /**
      * Display a banner for admin view 
        *
        * @return \Illuminate\Http\Response
        */
        
        public function banner()
        {
            if (!auth()->user()->hasPermissionTo(User::PERMISSION_BANNER)) {
               abort(403);
            }
            return view('dashboard.admin.banners');
        }
 
     /**
      * get category list api function
      * 
      * @param Request $request
      * @return \Illuminate\Http\Response
      */
 
     public function getCategory(Request $request)
     {
         try {
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_TOP_CATEGORY)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
             $categories = Category::whereIn('depth', [0, 1])
                 ->where('id', '!=', 1)
                 ->get();
             $priority = [1, 2, 3, 4, 5, 6];
 
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
 
     /** create find product api function
      * 
      * @param Request $request
      * @return \Illuminate\Http\Response
      */
 
     public function findProduct(Request $request)
     {
         try {
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_TOP_PRODUCT)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
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
 
     /** create find category by product api function
      * 
      * @param Request $request
      * @return \Illuminate\Http\Response
      */
 
     public function findCategoryByProduct(Request $request)
     {
         try {

            if (! auth()->user()->hasPermissionTo(User::PERMISSION_TOP_PRODUCT)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
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
 
     /** 
      * create product add function
      * 
      * @param Request $request
      * @return \Illuminate\Http\Response
      */
 
     public function productAddView()
     {
        if (!auth()->user()->hasPermissionTo(User::PERMISSION_TOP_PRODUCT)) {
            abort(403);
         }
         return view('dashboard.admin.top-product');
     }
 
     /**
      * create top all product api function
      *
      * @param Request $request
      * @return \Illuminate\Http\Response
      */
 
     public function TopProduct(Request $request)
     {
         try {

            if (! auth()->user()->hasPermissionTo(User::PERMISSION_TOP_CATEGORY)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
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

        /**
        * create top get category by product api function
        *
        * @param Request $request
        * @return \Illuminate\Http\Response
        */

        public function getTopCategoryByProduct(Request $request){
            try{ 
               
                $topCategories = TopCategory::with('category', 'topProduct.productVarition')->get();
                // dd($topCategories);
                $transformData = $topCategories->map(function($item){
                    return [
                        'topCategoryId' => salt_encrypt($item->id),
                        'category' => $item->category->name,
                        'priority' => $item->priority,
                        'product' => $item->topProduct->map(function($product){
                            return [
                                'title' => $product->productVarition->title,
                            ];
                        })->toArray(),
                    ];

                   
                })->toArray();
                return response()->json([
                    'data' => [
                        'statusCode' => __('statusCode.statusCode200'),
                        'status' => __('statusCode.status200'),
                        'data' => $transformData,
                    ],
                ], __('statusCode.statusCode200'));
                
            }
            catch (\Exception $e) {
                dd($e);
                return response()->json([
                    'data' => [
                        'statusCode' => __('statusCode.statusCode500'),
                        'status' => __('statusCode.status500'),
                        // 'message' => __('auth.categoryNotCreate'),
                    ],
                ]);
            }
        }

        /**
         * create top product delete api function
         * 
         * @param Request $request
         * @return \Illuminate\Http\Response
         */

        public function deleteTopProduct(Request $request){
            try{
                $topProduct = TopCategory::find(salt_decrypt($request->id));
                $topProduct->delete();
                return response()->json([
                    'data' => [
                        'statusCode' => __('statusCode.statusCode200'),
                        'status' => __('statusCode.status200'),
                        'message' => __('auth.topProductDelete'),
                    ],
                ], __('statusCode.statusCode200'));
            }
            catch (\Exception $e) {
                return response()->json([
                    'data' => [
                        'statusCode' => __('statusCode.statusCode500'),
                        'status' => __('statusCode.status500'),
                        'message' => __('auth.topProductNotDelete'),
                    ],
                ]);
            }
        }
}

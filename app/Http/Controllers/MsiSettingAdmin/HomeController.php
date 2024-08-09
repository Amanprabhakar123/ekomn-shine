<?php

namespace App\Http\Controllers\MsiSettingAdmin;

use App\Events\ExceptionEvent;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use App\Models\TopCategory;
use App\Models\TopProduct;
use App\Models\User;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function getCategory(Request $request)
    {
        try {
            if (!auth()->user()->hasPermissionTo(User::PERMISSION_TOP_CATEGORY)) {
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
     * @return \Illuminate\Http\Response
     */
    public function findProduct(Request $request)
    {
        try {
            if (!auth()->user()->hasPermissionTo(User::PERMISSION_TOP_PRODUCT)) {
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
     * @return \Illuminate\Http\Response
     */
    public function findCategoryByProduct(Request $request)
    {
        try {

            if (!auth()->user()->hasPermissionTo(User::PERMISSION_TOP_PRODUCT)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            $category = ProductVariation::where('product_id', $request->categoryBy)
                ->limit(3) // Limit the result to 2 items
                ->get();
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
     * @param  Request  $request
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
     * @return \Illuminate\Http\Response
     */
    public function topProduct(Request $request)
    {
        try {

            if (!auth()->user()->hasPermissionTo(User::PERMISSION_TOP_CATEGORY)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            $product = ProductVariation::all();
            $typeProduct = TopProduct::TYPE_ARRAY;
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
     * Get a list of categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function listCategories()
    {
        try {
            // Retrieve categories with depth 0, excluding the category with id 1
            $categories = Category::where('depth', 0)
                ->where('id', '<>', 1)
                ->with(['children' => function ($query) {
                    // Retrieve immediate children with depth 1
                    $query->where('depth', 1)
                        ->with(['children' => function ($query) {
                            // Retrieve children of depth 1, which are children with depth 2
                            $query->where('depth', 2);
                        }]);
                }])
                ->limit(12)
                ->orderBy('id') // Order categories by id
                ->get(); // Execute the query and get the results

            // Transform the result into a hierarchical array
            $category = $categories->map(function ($parent) {
                return [
                    // 'parent_id' => $parent->id, // ID of the parent category
                    'parent_name' => $parent->name, // Name of the parent category
                    'parent_slug' => $parent->slug, // Slug of the parent category

                    // Map children of the parent category
                    'sub_parents' => $parent->children->map(function ($subParent) {
                        return [
                            // 'sub_parent_id' => $subParent->id, // ID of the sub-parent category
                            'sub_parent_name' => $subParent->name, // Name of the sub-parent category
                            'sub_parent_slug' => $subParent->slug, // Slug of the sub-parent category

                            // Map children of the sub-parent category
                            'children' => $subParent->children->map(function ($child) {
                                return [
                                    // 'child_id' => $child->id, // ID of the child category
                                    'child_name' => $child->name, // Name of the child category
                                    'child_slug' => $child->slug, // Slug of the child category
                                ];
                            }),
                        ];
                    }),
                ];
            });

            // Return the transformed data as a JSON response with status code 200
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'data' => $category, // Hierarchical category data
                ],
            ], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(), // Exception message
                'file' => $e->getFile(), // File where exception occurred
                'line' => $e->getLine(), // Line number where exception occurred
            ];

            // Trigger the event with exception details
            event(new ExceptionEvent($exceptionDetails));

            // Return a JSON response with error details
            return response()->json(['error' => $e->getLine() . ' ' . $e->getMessage()]);
        }
    }

    /**
     * create top get category by product api function
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function getTopCategoryByProduct(Request $request)
    {
        try {
            if (!auth()->user()->hasPermissionTo(User::PERMISSION_TOP_CATEGORY)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            $topCategories = TopCategory::with('category', 'topProduct.productVarition')->get();
            $transformData = $topCategories->map(function ($item) {
                return [
                    'topCategoryId' => salt_encrypt($item->id),
                    'category' => $item->category->name,
                    'priority' => $item->priority,
                    'product' => $item->topProduct->map(function ($product) {
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
     * create top product delete api function
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function deleteTopProduct(Request $request)
    {
        try {
            if (!auth()->user()->hasPermissionTo(User::PERMISSION_TOP_CATEGORY)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            $topProduct = TopCategory::find(salt_decrypt($request->id));
            $topProduct->delete();
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.topProductDelete'),
                ],
            ], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
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

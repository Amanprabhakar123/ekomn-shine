<?php

namespace App\Http\Controllers\MsiSettingAdmin;

use App\Events\ExceptionEvent;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use App\Models\TopCategory;
use App\Models\TopProduct;
use App\Models\User;
use Illuminate\Http\Request;
use League\Fractal\Manager;

class HomeController extends Controller
{
    /**
     * Class HomeController
     *
     * This class is responsible for handling requests related to the home page of the MsiSettingAdmin application.
     */
    protected $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! auth()->user()->hasPermissionTo(User::PERMISSION_TOP_CATEGORY)) {
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
        if (! auth()->user()->hasPermissionTo(User::PERMISSION_BANNER)) {
            abort(403);
        }

        $type = Banner::BANNER_TYPE_ARRAY;
        return view('dashboard.admin.banners', compact('type'));
    }

    /**
     * post banner api function
     * @param  Request  $request
     *  
     * @return \Illuminate\Http\Response
     */

    public function storeBanner(Request $request){
        try {
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_BANNER)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    // 'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            // dd($request->all());
            $banner = Banner::create([
                'title' => $request->title,
                'image_path' => $request->banner,
                'banner_type' => $request->banner_type,
                // 'category_id' => $request->category_id,
                // 'user_role' => $request->user_role,
            ]);

            if($banner){
                return response()->json([
                    'data' => [
                        'statusCode' => __('statusCode.statusCode200'),
                        'status' => __('statusCode.status200'),
                        // 'message' => __('auth.bannerCreate'),
                    ],
                ], __('statusCode.statusCode200'));
            }else{
                return response()->json([
                    'data' => [
                        'statusCode' => __('statusCode.statusCode422'),
                        'status' => __('statusCode.status403'),
                        // 'message' => __('auth.bannerNotCreate'),
                    ],
                ], __('statusCode.statusCode200'));
            }
        } catch (\Exception $e) {

            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            
            // Trigger the event

            // event(new ExceptionEvent($exceptionDetails));
    }

}

    /**
     * get banner api function
     *
     * @return \Illuminate\Http\Response
     */

    public function getBanner(Request $request){
        try {
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_BANNER)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    // 'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            $banner = Banner::get();

            $transformData = $banner->map(function ($item) {
                return [
                    'id' => salt_encrypt($item->id),
                    'title' => $item->title,
                    'image_path' => url($item->image_path),
                    'banner_type' => $item->getType(),
                ];
            });

            
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'data' => $transformData,
                ],
            ], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            dd($exceptionDetails);

            // Trigger the event
            // event(new ExceptionEvent($exceptionDetails));

            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    // 'message' => __('auth.categoryNotCreate'),
                ],
            ], __('statusCode.statusCode500'));
        }
    
    }
    /**
     * create banner delete api function
     *
     * @return \Illuminate\Http\Response
     */

    public function deleteBanner(Request $request){
        try {
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_BANNER)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    // 'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            $banner = Banner::find(salt_decrypt($request->id));
            $banner->delete();

            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    // 'message' => __('auth.bannerDelete'),
                ],
            ], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    // 'message' => __('auth.deleteFailed'),
                ],
            ], __('statusCode.statusCode500'));
        }
    }



    /**
     * get category list api function
     *
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
            $categories = Category::select('id', 'name')->whereIn('depth', [0, 1])
                ->where('id', '!=', 1)
                ->where('is_active', Category::IS_ACTIVE_TRUE)
                ->get();

            $categories_list = [];
            foreach ($categories as $key => $value) {
                $categories_list[$key]['id'] = salt_encrypt($value->id);
                $categories_list[$key]['name'] = $value->name;
            }
            $priority = [1, 2, 3, 4, 5, 6];

            $topCategoryPriority = TopCategory::pluck('priority')->toArray();
            $p = array_values(array_diff($priority, $topCategoryPriority));

            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    // 'message' => __('auth.categoryCreate'),
                    'data' => $categories_list,
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
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_TOP_PRODUCT)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            $product_ids = ProductInventory::where('product_category', salt_decrypt($request->category))
                ->OrWhere('product_subcategory', $request->category)
                ->groupBy('id')
                ->pluck('id');

            $product = ProductVariation::whereIn('product_id', $product_ids)
            ->where('status', ProductInventory::STATUS_ACTIVE)
            ->select('title', 'id')->get();
            $product = $product->map(function ($item) {
                return [
                    'id' => salt_encrypt($item->id),
                    'title' => $item->title,
                ];
            });

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
        if (! auth()->user()->hasPermissionTo(User::PERMISSION_TOP_PRODUCT)) {
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
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_TOP_CATEGORY)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            $product = ProductVariation::select('id', 'title')->where('status', ProductVariation::STATUS_ACTIVE)->get();
            $list = [];
            foreach ($product as $key => $value) {
                $list[$key]['id'] = salt_encrypt($value->id);
                $list[$key]['title'] = $value->title;
            }
            $typeProduct = TopProduct::TYPE_ARRAY;

            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'data' => $list,
                    'typeProduct' => $typeProduct,
                ],
            ], __('statusCode.statusCode200'));
        } catch (\Exception $e) {

            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => __('auth.categoryNotCreate'),
                ],
            ], __('statusCode.statusCode500'));
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
            return response()->json(['error' => $e->getLine().' '.$e->getMessage()]);
        }
    }

    /**
     * create top get category by product api function
     *
     * @return \Illuminate\Http\Response
     */
    public function getTopCategoryByProduct(Request $request)
    {
        try {
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_TOP_CATEGORY)) {
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
                            'slug' => url($product->productVarition->slug),
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
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => __('auth.categoryNotCreate'),
                ],
            ], __('statusCode.statusCode500'));
        }
    }

    /**
     * create top product delete api function
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteTopProduct(Request $request)
    {
        try {
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_TOP_CATEGORY)) {
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
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => __('auth.deleteFailed'),
                ],
            ], __('statusCode.statusCode500'));
        }
    }

    /**
     * create top product get data api function
     *
     * @return \Illuminate\Http\Response
     */
    public function getTopProductData(Request $request)
    {
        try {
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_TOP_CATEGORY)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            $topProduct = TopProduct::whereIn('type', TopProduct::TYPE_ARRAY_FOR_SELECT)
                ->with('productVarition')->orderBy('id', 'desc')->get();
            $transformData = $topProduct->map(function ($item) {
                return [
                    'id' => salt_encrypt($item->id),
                    'title' => $item->productVarition->title,
                    'type' => $item->getType(),
                ];
            });

            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'data' => $transformData,

                ],
            ], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => __('auth.productNotCreated'),
                ],
            ], __('statusCode.statusCode500'));
        }
    }

    /**
     * create top product delete api function
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteTopProductData(Request $request)
    {
        try {
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_TOP_CATEGORY)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            $topProduct = TopProduct::find(salt_decrypt($request->id));
            $topProduct->delete();

            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                ],
            ], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => __('auth.deleteFailed'),
                ],
            ], __('statusCode.statusCode500'));
        }

    }
}

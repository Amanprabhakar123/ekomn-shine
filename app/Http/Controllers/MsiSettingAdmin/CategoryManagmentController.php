<?php

namespace App\Http\Controllers\MsiSettingAdmin;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Events\ExceptionEvent;
use App\Http\Controllers\Controller;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Validator;
use App\Transformers\CategoryManagementTransformer;

class CategoryManagmentController extends Controller
{
    protected $fractal;
    protected $CategoryManagementTransform;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * display the MIS settings
     *  
     * @return \Illuminate\View\View
     */

    public function misSettingInventory()
    {
        return view('dashboard.admin.category-management');
    }

    /**
     * retrive the pafinated category list
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function misCategories(Request $request)
    {
        if(auth()->user()->hasRole(User::PERMISSION_MIS_SETTING_INVENTORY)){
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode403'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.permissionDenied'),
                ],
            ], __('statusCode.statusCode403'));
        }
        try {
            $perPage = $request->input('per_page', 10);
            $search = $request->input('query', null);
            //
            if($search){
                $categories = Category::query()->where('name', 'like', '%' . $search . '%')
                ->where('id', '!=', 1)
                ->orderBy('id', 'desc')
                ->paginate($perPage);
            }else{
                $categories = Category::query()
                ->where('id', '!=', 1)
                ->orderBy('id', 'desc')
                ->paginate($perPage);
            }
            $resource = new Collection($categories, new CategoryManagementTransformer);

            $resource->setPaginator(new \League\Fractal\Pagination\IlluminatePaginatorAdapter($categories));

            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
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
     * add new category view
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCategoryView()
    {
        if(auth()->user()->hasRole(User::PERMISSION_MIS_SETTING_INVENTORY)){
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode403'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.permissionDenied'),
                ],
            ], __('statusCode.statusCode403'));
        }
        return view('dashboard.admin.add-category');
    }

    /**
     * update category status active/inactive
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCategoryStatus(Request $request)
    {
        if(auth()->user()->hasRole(User::PERMISSION_MIS_SETTING_INVENTORY)){
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode403'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.permissionDenied'),
                ],
            ], __('statusCode.statusCode403'));
        }
        try {
            $category = Category::find(salt_decrypt($request->input('id')));
            $category->is_active = !$category->is_active;
            $category->save();
            return response()->json([
                'data' =>
                [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.categoryStatus'),
                ]
            ]);
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
     * store the category
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCategory(Request $request)
    {
        if(auth()->user()->hasRole(User::PERMISSION_MIS_SETTING_INVENTORY)){
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode403'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.permissionDenied'),
                ],
            ], __('statusCode.statusCode403'));
        }
        $validator = Validator::make($request->all(), [
            'categoryName' => 'required',
            'categoryTree' => 'required',
            'subCategory' => 'required',
            'childCategory' => 'required',
            'keywordName' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ],
            ], __('statusCode.statusCode422'));
        }


        try {
            if ($request->categoryTree == 0) {
                $parent_category = [
                    'name' => $request->input('categoryName'),
                    'slug' => Str::slug($request->input('categoryName')),
                    'depth' => 0,
                    'parent_id' => 0,
                    'root_parent_id' => 0,
                    'is_active' => true,
                ];
                // dd($parent_category);
                $category = Category::create($parent_category);

                $sub_category = [
                    'name' => $request->input('subCategory'),
                    'slug' => Str::slug($request->input('subCategory')),
                    'depth' => 1,
                    'parent_id' => $category->id,
                    'root_parent_id' => $category->id,
                    'is_active' => true,
                ];

                $category = Category::create($sub_category);

                $sub_sub_category = [
                    'name' => $request->input('childCategory'),
                    'slug' => Str::slug($request->input('childCategory')),
                    'depth' => 2,
                    'parent_id' => $category->id,
                    'root_parent_id' => $category->root_parent_id,
                    'is_active' => true,
                ];

                $category = Category::create($sub_sub_category);

                // explode the keyword
                $keywords = explode(',', $request->input('keywordName'));
                foreach ($keywords as $keyword) {
                    $keyword = [
                        'name' => $keyword,
                        'slug' => Str::slug($keyword),
                        'depth' => 3,
                        'parent_id' => $category->id,
                        'root_parent_id' => $category->root_parent_id,
                        'is_active' => true,
                    ];
                    $category = Category::create($keyword);
                }
            } elseif ($request->categoryTree == 1) {
                $categories = Category::find(salt_decrypt($request->categoryName));

                $sub_category = [
                    'name' => $request->input('subCategory'),
                    'slug' => Str::slug($request->input('childCategory')),
                    'depth' => 1,
                    'parent_id' => $categories->id,
                    'root_parent_id' => $categories->id,
                    'is_active' => true,
                ];

                $category = Category::create($sub_category);

                $child_category = [
                    'name' => $request->input('childCategory'),
                    'slug' => Str::slug($request->input('childCategory')),
                    'depth' => 2,
                    'parent_id' => $category->id,
                    'root_parent_id' => $categories->id,
                    'is_active' => true,
                ];

                $category = Category::create($child_category);

                $keyword = explode(',', $request->input('keywordName'));
                foreach ($keyword as $key) {
                    $keyword = [
                        'name' => $key,
                        'slug' => Str::slug($key),
                        'depth' => 3,
                        'parent_id' => $category->id,
                        'root_parent_id' => $categories->id,
                        'is_active' => true,
                    ];
                    $category = Category::create($keyword);
                }
            } elseif ($request->categoryTree == 2) {

                $p_categories = Category::find(salt_decrypt($request->categoryName));
                $s_categories = Category::find(salt_decrypt($request->subCategory));

                $child_category = [
                    'name' => $request->input('childCategory'),
                    'slug' => Str::slug($request->input('childCategory')),
                    'depth' => 2,
                    'parent_id' => $s_categories->id,
                    'root_parent_id' => $p_categories->id,
                    'is_active' => true,
                ];

                $category = Category::create($child_category);

                $keyword = explode(',', $request->input('keywordName'));
                foreach ($keyword as $key) {
                    $keyword = [
                        'name' => $key,
                        'slug' => Str::slug($key),
                        'depth' => 3,
                        'parent_id' => $s_categories->id,
                        'root_parent_id' => $p_categories->id,
                        'is_active' => true,
                    ];
                    $category = Category::create($keyword);
                }
            } elseif ($request->categoryTree == 3) {

                $p_categories = Category::find(salt_decrypt($request->categoryName));
                $s_categories = Category::find(salt_decrypt($request->subCategory));
                $keyword = explode(',', $request->input('keywordName'));
                foreach ($keyword as $key) {
                    $keyword = [
                        'name' => $key,
                        'slug' => Str::slug($key),
                        'depth' => 3,
                        'parent_id' => $s_categories->id,
                        'root_parent_id' => $p_categories->id,
                        'is_active' => true,
                    ];
                    $category = Category::create($keyword);
                }
            }

            return response()->json([
                'data' =>
                [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.categoryAdded'),
                ]
            ]);
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
                    'message' => __('auth.categoryFailed'),
                ],
            ], __('statusCode.statusCode500'));
        }
    }

    /**
     * edit category view
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function editCategoryView(Request $request, $id){
        if(auth()->user()->hasRole(User::PERMISSION_MIS_SETTING_INVENTORY)){
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode403'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.permissionDenied'),
                ],
            ], __('statusCode.statusCode403'));
        }
        $category = Category::find(salt_decrypt($id));
        $depth = $request->input('depth');
        
        $data = $category->depth;
        // dd($data);

        return view('dashboard.admin.edit-category-management', compact('category', 'depth'));
    }

    /**
     * update category
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCategory(Request $request){
        if(auth()->user()->hasRole(User::PERMISSION_MIS_SETTING_INVENTORY)){
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode403'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.permissionDenied'),
                ],
            ], __('statusCode.statusCode403'));
        }
        $validator = Validator::make($request->all(), [
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ],
            ], __('statusCode.statusCode422'));
        }

        try {
            $category = Category::find(salt_decrypt($request->input('id')));
            $category->name = $request->input('category');
            $category->slug = Str::slug($request->input('category'));
            $category->save();

            return response()->json([
                'data' =>
                [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.categoryUpdated'),
                ]
            ]);
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
                    'message' => __('auth.categoryFailed'),
                ],
            ], __('statusCode.statusCode500'));
        }
    }
}

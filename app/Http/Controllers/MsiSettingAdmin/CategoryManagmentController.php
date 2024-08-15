<?php

namespace App\Http\Controllers\MsiSettingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use League\Fractal\Manager;
use App\Transformers\CategoryManagementTransform;
use League\Fractal\Resource\Collection;
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
        try {
            $perPage = $request->input('per_page', 10);
            $categories = Category::query()->paginate($perPage);
            
            $resource = new Collection($categories, new CategoryManagementTransform);
            
            $resource->setPaginator(new \League\Fractal\Pagination\IlluminatePaginatorAdapter($categories));

            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
            dd($e);
        }
    }

    /**
     * add new category view
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function addCategoryView(Request $request){
        return view('dashboard.admin.add-category');
    }

    /**
     * update category status active/inactive
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function updateCategoryStatus(Request $request){
        try {
            $category = Category::find(salt_decrypt($request->input('id')));
            $category->is_active = !$category->is_active;
            $category->save();
            return response()->json(['data' => 
            [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.categoryStatus'),
            ]
        ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    

}

<?php

namespace App\Http\Controllers\MsiSettingAdmin;

use App\Models\Category;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Events\ExceptionEvent;
use App\Http\Controllers\Controller;
use League\Fractal\Resource\Collection;
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
        try {
            $perPage = $request->input('per_page', 10);
            $categories = Category::query()->paginate($perPage);

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
}

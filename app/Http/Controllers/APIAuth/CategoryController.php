<?php

namespace App\Http\Controllers\APIAuth;

use App\Events\ExceptionEvent;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TopCategory;
use App\Models\TopProduct;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Find a category based on the provided tags.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the category details.
     */
    public function findCategory(Request $request)
    {
        try {
            // Get the comma-separated tags from input
            $tags = explode(',', $request->input('tags'));
            if (! empty($tags)) {
                $tags = array_map('trim', $tags); // Trim whitespace from each tag
                $tags = array_map('strtolower', $tags); // Convert tags to lowercase
                $tags = array_map(function ($tag) {
                    return str_replace(' ', '-', $tag);
                }, $tags); // Replace spaces with hyphens
            }
            $categoryService = new CategoryService();
            $categoryDetails = $categoryService->searchCategory($tags);

            return response()->json(['data' => $categoryDetails]);
        } catch (\Exception $e) {

            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            return response()->json(['error' => $e->getLine().' '.$e->getMessage()]);
        }
    }

    /**
     * Store a new category.
     *
     * This method is responsible for storing a new category along with its associated products.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function storeCategory(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'number' => 'required',
                'category' => 'required',
                'productBy' => 'required',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode200'));
            }

            // Define priority values
            $priority = [1, 2, 3, 4, 5, 6];

            // Get the number and productBy values from the request
            $number = $request->input('number');
            $product = $request->input('productBy');

            // Split the productBy value into an array
            $product = explode(',', $product);

            // Create a new TopCategory instance
            $category = new TopCategory;
            $category->category_id = $request->input('category');
            $category->priority = $number;
            $category->save();

            // Check if the category is saved successfully
            if ($category) {
                // Loop through each product and save it as a TopProduct
                foreach ($product as $key => $value) {
                    $productCategory = new TopProduct;
                    $productCategory->product_id = $value;
                    $productCategory->priority = $key + 1;
                    $productCategory->category_id = $category->id;
                    $productCategory->save();
                }

                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.categoryAdded'),
                ]], __('statusCode.statusCode200'));
            } else {
                return response()->json(['data' => __('auth.categoryFailed')], __('statusCode.statusCode404'));
            }
        } catch (\Exception $e) {
            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            return response()->json(['error' => $e->getLine().' '.$e->getMessage()]);
        }

    }
}

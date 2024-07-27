<?php

namespace App\Http\Controllers\APIAuth;

use App\Events\ExceptionEvent;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

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
            $message = $e->getMessage(); // Get the error message
            $file = $e->getFile(); // Get the file
            $line = $e->getLine(); // Get the line number where the exception occurred
            event(new ExceptionEvent($message, $line, $file)); // Trigger an event with exception details

            return response()->json(['error' => $e->getLine().' '.$e->getMessage()]);
        }
    }
}

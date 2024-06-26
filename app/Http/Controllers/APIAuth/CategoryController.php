<?php

namespace App\Http\Controllers\APIAuth;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Find a category based on the provided tags.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the category details.
     */
    public function findCategory(Request $request)
    {
        // Get the comma-separated tags from input
        $tags = explode(',', $request->input('tags'));
        $tags = array_map('trim', $tags); // Trim whitespace from each tag

        $categoryDetails = $this->searchCategory($tags);

        return response()->json(['data' => $categoryDetails]);
    }


    /**
     * Search for a category based on tags.
     *
     * @param array $tags The tags to search for.
     * @return array The main category and sub category found based on the tags.
     */
    private function searchCategory(array $tags)
    {
        // Generate all combinations of tags
        $combinations = $this->generateCombinations($tags);

        foreach ($combinations as $combination) {
            list($tag1, $tag2) = $combination;

            // Search in the database using LIKE query for these tags
            $category1 = Category::where('name', 'LIKE', "%$tag1%")->first();
            $category2 = Category::where('name', 'LIKE', "%$tag2%")->first();

            if ($category1 && $category2) {
                // Check if they share the same root parent category
                if ($category1->root_parent_id == $category2->root_parent_id) {
                    $mainCategory = Category::where('id', $category1->root_parent_id)->first();
                    $subCategory = $category1->id == $mainCategory->id ? $category2 : $category1;

                    $mainCategoryName = $mainCategory->name ?? $tag1;
                    $subCategoryName = $subCategory->name ?? $tag2;

                    // If sub category is "unknown", use main category name
                    if ($subCategoryName === 'unknown') {
                        $subCategoryName = $mainCategoryName;
                    }

                    $data = [
                        'main_category' => $mainCategoryName,
                        'sub_category' => $subCategoryName
                    ];

                    return [
                        'statusCode' => __('statusCode.statusCode200'),
                        'status' => true,
                        'result' => $data
                    ];
                }
            }
        }

        // Check if the any one  tag has a matching main category
        foreach ($tags as $firstTag) {
            $firstTagCategory = Category::where('name', 'LIKE', "%$firstTag%")->first();

            if ($firstTagCategory) {
                $mainCategoryName = $firstTagCategory->name ?? 'unknown';

                $data = [
                    'main_category' => $mainCategoryName,
                    'sub_category' => $mainCategoryName // Use main category name if sub category is unknown
                ];

                return [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => true,
                    'result' => $data
                ];
            }
        }

        // Return "no data found" if no matches found


        return [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => false,
            'result' => ['message' => 'no data found']
        ];
    }

    /**
     * Generate all combinations of tags.
     *
     * @param array $tags The tags to generate combinations from.
     * @return array The generated combinations of tags.
     */
    private function generateCombinations(array $tags)
    {
        $combinations = [];
        $count = count($tags);

        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                $combinations[] = [$tags[$i], $tags[$j]];
            }
        }

        return $combinations;
    }
}

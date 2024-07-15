<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{

    /**
     * Search for a category based on tags.
     *
     * @param array $tags The tags to search for.
     * @return array The main category and sub category found based on the tags.
     */
    public function searchCategory(array $tags)
    {
        // Generate all combinations of tags
        $combinations = $this->generateCombinations($tags);

        if (!empty($combinations)) {
            foreach ($combinations as $combination) {
                list($tag1, $tag2) = $combination;

                // Search in the database using LIKE query for these tags
                $category1 = Category::where('slug', 'LIKE', "%$tag1%")->first();
                $category2 = Category::where('slug', 'LIKE', "%$tag2%")->first();

                if ($category1 && $category2) {
                    // Check if they share the same root parent category
                    if ($category1->root_parent_id == $category2->root_parent_id) {
                        $mainCategory = Category::where('id', $category1->root_parent_id)->first();
                        if (!$mainCategory) {
                            $mainCategory = $category1;
                        }
                        $subCategory = $category1->id == $mainCategory->id ? $category2 : $category1;

                        $mainCategoryName = $mainCategory->name ?? $tag1;
                        $mainCategoryId = $mainCategory->id ?? 0;
                        $subCategoryName = $subCategory->name ?? $tag2;
                        $subCategoryId = $subCategory->id ?? 0;

                        // If sub category is "unknown", use main category name
                        if ($subCategoryName === 'unknown') {
                            $subCategoryName = $mainCategoryName;
                        }

                        $data = [
                            'main_category' => $mainCategoryName,
                            'main_category_id' => salt_encrypt($mainCategoryId),
                            'sub_category' => $subCategoryName,
                            'sub_category_id' => salt_encrypt($subCategoryId),
                        ];

                        return [
                            'statusCode' => __('statusCode.statusCode200'),
                            'status' => true,
                            'result' => $data
                        ];
                    }
                }
            }
        }

        // Check if the any one  tag has a matching main category
        foreach ($tags as $firstTag) {
            if (!empty($firstTag)) {
                $firstTagCategory = Category::where('slug', 'LIKE', "%$firstTag%")->first();
                if ($firstTagCategory) {
                    if ($firstTagCategory->root_parent_id) {
                        $rootParentCategory = Category::where('id', $firstTagCategory->root_parent_id)->first();
                        $mainCategoryName = $rootParentCategory->name ?? 'unknown';
                        $mainCategoryId = $rootParentCategory->id ?? 0;
                        $subCategoryName = $firstTagCategory->name ?? 'unknown';
                        $subCategoryId = $firstTagCategory->id ?? 0;
                    } else {
                        $mainCategoryName = $firstTagCategory->name ?? 'unknown';
                        $mainCategoryId = $firstTagCategory->id ?? 0;
                        $subCategoryName = $mainCategoryName;
                        $subCategoryId = $mainCategoryId;
                    }
                    $data = [
                        'main_category' => $mainCategoryName,
                        'main_category_id' => salt_encrypt($mainCategoryId),
                        'sub_category' => $subCategoryName,
                        'sub_category_id' => salt_encrypt($subCategoryId),
                    ];
                    return [
                        'statusCode' => __('statusCode.statusCode200'),
                        'status' => true,
                        'result' => $data
                    ];
                }
            }
        }

        // Return "no data found" if no matches found

        $firstUnknownCategory = Category::where('id', 1)->first();

        if ($firstUnknownCategory) {
            $mainCategoryName = $firstUnknownCategory->name ?? 'unknown';
            $mainCategoryId = $firstUnknownCategory->id ?? 0;

            $data = [
                'main_category' => $mainCategoryName,
                'main_category_id' => salt_encrypt($mainCategoryId),
                'sub_category' => $mainCategoryName, // Use main category name if sub category is unknown
                'sub_category_id' => salt_encrypt($mainCategoryId),
            ];

            return [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => true,
                'result' => $data
            ];
        }
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

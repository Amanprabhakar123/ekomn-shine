<?php

namespace App\Services;

use App\Models\Category;
use App\Models\ProductInventory;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    /**
     * Search for a category based on tags.
     *
     * @param  array  $tags  The tags to search for.
     * @return array The main category and sub category found based on the tags.
     */
    public function searchCategory(array $tags)
    {
        // Generate all combinations of tags
        $combinations = $this->generateCombinations($tags);
        try {
            if (! empty($combinations)) {
                foreach ($combinations as $combination) {
                    [$tag1, $tag2] = $combination;

                    // Search in the database using LIKE query for these tags
                    $category1 = Category::where('slug', 'LIKE', "%$tag1%")->where('is_active', Category::IS_ACTIVE_TRUE)->first();
                    $category2 = Category::where('slug', 'LIKE', "%$tag2%")->where('is_active', Category::IS_ACTIVE_TRUE)->first();

                    if ($category1 && $category2) {
                        if ($category1->depth === 3 && $category2->depth === 2) {
                            $rootParentCategory1 = Category::where('id', $category1->root_parent_id)->where('is_active', Category::IS_ACTIVE_TRUE)->first();
                            $parentCategory1 = Category::where('id', $category1->parent_id)->where('is_active', Category::IS_ACTIVE_TRUE)->first();
                            $rootParentCategory2 = Category::where('id', $category2->root_parent_id)->where('is_active', Category::IS_ACTIVE_TRUE)->first();
                            // $parentCategory2 = Category::where('id', $category2->parent_id)->first();

                            $mainCategoryName = $rootParentCategory1->name ?? 'unknown';
                            $mainCategoryId = $rootParentCategory1->id ?? 0;
                            $subCategoryName = $parentCategory1->name ?? 'unknown';
                            $subCategoryId = $parentCategory1->id ?? 0;

                            // Check if both categories share the same root parent category and parent category
                            if ($rootParentCategory1->id === $rootParentCategory2->id) {
                                $mainCategoryName = $rootParentCategory1->name ?? 'unknown';
                                $mainCategoryId = $rootParentCategory1->id ?? 0;
                                $subCategoryName = $parentCategory1->name ?? 'unknown';
                                $subCategoryId = $parentCategory1->id ?? 0;
                            }

                            return $this->categoryData($mainCategoryName, $mainCategoryId, $subCategoryName, $subCategoryId);
                        } elseif ($category1->depth === 1) {
                            if ($category1->root_parent_id === null) {
                                $mainCategoryName = $category1->name ?? 'unknown';
                                $mainCategoryId = $category1->id ?? 0;
                                $subCategoryName = $mainCategoryName;
                                $subCategoryId = $mainCategoryId;
                            } else {
                                $rootParentCategory1 = Category::where('id', $category1->root_parent_id)->where('is_active', Category::IS_ACTIVE_TRUE)->first();
                                $mainCategoryName = $rootParentCategory1->name ?? 'unknown';
                                $mainCategoryId = $rootParentCategory1->id ?? 0;
                                $subCategoryName = $category1->name ?? 'unknown';
                                $subCategoryId = $category1->id ?? 0;
                            }

                            return $this->categoryData($mainCategoryName, $mainCategoryId, $subCategoryName, $subCategoryId);
                        } elseif ($category1->depth === 0) {
                            $mainCategoryName = $category1->name ?? 'unknown';
                            $mainCategoryId = $category1->id ?? 0;
                            $subCategoryName = $mainCategoryName;
                            $subCategoryId = $mainCategoryId;

                            return $this->categoryData($mainCategoryName, $mainCategoryId, $subCategoryName, $subCategoryId);
                        }
                    }
                }
            }

            // Check if the any one  tag has a matching main category
            foreach ($tags as $firstTag) {
                if (! empty($firstTag)) {
                    $firstTagCategory = Category::where('slug', 'LIKE', "%$firstTag%")->where('is_active', Category::IS_ACTIVE_TRUE)->first();
                    //i want to update this logic if $category1->depth === 3 and $category1->depth === 2 i want to check root_parent_id and parent_id data root_parent_id is main category and parent_id is sub category another case if $category1->depth === 1 i want to check root_parent_id if root_parent_id is null then i want to set main category and sub category is same if $category1->depth === 0 i want to set main category and sub category is same and same for $category2

                    if ($firstTagCategory) {
                        if ($firstTagCategory->depth === 3 || $firstTagCategory->depth === 2) {
                            $rootParentCategory = Category::where('id', $firstTagCategory->root_parent_id)->where('is_active', Category::IS_ACTIVE_TRUE)->first();
                            $parentCategory = Category::where('id', $firstTagCategory->parent_id)->where('is_active', Category::IS_ACTIVE_TRUE)->first();
                            $mainCategoryName = $rootParentCategory->name ?? 'unknown';
                            $mainCategoryId = $rootParentCategory->id ?? 0;
                            $subCategoryName = $parentCategory->name ?? 'unknown';
                            $subCategoryId = $parentCategory->id ?? 0;

                            return $this->categoryData($mainCategoryName, $mainCategoryId, $subCategoryName, $subCategoryId);
                        } elseif ($firstTagCategory->depth === 1) {
                            if ($firstTagCategory->root_parent_id === null) {
                                $mainCategoryName = $firstTagCategory->name ?? 'unknown';
                                $mainCategoryId = $firstTagCategory->id ?? 0;
                                $subCategoryName = $mainCategoryName;
                                $subCategoryId = $mainCategoryId;
                            } else {
                                $rootParentCategory = Category::where('id', $firstTagCategory->root_parent_id)->where('is_active', Category::IS_ACTIVE_TRUE)->first();
                                $mainCategoryName = $rootParentCategory->name ?? 'unknown';
                                $mainCategoryId = $rootParentCategory->id ?? 0;
                                $subCategoryName = $firstTagCategory->name ?? 'unknown';
                                $subCategoryId = $firstTagCategory->id ?? 0;
                            }

                            return $this->categoryData($mainCategoryName, $mainCategoryId, $subCategoryName, $subCategoryId);
                        } elseif ($firstTagCategory->depth === 0) {
                            $mainCategoryName = $firstTagCategory->name ?? 'unknown';
                            $mainCategoryId = $firstTagCategory->id ?? 0;
                            $subCategoryName = $mainCategoryName;
                            $subCategoryId = $mainCategoryId;

                            return $this->categoryData($mainCategoryName, $mainCategoryId, $subCategoryName, $subCategoryId);
                        }
                    }
                }
            }

            // Return "no data found" if no matches found

            $firstUnknownCategory = Category::where('id', 1)->where('is_active', Category::IS_ACTIVE_TRUE)->first();

            if ($firstUnknownCategory) {
                $mainCategoryName = $firstUnknownCategory->name ?? 'unknown';
                $mainCategoryId = $firstUnknownCategory->id ?? 0;

                return $this->categoryData($mainCategoryName, $mainCategoryId, $mainCategoryName, $mainCategoryId);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Generate all combinations of tags.
     *
     * @param  array  $tags  The tags to generate combinations from.
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

    /**
     * Generate category data.
     *
     * @param  string  $mainCategoryName  The main category name.
     * @param  int  $mainCategoryId  The main category ID.
     * @param  string  $subCategoryName  The sub category name.
     * @param  int  $subCategoryId  The sub category ID.
     * @return array The generated category data.
     */
    private function categoryData($mainCategoryName = 'unknown', $mainCategoryId = 1, $subCategoryName = 'unknown', $subCategoryId = 1)
    {
        $data = [
            'main_category' => $mainCategoryName,
            'main_category_id' => salt_encrypt($mainCategoryId),
            'sub_category' => $subCategoryName,
            'sub_category_id' => salt_encrypt($subCategoryId),
        ];

        return [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => true,
            'result' => $data,
        ];
    }

    /**
     * Get category by slug.
     *
     * @param  string  $slug  The slug to search for.
     * @return array The category data based on the slug.
     */
    public function getCategoryBySlug($slug)
    {
        try {
            // Find the category based on the slug
            $category = Category::select('name', 'slug', 'root_parent_id', 'id')->where('slug', $slug)->where('is_active', Category::IS_ACTIVE_TRUE)->firstOrFail();

            // Initialize a collection to hold relevant categories
            $categories = collect();

            // Fetch categories based on the depth of the current category
            if ($category->depth == 0) {
                // If the category is at depth 0, get all its children (depth 1 and 2)
                $categories = $category->children()->with('children')->get();
            } elseif ($category->depth == 1) {
                // If the category is at depth 1, get only its direct children (depth 2)
                $categories = $category->children()->get();
            } elseif ($category->depth == 2) {
                // If the category is at depth 2, only the category itself is relevant
                $categories->push($category);
            }

            // Add the original category itself to the collection
            $categories->prepend($category);

            // Get all the relevant category IDs
            $categoryIds = $categories->pluck('id');

            // Retrieve product IDs from the ProductInventory table based on category associations
            $productIds = ProductInventory::distinct('id')->whereIn('product_category', $categoryIds)
                ->orWhereIn('product_subcategory', $categoryIds)
                ->pluck('id');
            $data = [
                'categories' => $categories,
                'category' => $category->slug,
                'productIds' => $productIds,
            ];

            // Return the category data
            return [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => true,
                'result' => $data,
            ];
        } catch (\Exception $e) {
            return [
                'statusCode' => __('statusCode.statusCode404'),
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}

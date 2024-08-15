<?php
namespace App\Transformers;

use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;
use App\Models\Category;


class CategoryManagementTransform extends TransformerAbstract
{
    /**
     * Transform the given Category model into a formatted array.
     *
     * @param  Category  $category
     * @return array
     */
    public function transform(Category $category)
    {
        try {
            $data = [
                'id' => salt_encrypt($category->id),
                'name' => $category->name,
                'slug' => $category->slug,
                'is_active' => $category->is_active,
                'created_at' => $category->created_at->toDateTimeString(),
                'updated_at' => $category->updated_at->toDateTimeString(),
            ];
            return $data;
        } catch (\Exception $e) {
            Log::error('Error in CategoryManagementTransform: ' . $e->getMessage());
            return [];
        }
    }
}

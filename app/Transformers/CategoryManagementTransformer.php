<?php
namespace App\Transformers;

use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;
use App\Models\Category;


class CategoryManagementTransformer extends TransformerAbstract
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
                'edit' => route('admin.categories.edit', salt_encrypt($category->id)).'?depth='.$category->depth,
                'is_active' => $category->is_active,
                'depth' => $category->depthName,
                'created_at' => $category->created_at->toDateTimeString(),
                'updated_at' => $category->updated_at->toDateTimeString(),
            ];
            if($category->depth == 0){
                $data['parent'] = 'Main Category';
            }
            if($category->depth == 1){
                $data['parent'] = $category->parent->name.' < '.$category->name;
            }
            if($category->depth == 2){
                $data['parent'] = $category->parent->parent->name.' < '.$category->parent->name.' < '.$category->name;
            }
            if($category->depth == 3){
                $data['parent'] = $category->parent->parent->name.' < '.$category->parent->name.' < '.$category->name;
            }
            return $data;
        } catch (\Exception $e) {
            Log::error('Error in CategoryManagementTransform: ' . $e->getMessage());
            throw $e;
        }
    }
}

<?php
namespace App\Transformers;
use App\Models\ProductInventory;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(ProductInventory $user)
    {
        return [
            'id' => (int) $user->id,
            'select' => (int) $user->select,
            'product_image' => (int) $user->product_image,
            'title' => $user->title,
            'sku' => $user->sku,
            'product_id' => $user->product_id,
            'stock' => $user->stock,
            'selling_price' => $user->selling_price,
            'product_category' => $user->product_category,
            'availability_status' => $user->availability_status,
            'status' => $user->status,
            'action' => $user->action,
            'created_at' => $user->created_at->toIso8601String(),
            'updated_at' => $user->updated_at->toIso8601String(),
        ];
    }
}

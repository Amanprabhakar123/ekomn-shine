<?php
namespace App\Transformers;
use App\Models\ProductInventory;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Transform the given ProductInventory model into a formatted array.
     *
     * @param  ProductInventory  $product
     * @return array
     */
    public function transform(ProductInventory $product)
    {
        return [
            'id' => (int) $product->id,
            'select' => (int) $product->select,
            'product_image' => (int) $product->product_image,
            'title' => $product->title,
            'sku' => $product->sku,
            'product_id' => $product->product_id,
            'stock' => $product->stock,
            'selling_price' => $product->selling_price,
            'product_category' => $product->product_category,
            'availability_status' => $product->availability_status,
            'status' => $product->status,
            'action' => $product->action,
            'created_at' => $product->created_at->toDateTimeString(),
            'updated_at' => $product->updated_at->toDateTimeString(),
        ];
    }
}

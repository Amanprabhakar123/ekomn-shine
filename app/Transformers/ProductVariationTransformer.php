<?php
namespace App\Transformers;
use App\Models\User;
use App\Models\ProductVariation;
use League\Fractal\TransformerAbstract;

class ProductVariationTransformer extends TransformerAbstract
{
    /**
     * Transform the given ProductVariation model into a formatted array.
     *
     * @param  ProductVariation  $product
     * @return array
     */
    public function transform(ProductVariation $product)
    {
        try {
            $data = [
                'id' => salt_encrypt($product->id),
                'product_image' => $product->media->first() ? $product->media->first()->thumbnail_path : 'https://via.placeholder.com/640x480.png/0044ff?text=at',
                'title' => $product->title,
                'sku' => $product->sku,
                'product_id' => $product->product_slug_id,
                'stock' => $product->stock,
                'selling_price' => $product->price_before_tax,
                'product_category' => $product->product->category->name,
                'availability_status' => getAvailablityStatusName($product->availability_status),
                'status' => getStatusName($product->status),
                'action' => $product->id,
                'created_at' => $product->created_at->toDateTimeString(),
                'updated_at' => $product->updated_at->toDateTimeString(),
            ];

            if(auth()->user()->hasRole(User::ROLE_ADMIN)){
                $data['supplier_id'] = $product->product->company->company_serial_id;
            }
            return $data;
        } catch (\Exception $e) {
            // Handle the exception here
            // You can log the error, return a default value, or throw a custom exception
            // For example, you can log the error and return an empty array
            \Log::error('Error transforming ProductInventory: ' . $e->getMessage());
            return [];
        }
    }
}

<?php
namespace App\Transformers;
use App\Models\User;
use App\Models\ProductVariation;
use App\Models\ProductVariationMedia;
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
            $media = $product->media->where('is_master', ProductVariationMedia::IS_MASTER_TRUE)->first();
            if($media == null){
                $thumbnail = 'https://via.placeholder.com/640x480.png/0044ff?text=at';
            }else{
                $thumbnail  = $media->thumbnail_path;
            }
            $data = [
                'id' => salt_encrypt($product->id),
                'product_image' => $thumbnail,
                'title' => $product->title,
                'link' => route('product.details', $product->slug),
                'sku' => $product->sku,
                'product_id' => $product->product_slug_id,
                'stock' => $product->stock,
                'selling_price' => $product->price_before_tax,
                'product_category' => $product->product->category->name,
                'availability_status' => getAvailablityStatusName($product->availability_status),
                'status' => getStatusName($product->status),
                'allow_editable' => $product->allow_editable,
                'action' => $product->id,
                'created_at' => $product->created_at->toDateTimeString(),
                'updated_at' => $product->updated_at->toDateTimeString(),
                'editInventory' => route('edit.inventory', ['variation_id' => salt_encrypt($product->id)]),
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

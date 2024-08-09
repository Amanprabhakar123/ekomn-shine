<?php
namespace App\Transformers;
use App\Models\User;
use App\Models\BuyerInventory;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class BuyerInventoryTransformer extends TransformerAbstract
{
    /**
     * Transform the given BuyerInventory model into a formatted array.
     *
     * @param  BuyerInventory  $buyerInventory
     * @return array
     */
    public function transform(BuyerInventory $buyerInventory)
    {
        try {
            
            $product = $buyerInventory->product;
            $media = $product->media->where('is_master', 1)->first();
            if($media == null){
                $thumbnail = 'https://via.placeholder.com/640x480.png/0044ff?text=at';
            }else{
                $thumbnail  = $media->thumbnail_path;
            }
            $live = false;
            if($product->salesChannelProductMaps->isNotEmpty()){
                $live = true;
            }
            $data = [
                'id' => salt_encrypt($buyerInventory->id),
                'product_image' => $thumbnail,
                'title' => $product->title,
                'link' => url($product->slug),
                'sku' => $product->sku,
                'product_id' => $product->product_slug_id,
                'stock' => $product->stock,
                'selling_price' => $product->price_before_tax,
                'product_category' => $product->product->category->name,
                'variation_id' => salt_encrypt($product->id),
                'availability_status' => getAvailablityStatusName($product->availability_status),
                'status' => getStatusName($product->status),
                'live' => $live,
                'created_at' => $buyerInventory->created_at->toDateTimeString(),
                'updated_at' => $buyerInventory->updated_at->toDateTimeString(),
            ];
            return $data;
        } catch (\Exception $e) {
            // Handle the exception here
            // You can log the error, return a default value, or throw a custom exception
            // For example, you can log the error and return an empty array
            Log::error('Error transforming BuyerInventory: ' . $e->getMessage());
            return [];
        }
    }
}
<?php

namespace App\Transformers;

use App\Models\ProductVariation;
use App\Models\ProductVariationMedia;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class ProductsCategoryWiseTransformer extends TransformerAbstract
{
    /**
     * Transform the product variation data.
     *
     * @return array
     */
    public function transform(ProductVariation $product)
    {

        try {
            // Retrieve the master media associated with the product, if available
            $media = $product->media->where('is_master', ProductVariationMedia::IS_MASTER_TRUE)->first();
            
            // If no master media is found, use a placeholder image; otherwise, use the file path from the media
            if ($media == null) {
                $thumbnail = 'https://via.placeholder.com/640x480.png/0044ff?text=at';
            } else {
                $thumbnail = url($media->file_path);
            }

            // Check if the user is authenticated
            $userIsExist = auth()->check();

            // Depending on the user's authentication status, set the stock, price, and status
            if ($userIsExist) {
                // If the user is authenticated, display actual stock, price, and availability status
                $stock = $product->stock;
                $price = $product->price_before_tax;
                $status = getAvailablityStatusName($product->availability_status);
            } else {
                // If the user is not authenticated, show placeholder values and prompt to log in to see the price
                $stock = '...';
                $status = 'Regular Availability';
                $price = '<a style="color:inherit" href="'.route('login').'">Login to See Price</a>';
            }

            // Return an associative array with product details
            $data = [
                'id' => salt_encrypt($product->id), // Encrypted product ID
                'title' => $product->title, // Product title
                'slug' => $product->slug, // URL-friendly slug for the product
                'images' => $thumbnail, // URL to the product image or placeholder
                'link' => url($product->slug), // URL to the product page
                'description' => $product->description, // Product description
                'stock' => $stock, // Product stock (or placeholder if not logged in)
                'price' => $price, // Product price (or prompt to log in if not logged in)
                'availability_status' => $status, // Product availability status
                'status' => getStatusName($product->status), // Product status name
            ];

            return $data;

        } catch (\Exception $e) {
            // Handle the exception here
            Log::error('Error transforming Import: '.$e->getMessage());
        }
    }
}

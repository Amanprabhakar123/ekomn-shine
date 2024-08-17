<?php

namespace App\Transformers;

use App\Models\UserActivity;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Log;
use App\Models\ProductVariationMedia;
use App\Services\UserActivityService;
use League\Fractal\TransformerAbstract;

class ProductsCategoryWiseTransformer extends TransformerAbstract
{
    protected $search_impression;

    public function __construct($search_impression = false)
    {
        $this->search_impression = $search_impression;
    }
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
                // $thumbnail = 'https://via.placeholder.com/640x480.png/0044ff?text=at';
                $thumbnail = 'storage/'.$media->file_path;
            } else {
                if( $media->thumbnail_path == null){
                    $thumbnail = 'storage/'.$media->file_path;
                } else {
                    $thumbnail  = $media->thumbnail_path;
                }
            }

            // Check if the user is authenticated
            $userIsExist = auth()->check();
            $is_login = false;
            // Depending on the user's authentication status, set the stock, price, and status
            if ($userIsExist) {
                // If the user is authenticated, display actual stock, price, and availability status
                $stock = $product->stock;
                $price = '<i class="fas fa-rupee-sign me-1"></i>' . $product->price_before_tax;
                $status = getAvailablityStatusName($product->availability_status);
                $is_login = true;
            } else {
                // If the user is not authenticated, show placeholder values and prompt to log in to see the price
                $stock = '...';
                $status = 'Regular Availability';
                $price = '<a style="color:inherit" href="'.route('buyer.login').'">Login to See Price</a>';
            }

            // Return an associative array with product details
            $data = [
                'id' => salt_encrypt($product->id), // Encrypted product ID
                'title' => $product->title, // Product title
                'slug' => $product->slug, // URL-friendly slug for the product
                'images' => $thumbnail, // URL to the product image or placeholder
                'link' => route('product.details', $product->slug), // URL to the product page
                'description' => $product->description, // Product description
                'stock' => $stock, // Product stock (or placeholder if not logged in)
                'price' => $price, // Product price (or prompt to log in if not logged in)
                'availability_status' => $status, // Product availability status
                'status' => getStatusName($product->status), // Product status name
                'is_login' => (boolean) $is_login, // User authentication status
                'login_url' => route('buyer.login'), // URL to the login page
            ];

            // add search impression data
            if (isset($this->search_impression) && $this->search_impression) {
                $userActivityService = new UserActivityService;
                $userActivityService->logActivity($product->id, UserActivity::ACTIVITY_TYPE_SEARCH);

            }
            return $data;

        } catch (\Exception $e) {
            // Handle the exception here
            Log::error('Error transforming Import: '.$e->getMessage());
        }
    }
}

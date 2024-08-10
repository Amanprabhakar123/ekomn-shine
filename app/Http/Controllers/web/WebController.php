<?php

namespace App\Http\Controllers\web;

use App\Models\TopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductVariationMedia;
use App\Models\TopCategory;

class WebController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('web.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productCategory()
    {
        return view('web.product-category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function productDetails()
    {
        return view('web.product-details');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function subCategory()
    {
        return view('web.sub-category');
    }

    public function topProductViewHome(){
        try{
        // Create placeholders for binding
        $typePlaceholders = implode(',', array_fill(0, count(TopProduct::TYPE_ARRAY_FOR_SELECT), '?'));

        $rankedProductsQuery = "
            WITH Media as (select * from product_variation_media where is_master = 1 and media_type = 1),
            RankedProducts AS (
            SELECT 
                *,
                ROW_NUMBER() OVER (PARTITION BY `type` ORDER BY id DESC) AS rn
            FROM 
                `top_products`
            WHERE 
                `type` IN ($typePlaceholders)
            )
            SELECT RankedProducts.*, product_variations.title, product_variations.slug, product_variations.price_before_tax, Media.thumbnail_path
            FROM RankedProducts
            left join product_variations on product_variations.id = RankedProducts.product_id
            left join Media on Media.product_variation_id = product_variations.id
            WHERE rn <= 3
            ORDER BY rn, type
        ";
        // Execute the query with bindings to prevent SQL injection
        $topProducts = DB::select($rankedProductsQuery, TopProduct::TYPE_ARRAY_FOR_SELECT);
        
        if(empty($topProducts)){
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode404'),
                    'status' => __('statusCode.status404'),
                    'message' => __('statusCode.message404'),
                ],
            ], __('statusCode.statusCode404'));
        }
        $data = [];
        foreach($topProducts as $product){
            if($product->type == TopProduct::TYPE_PREMIUM_PRODUCT){
                $data[strtolower(str_replace(' ', '_', TopProduct::TYPE_ARRAY[$product->type]))][] = [
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'price_before_tax' => $product->price_before_tax,
                    'product_image' => url($product->thumbnail_path),
                ];
            }
            elseif($product->type == TopProduct::TYPE_NEW_ARRIVAL){
                $data[strtolower(str_replace(' ', '_', TopProduct::TYPE_ARRAY[$product->type]))][] = [
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'price_before_tax' => $product->price_before_tax,
                    'product_image' => url($product->thumbnail_path),
                ];
            }elseif($product->type == TopProduct::TYPE_IN_DEMAND){
                $data[strtolower(str_replace(' ', '_', TopProduct::TYPE_ARRAY[$product->type]))][] = [
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'price_before_tax' => $product->price_before_tax,
                    'product_image' => url($product->thumbnail_path),
                ];
            }elseif($product->type == TopProduct::TYPE_REGULAR_AVAILABLE){
                $data[strtolower(str_replace(' ', '_', TopProduct::TYPE_ARRAY[$product->type]))][] = [
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'price_before_tax' => $product->price_before_tax,
                    'product_image' => url($product->thumbnail_path),
                ];
            }
        }

        // Feature Category
        $topCategory = TopCategory::with('topProduct.productVarition.media')->get();

        $futureProduct = $topCategory->map(function($category){
            return [
                'category_id' => salt_encrypt( $category->category_id),
                'category_name' => strtolower(str_replace(' ', '_',$category->category->name)),
                'category_link' => url('category/'.$category->category->slug),
                'priority' => $category->priority,
                'products' => $category->topProduct->map(function($product){
                    return [
                        'product_id' => salt_encrypt( $product->product_id),
                        'product_name' => $product->productVarition->title,
                        'product_image' => url($product->productVarition->media->where('is_master', ProductVariationMedia::IS_MASTER_TRUE)->first()->thumbnail_path),
                        'product_slug' => $product->productVarition->slug,
                        'product_price' => $product->productVarition->price_before_tax,
                    ];
                }),
            ];
        });
        $data['feature_category'] = $futureProduct;
        // dd($transform);
        // Return the response
        return response()->json([
            'data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'data' => $data
            ],
        ], __('statusCode.statusCode200'));

    }catch(\Exception $e){
       
    }
    }
}

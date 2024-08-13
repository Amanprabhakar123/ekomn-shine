<?php

namespace App\Http\Controllers\Web;

use App\Events\ExceptionEvent;
use App\Http\Controllers\Controller;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use App\Models\ProductVariationMedia;
use App\Models\TopCategory;
use App\Models\TopProduct;
use App\Models\UserActivity;
use App\Services\CategoryService;
use App\Services\RecommendationService;
use App\Services\UserActivityService;
use App\Transformers\ProductsCategoryWiseTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use Razorpay\Api\Product;

class WebController extends Controller
{
    /**
     * This class is responsible for handling web requests and controlling the web application.
     */
    protected $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

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
    public function productCategory($slug)
    {

        return view('web.product-category', compact('slug'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productDetails($slug)
    {
        $productVariations = ProductVariation::where('slug', $slug)->with('media', 'company', 'product')->with('product.features')->first();
        $colors = ProductVariation::colorVariation($productVariations->product_id);
        $sizes = ProductVariation::sizeVariation($productVariations->product_id, $productVariations->color);
        $shippingRatesTier = json_decode($productVariations->tier_shipping_rate, true);
        $tier_rate = json_decode($productVariations->tier_rate, true);
        $userActivityService = new UserActivityService;
        // Log the user view activity
        $userActivityService->logActivity($productVariations->id, UserActivity::ACTIVITY_TYPE_VIEW);

        return view('web.product-details', compact('productVariations', 'shippingRatesTier', 'tier_rate', 'colors', 'sizes'));
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

    /**
     * Filter categories by slug.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function productsCategoryWise($slug, Request $request)
    {
        try {
            // Get filtering, sorting, and pagination parameters from the request
            $productWithVideos = $request->input('productWithVideos', false);
            $newArrived = $request->input('new_arrived', false);
            $min = $request->input('min', '');
            $max = $request->input('max', '');
            $minimumStock = $request->input('minimumStock', '');
            $perPage = $request->input('per_page', 8);
            $searchTerm = $request->input('query', null);
            $sort = $request->input('sort', 'id'); // Default sort field 'id'
            $sortOrder = $request->input('categories', 'desc'); // Default sort direction 'desc'
            $sortByStatus = (int) $request->input('status', 1); // Default status filter

            // Define allowed sort fields to prevent SQL injection
            $allowedSorts = ['slug', 'sku', 'title', 'description', 'created_at', 'status'];
            $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'desc';
            $product_ids = [];
            $categorySlug = '';
            if ($slug !== 'all') {
                // Get category details
                $categoryService = new CategoryService;
                $categoryDetails = $categoryService->getCategoryBySlug($slug);

                if ($categoryDetails['status'] === true) {
                    $product_ids = $categoryDetails['result']['productIds'];
                    $categorySlug = $categoryDetails['result']['category'];
                }

                // Query for product variations
                $productVariations = ProductVariation::whereIn('status', [
                    ProductVariation::STATUS_OUT_OF_STOCK,
                    ProductVariation::STATUS_ACTIVE,
                ])->whereIn('product_id', $product_ids)->with('media');
            } else {
                $productVariations = ProductVariation::whereIn('status', [
                    ProductVariation::STATUS_OUT_OF_STOCK,
                    ProductVariation::STATUS_ACTIVE,
                ])->with('media');
                // $productVariations = ProductInventory::with('variations')
                //     ->whereHas('variations', function ($query) {
                //         $query->whereIn('status', [
                //             ProductVariation::STATUS_OUT_OF_STOCK,
                //             ProductVariation::STATUS_ACTIVE,
                //         ])->with('media');
                //     });
            }
            $productVariations = $productVariations->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('title', 'like', '%'.$searchTerm.'%')
                        ->orWhere('slug', 'like', '%'.$searchTerm.'%')
                        ->orWhere('description', 'like', '%'.$searchTerm.'%')
                        ->orWhere('sku', 'like', '%'.$searchTerm.'%');
                });
            });

            // Filter by new arrival
            if ($newArrived) {
                $productVariations = $productVariations->where('created_at', '>=', Carbon::now()->subDays(30))->latest();
            }

            // Filter by video content
            if ($productWithVideos) {
                $productVariations = $productVariations->whereHas('media', function ($query) {
                    $query->where('media_type', ProductVariationMedia::MEDIA_TYPE_VIDEO);
                });
            }

            // Filter by price range
            if ($min != '' && $max == '') {
                // Only $min is provided
                $productVariations = $productVariations->where('price_before_tax', '>=', $min);
            } elseif ($max != '' && $min == '') {
                // Only $max is provided
                $productVariations = $productVariations->where('price_before_tax', '<=', $max);
            } elseif ($min !== '' && $max !== '') {
                $productVariations = $productVariations->whereBetween('price_before_tax', [$min, $max]);
            }

            // Filter by minimum stock
            if ($minimumStock !== '') {
                $minimumStock = (int) $minimumStock;
                if ($minimumStock > 0) {
                    $productVariations = $productVariations->where('stock', '>=', $minimumStock);
                }
            }
            // Apply sorting and pagination
            $productVariations = $productVariations->orderBy($sort, $sortOrder)
                ->paginate($perPage);

            // Transform product variations using Fractal
            $resource = new Collection($productVariations, new ProductsCategoryWiseTransformer);
            $resource->setPaginator(new IlluminatePaginatorAdapter($productVariations));
            $products = $this->fractal->createData($resource)->toArray();

            // Prepare and return the response
            $data = [
                'slug' => $categorySlug,
                'productVariations' => $products,
            ];

            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'data' => $data,
                ],
            ], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            // Return a JSON response with error details

            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            return response()->json(['error' => $e->getLine().' '.$e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function topProductViewHome()
    {
        try {
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
            ORDER BY rn, type";

            // Execute the query with bindings to prevent SQL injection
            $topProducts = DB::select($rankedProductsQuery, TopProduct::TYPE_ARRAY_FOR_SELECT);
            // dd($topProducts);
            if (empty($topProducts)) {
                return response()->json([
                    'data' => [
                        'statusCode' => __('statusCode.statusCode404'),
                        'status' => __('statusCode.status404'),
                        'message' => __('statusCode.message404'),
                    ],
                ], __('statusCode.statusCode404'));
            }
            $data = [];
            foreach ($topProducts as $product) {
                if ($product->type == TopProduct::TYPE_PREMIUM_PRODUCT) {
                    $data[strtolower(str_replace(' ', '_', TopProduct::TYPE_ARRAY[$product->type]))][] = [
                        'title' => $product->title,
                        'slug' => route('product.details', $product->slug),
                        'price_before_tax' => $product->price_before_tax,
                        'product_image' => url($product->thumbnail_path),

                    ];
                } elseif ($product->type == TopProduct::TYPE_NEW_ARRIVAL) {
                    $data[strtolower(str_replace(' ', '_', TopProduct::TYPE_ARRAY[$product->type]))][] = [
                        'title' => $product->title,
                        'slug' => route('product.details', $product->slug),
                        'price_before_tax' => $product->price_before_tax,
                        'product_image' => url($product->thumbnail_path),
                    ];
                } elseif ($product->type == TopProduct::TYPE_IN_DEMAND) {
                    $data[strtolower(str_replace(' ', '_', TopProduct::TYPE_ARRAY[$product->type]))][] = [
                        'title' => $product->title,
                        'slug' => route('product.details', $product->slug),
                        'price_before_tax' => $product->price_before_tax,
                        'product_image' => url($product->thumbnail_path),
                    ];
                } elseif ($product->type == TopProduct::TYPE_REGULAR_AVAILABLE) {
                    $data[strtolower(str_replace(' ', '_', TopProduct::TYPE_ARRAY[$product->type]))][] = [
                        'title' => $product->title,
                        'slug' => route('product.details', $product->slug),
                        'price_before_tax' => $product->price_before_tax,
                        'product_image' => url($product->thumbnail_path),
                    ];
                }
            }

            // Feature Category
            $topCategory = TopCategory::with('topProduct.productVarition.media')->orderBy('priority', 'asc')->get();

            $futureProduct = $topCategory->map(function ($category) {
                return [
                    'category_id' => salt_encrypt($category->category_id),
                    'category_name' => $category->category->name,
                    'category_link' => url('category/'.$category->category->slug),
                    'priority' => $category->priority,
                    'products' => $category->topProduct->map(function ($product) {
                        $media = $product->productVarition->media->where('is_master', ProductVariationMedia::IS_MASTER_TRUE)->first();
                        if ($media == null) {
                            $thumbnail = 'https://via.placeholder.com/640x480.png/0044ff?text=at';
                        } else {
                            $thumbnail = url($media->thumbnail_path);
                        }

                        return [
                            'product_id' => salt_encrypt($product->product_id),
                            'product_name' => $product->productVarition->title,
                            'product_image' => $thumbnail,
                            'product_slug' => route('product.details', $product->productVarition->slug),
                            'product_price' => $product->productVarition->price_before_tax,
                        ];
                    }),
                ];
            });
            $data['feature_category'] = $futureProduct;

            // dd($transform);
            // Just For You
            $recommendationService = new RecommendationService;
            $userId = auth()->check() ? auth()->id() : null;
            $products = $recommendationService->getRecommendations($userId, $limit = 12);
            $just_for_you = $products->map(function ($product) {
                $media = $product->media->where('is_master', ProductVariationMedia::IS_MASTER_TRUE)->first();
                if ($media == null) {
                    $thumbnail = 'https://via.placeholder.com/640x480.png/0044ff?text=at';
                } else {
                    $thumbnail = url($media->thumbnail_path);
                }

                return [
                    'product_id' => salt_encrypt($product->product_id),
                    'product_name' => $product->title,
                    'product_image' => $thumbnail,
                    'product_slug' => route('product.details', $product->slug),
                    'product_price' => $product->price_before_tax,
                ];
            });

            $data['just_for_you'] = $just_for_you;

            // Return the response
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'data' => $data,
                ],
            ], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            // Return a JSON response with error details

            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
        }
    }

    public function productsTypeWise(Request $request, $type)
    {
        dd($type);
    }
}

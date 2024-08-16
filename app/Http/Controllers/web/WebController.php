<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use Razorpay\Api\Product;
use App\Models\TopProduct;
use App\Models\TopCategory;
use League\Fractal\Manager;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Events\ExceptionEvent;
use App\Models\ProductKeyword;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductVariationMedia;
use App\Services\UserActivityService;
use App\Services\RecommendationService;
use League\Fractal\Resource\Collection;
use App\Transformers\ProductsCategoryWiseTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

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
                    $query->where('title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('slug', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%')
                        ->orWhere('sku', 'like', '%' . $searchTerm . '%');
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

            return response()->json(['error' => $e->getLine() . ' ' . $e->getMessage()]);
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

            $data = [];
            if (!empty($topProducts)) {
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
            }

            // Feature Category
            $topCategory = TopCategory::with('topProduct.productVarition.media')->orderBy('priority', 'asc')->get();

            $futureProduct = $topCategory->map(function ($category) {
                return [
                    'category_id' => salt_encrypt($category->category_id),
                    'category_name' => $category->category->name,
                    'category_link' => url('category/' . $category->category->slug),
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

            // Just For You
            $recommendationService = new RecommendationService;
            $userId = auth()->check() ? auth()->id() : null;
            $products = $recommendationService->getRecommendations($userId, 12);
            $just_for_you = $products->map(function ($product) {
                $media = $product->media->where('is_master', ProductVariationMedia::IS_MASTER_TRUE)->first();
                if ($media == null) {
                    if(empty($media->file_path)){
                        $thumbnail = 'https://via.placeholder.com/640x480.png/0044ff?text=at';
                    }else{
                        $thumbnail = 'storage/'.$media->file_path;
                    }
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function justForYouViewMore(Request $request){
        try {
            $recommendationService = new RecommendationService;
            $userId = auth()->check() ? auth()->id() : null;
            $products = $recommendationService->getRecommendations($userId, 12, $request->perpage);
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

            // Return the response
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'data' => $just_for_you,
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productsType($type)
    {
        return view('web.product-type', compact('type'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productsTypeWise(Request $request, $type)
    {
        try {
            // Retrieve input parameters for filtering, sorting, and pagination
            $productWithVideos = $request->input('productWithVideos', false);
            $newArrived = $request->input('new_arrived', false);
            $min = $request->input('min', '');
            $max = $request->input('max', '');
            $minimumStock = $request->input('minimumStock', '');
            $perPage = $request->input('per_page', 8);
            $searchTerm = $request->input('query', null);
            $sort = $request->input('sort', 'id'); // Default sort field is 'id'
            $sortOrder = $request->input('categories', 'desc'); // Default sort direction is 'desc'
            $sortByStatus = (int) $request->input('status', 1); // Default status filter

            // Define allowed fields for sorting to prevent SQL injection
            $allowedSorts = ['type', 'sku', 'title', 'description', 'created_at', 'status'];
            $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'desc';

            // Determine product type based on the given type parameter
            $product_ids = [];
            $productType = TopProduct::getProductType($type);

            // Fetch products of the determined type
            $product_ids = TopProduct::where('type', $productType)->pluck('product_id');

            // Query for product variations based on status and product IDs
            if ($type !== '') {
                $productVariations = ProductVariation::whereIn('status', [
                    ProductVariation::STATUS_OUT_OF_STOCK,
                    ProductVariation::STATUS_ACTIVE,
                ])->whereIn('id', $product_ids)->with('media');
            }

            // Apply search filter if a search term is provided
            $productVariations = $productVariations->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('slug', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%')
                        ->orWhere('sku', 'like', '%' . $searchTerm . '%');
                });
            });

            // Filter by new arrival if specified
            if ($newArrived) {
                $productVariations = $productVariations->where('created_at', '>=', Carbon::now()->subDays(30))->latest();
            }

            // Filter by products with video content
            if ($productWithVideos) {
                $productVariations = $productVariations->whereHas('media', function ($query) {
                    $query->where('media_type', ProductVariationMedia::MEDIA_TYPE_VIDEO);
                });
            }

            // Apply price range filter if specified
            if ($min != '' && $max == '') {
                $productVariations = $productVariations->where('price_before_tax', '>=', $min);
            } elseif ($max != '' && $min == '') {
                $productVariations = $productVariations->where('price_before_tax', '<=', $max);
            } elseif ($min !== '' && $max !== '') {
                $productVariations = $productVariations->whereBetween('price_before_tax', [$min, $max]);
            }

            // Filter by minimum stock if specified
            if ($minimumStock !== '') {
                $minimumStock = (int) $minimumStock;
                if ($minimumStock > 0) {
                    $productVariations = $productVariations->where('stock', '>=', $minimumStock);
                }
            }

            // Apply sorting and pagination
            $productVariations = $productVariations->orderBy($sort, $sortOrder)
                ->paginate($perPage);

            // Transform the product variations using Fractal
            $resource = new Collection($productVariations, new ProductsCategoryWiseTransformer);
            $resource->setPaginator(new IlluminatePaginatorAdapter($productVariations));
            $products = $this->fractal->createData($resource)->toArray();

            // Prepare and return the response
            $data = [
                'Type' => $type,
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
            // Handle and log exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            event(new ExceptionEvent($exceptionDetails));

            // Return a JSON response with error details
            return response()->json(['error' => $e->getLine() . ' ' . $e->getMessage()]);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productSearchByKeyWord(Request $request, $keyword)
    {
        try {
            // Retrieve input parameters for filtering, sorting, and pagination
            $productWithVideos = $request->input('productWithVideos', false);
            $newArrived = $request->input('new_arrived', false);
            $min = $request->input('min', '');
            $max = $request->input('max', '');
            $minimumStock = $request->input('minimumStock', '');
            $perPage = $request->input('per_page', 8);
            $searchTerm = $request->input('query', null);
            $sort = $request->input('sort', 'id'); // Default sort field is 'id'
            $sortOrder = $request->input('categories', 'desc'); // Default sort direction is 'desc'
            $sortByStatus = (int) $request->input('status', 1); // Default status filter

            // Define allowed fields for sorting to prevent SQL injection
            $allowedSorts = ['type', 'sku', 'title', 'description', 'created_at', 'status'];
            $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'desc';

            $product_ids = [];
            if($request->has('query_type') && isset($request->query_type) == 'keyword'){
                $keyword = str_replace(' ', '-', $keyword);
                // Determine product type based on the given type parameter
                ProductKeyword::where('keyword', 'like', '%' . $keyword . '%')->get()
                    ->map(function ($item) use (&$product_ids) {
                        $product_ids[] = $item->id;
                });
                    $keyword = str_replace('-', ' ', $keyword);
                    ProductVariation::where('title', 'like', '%' . $keyword . '%')->get()
                    ->map(function ($item) use (&$product_ids) {
                    $product_ids[] = $item->id;
                });
            }else{
                ProductVariation::where('title', 'like', '%' . $keyword . '%')->get()
                    ->map(function ($item) use (&$product_ids) {
                        $product_ids[] = $item->id;
                });
                $keyword = str_replace(' ', '-', $keyword);
                // Determine product type based on the given type parameter
                ProductKeyword::where('keyword', 'like', '%' . $keyword . '%')->get()
                    ->map(function ($item) use (&$product_ids) {
                        $product_ids[] = $item->id;
                });
            }
            
            // Query for product variations based on status and product IDs
            if ($keyword !== '') {
                $productVariations = ProductVariation::whereIn('status', [
                    ProductVariation::STATUS_OUT_OF_STOCK,
                    ProductVariation::STATUS_ACTIVE,
                ])->whereIn('id', $product_ids)->with('media');
            }
            // Apply search filter if a search term is provided
            $productVariations = $productVariations->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('slug', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%')
                        ->orWhere('sku', 'like', '%' . $searchTerm . '%');
                });
            });

            // Filter by new arrival if specified
            if ($newArrived) {
                $productVariations = $productVariations->where('created_at', '>=', Carbon::now()->subDays(30))->latest();
            }

            // Filter by products with video content
            if ($productWithVideos) {
                $productVariations = $productVariations->whereHas('media', function ($query) {
                    $query->where('media_type', ProductVariationMedia::MEDIA_TYPE_VIDEO);
                });
            }

            // Apply price range filter if specified
            if ($min != '' && $max == '') {
                $productVariations = $productVariations->where('price_before_tax', '>=', $min);
            } elseif ($max != '' && $min == '') {
                $productVariations = $productVariations->where('price_before_tax', '<=', $max);
            } elseif ($min !== '' && $max !== '') {
                $productVariations = $productVariations->whereBetween('price_before_tax', [$min, $max]);
            }

            // Filter by minimum stock if specified
            if ($minimumStock !== '') {
                $minimumStock = (int) $minimumStock;
                if ($minimumStock > 0) {
                    $productVariations = $productVariations->where('stock', '>=', $minimumStock);
                }
            }

            // Apply sorting and pagination
            $productVariations = $productVariations->orderBy($sort, $sortOrder)
                ->paginate($perPage);

            // Transform the product variations using Fractal
            $resource = new Collection($productVariations, new ProductsCategoryWiseTransformer(true));
            $resource->setPaginator(new IlluminatePaginatorAdapter($productVariations));
            $products = $this->fractal->createData($resource)->toArray();

            // Prepare and return the response
            $data = [
                'Type' => $keyword,
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
            // Handle and log exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            event(new ExceptionEvent($exceptionDetails));

            // Return a JSON response with error details
            return response()->json(['error' => $e->getLine() . ' ' . $e->getMessage()]);
        }
    }
}

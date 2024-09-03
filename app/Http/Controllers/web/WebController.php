<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use App\Models\User;
use App\Models\ContactUs;
use Razorpay\Api\Product;
use App\Models\TopProduct;
use App\Mail\ContactUsMail;
use App\Models\TopCategory;
use League\Fractal\Manager;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Events\ExceptionEvent;
use App\Models\ProductKeyword;
use App\Models\ProductMatrics;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use App\Models\UnSubscribeToken;
use OpenApi\Annotations\Contact;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Models\ProductVariationMedia;
use App\Services\UserActivityService;
use App\Services\RecommendationService;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Validator;
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
        $productVariations = ProductVariation::where('slug', $slug)
            ->whereIn('status', [ProductVariation::STATUS_ACTIVE, ProductVariation::STATUS_OUT_OF_STOCK])
            ->with('media', 'company', 'product')->with('product.features')->first();
        if (!$productVariations) {
            abort(404);
        }
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
            $sortByStatus = (int) $request->input('status', 0); // Default status filter
            // dd($min, $max, $minimumStock);
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
                    $category_id = $categoryDetails['result']['category_id'];
                }

                $topCategory = TopCategory::where('category_id', $category_id)->with('topProduct')->first();
                if ($topCategory) {
                    $product_ids->merge($topCategory->topProduct->pluck('product_id'));
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

            // Check both price range and minimum stock
            if ($min !== '' && $max !== '' && $minimumStock !== '') {
                // Both $min, $max, and $minimumStock are provided
                $productVariations = $productVariations->whereBetween('price_before_tax', [$min, $max])
                ->where('stock', '>=', (int)$minimumStock);
            } elseif ($min !== '' && $max !== '' && $minimumStock === '') {
                // Both $min and $max are provided, $minimumStock is empty
                $productVariations = $productVariations->whereBetween('price_before_tax', [$min, $max]);
            } elseif ($min !== '' && $max === '' && $minimumStock !== '') {
                // Only $min and $minimumStock are provided, $max is empty
                $productVariations = $productVariations->where('price_before_tax', '>=', $min)
                ->where('stock', '>=', (int)$minimumStock);
            } elseif ($min === '' && $max !== '' && $minimumStock !== '') {
                // Only $max and $minimumStock are provided, $min is empty
                $productVariations = $productVariations->where('price_before_tax', '<=', $max)
                ->where('stock', '>=', (int)$minimumStock);
            } elseif ($min !== '' && $max === '' && $minimumStock === '') {
                // Only $min is provided, $max and $minimumStock are empty
                $productVariations = $productVariations->where('price_before_tax', '>=', $min);
            } elseif ($min === '' && $max !== '' && $minimumStock === '') {
                // Only $max is provided, $min and $minimumStock are empty
                $productVariations = $productVariations->where('price_before_tax', '<=', $max);
            } elseif ($min === '' && $max === '' && $minimumStock !== '') {
                // Only $minimumStock is provided, $min and $max are empty
                $productVariations = $productVariations->where('stock', '>=', (int)$minimumStock);
            }

            if ($sortByStatus > 0) {
                if ($sortByStatus == SORTING_STOCK_HIGH_TO_LOW) {
                    $productVariations = $productVariations->orderBy('stock', 'desc');
                } elseif ($sortByStatus == SORTING_STOCK_LOW_TO_HIGH) {
                    $productVariations = $productVariations->orderBy('stock', 'asc');
                } elseif ($sortByStatus == SORTING_PRICE_HIGH_TO_LOW) {
                    $productVariations = $productVariations->orderBy('price_before_tax', 'desc');
                } elseif ($sortByStatus == SORTING_PRICE_LOW_TO_HIGH) {
                    $productVariations = $productVariations->orderBy('price_before_tax', 'asc');
                } elseif ($sortByStatus == SORTING_REGULAR_AVAILABLE) {
                    $productVariations = $productVariations->where('availability_status', ProductVariation::REGULAR_AVAILABLE);
                } elseif ($sortByStatus == SORTING_TILL_STOCK_LAST) {
                    $productVariations = $productVariations->where('availability_status', ProductVariation::TILL_STOCK_LAST);
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
                    if (empty($media->file_path)) {
                        $thumbnail = 'https://via.placeholder.com/640x480.png/0044ff?text=at';
                    } else {
                        $thumbnail = 'storage/' . $media->file_path;
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

    public function justForYouViewMore(Request $request)
    {
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
            $sortByStatus = (int) $request->input('status', 0); // Default status filter

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
            if ($productType == TopProduct::TYPE_NEW_ARRIVAL) {
                $product_ids = ProductVariation::where('created_at', '>=', Carbon::now()->subDays(30))->pluck('id');
            }

            // Query for product variations based on status and product IDs
            if ($productType == TopProduct::TYPE_REGULAR_AVAILABLE) {
                $product_ids = ProductVariation::where('availability_status', ProductVariation::REGULAR_AVAILABLE)->pluck('id');
            }

            if ($productType == TopProduct::TYPE_IN_DEMAND) {
                $product_ids = ProductMatrics::orderBy('purchase_count', 'desc')
                    ->orderBy('buy_now_or_add_to_cart_count', 'desc')
                    ->orderBy('add_to_inventory_count', 'desc')
                    ->orderBy('view_count', 'desc')
                    ->pluck('product_id');
            }
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

            // Check both price range and minimum stock
            if ($min !== '' && $max !== '' && $minimumStock !== '') {
                // Both $min, $max, and $minimumStock are provided
                $productVariations = $productVariations->whereBetween('price_before_tax', [$min, $max])
                ->where('stock', '>=', (int)$minimumStock);
            } elseif ($min !== '' && $max !== '' && $minimumStock === '') {
                // Both $min and $max are provided, $minimumStock is empty
                $productVariations = $productVariations->whereBetween('price_before_tax', [$min, $max]);
            } elseif ($min !== '' && $max === '' && $minimumStock !== '') {
                // Only $min and $minimumStock are provided, $max is empty
                $productVariations = $productVariations->where('price_before_tax', '>=', $min)
                ->where('stock', '>=', (int)$minimumStock);
            } elseif ($min === '' && $max !== '' && $minimumStock !== '') {
                // Only $max and $minimumStock are provided, $min is empty
                $productVariations = $productVariations->where('price_before_tax', '<=', $max)
                ->where('stock', '>=', (int)$minimumStock);
            } elseif ($min !== '' && $max === '' && $minimumStock === '') {
                // Only $min is provided, $max and $minimumStock are empty
                $productVariations = $productVariations->where('price_before_tax', '>=', $min);
            } elseif ($min === '' && $max !== '' && $minimumStock === '') {
                // Only $max is provided, $min and $minimumStock are empty
                $productVariations = $productVariations->where('price_before_tax', '<=', $max);
            } elseif ($min === '' && $max === '' && $minimumStock !== '') {
                // Only $minimumStock is provided, $min and $max are empty
                $productVariations = $productVariations->where('stock', '>=', (int)$minimumStock);
            }

            if ($sortByStatus > 0) {
                if ($sortByStatus == SORTING_STOCK_HIGH_TO_LOW) {
                    $productVariations = $productVariations->orderBy('stock', 'desc');
                } elseif ($sortByStatus == SORTING_STOCK_LOW_TO_HIGH) {
                    $productVariations = $productVariations->orderBy('stock', 'asc');
                } elseif ($sortByStatus == SORTING_PRICE_HIGH_TO_LOW) {
                    $productVariations = $productVariations->orderBy('price_before_tax', 'desc');
                } elseif ($sortByStatus == SORTING_PRICE_LOW_TO_HIGH) {
                    $productVariations = $productVariations->orderBy('price_before_tax', 'asc');
                } elseif ($sortByStatus == SORTING_REGULAR_AVAILABLE) {
                    $productVariations = $productVariations->where('availability_status', ProductVariation::REGULAR_AVAILABLE);
                } elseif ($sortByStatus == SORTING_TILL_STOCK_LAST) {
                    $productVariations = $productVariations->where('availability_status', ProductVariation::TILL_STOCK_LAST);
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
            $sortByStatus = (int) $request->input('status', 0); // Default status filter

            // Define allowed fields for sorting to prevent SQL injection
            $allowedSorts = ['type', 'sku', 'title', 'description', 'created_at', 'status'];
            $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'desc';

            $product_ids = [];
            if ($request->has('query_type') && $request->query_type == 'keyword') {
                $keyword = str_replace(' ', '-', $keyword);
                // Determine product type based on the given type parameter
                ProductKeyword::where('keyword', 'like', '%' . $keyword . '%')->get()
                    ->map(function ($item) use (&$product_ids) {
                        $product_ids[] = $item->id;
                    });
                // SKU search
                ProductVariation::where('sku', 'like', '%' . $keyword . '%')->get()
                    ->map(function ($item) use (&$product_ids) {
                        $product_ids[] = $item->id;
                    });
                $keyword = str_replace('-', ' ', $keyword);
                ProductVariation::where('title', 'like', '%' . $keyword . '%')->get()
                    ->map(function ($item) use (&$product_ids) {
                        $product_ids[] = $item->id;
                    });
            } else {
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
                // SKU search
                ProductVariation::where('sku', 'like', '%' . $keyword . '%')->get()
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

            // Check both price range and minimum stock
            if ($min !== '' && $max !== '' && $minimumStock !== '') {
                // Both $min, $max, and $minimumStock are provided
                $productVariations = $productVariations->whereBetween('price_before_tax', [$min, $max])
                ->where('stock', '>=', (int)$minimumStock);
            } elseif ($min !== '' && $max !== '' && $minimumStock === '') {
                // Both $min and $max are provided, $minimumStock is empty
                $productVariations = $productVariations->whereBetween('price_before_tax', [$min, $max]);
            } elseif ($min !== '' && $max === '' && $minimumStock !== '') {
                // Only $min and $minimumStock are provided, $max is empty
                $productVariations = $productVariations->where('price_before_tax', '>=', $min)
                ->where('stock', '>=', (int)$minimumStock);
            } elseif ($min === '' && $max !== '' && $minimumStock !== '') {
                // Only $max and $minimumStock are provided, $min is empty
                $productVariations = $productVariations->where('price_before_tax', '<=', $max)
                ->where('stock', '>=', (int)$minimumStock);
            } elseif ($min !== '' && $max === '' && $minimumStock === '') {
                // Only $min is provided, $max and $minimumStock are empty
                $productVariations = $productVariations->where('price_before_tax', '>=', $min);
            } elseif ($min === '' && $max !== '' && $minimumStock === '') {
                // Only $max is provided, $min and $minimumStock are empty
                $productVariations = $productVariations->where('price_before_tax', '<=', $max);
            } elseif ($min === '' && $max === '' && $minimumStock !== '') {
                // Only $minimumStock is provided, $min and $max are empty
                $productVariations = $productVariations->where('stock', '>=', (int)$minimumStock);
            }

            if ($sortByStatus > 0) {
                if ($sortByStatus == SORTING_STOCK_HIGH_TO_LOW) {
                    $productVariations = $productVariations->orderBy('stock', 'desc');
                } elseif ($sortByStatus == SORTING_STOCK_LOW_TO_HIGH) {
                    $productVariations = $productVariations->orderBy('stock', 'asc');
                } elseif ($sortByStatus == SORTING_PRICE_HIGH_TO_LOW) {
                    $productVariations = $productVariations->orderBy('price_before_tax', 'desc');
                } elseif ($sortByStatus == SORTING_PRICE_LOW_TO_HIGH) {
                    $productVariations = $productVariations->orderBy('price_before_tax', 'asc');
                } elseif ($sortByStatus == SORTING_REGULAR_AVAILABLE) {
                    $productVariations = $productVariations->where('availability_status', ProductVariation::REGULAR_AVAILABLE);
                } elseif ($sortByStatus == SORTING_TILL_STOCK_LAST) {
                    $productVariations = $productVariations->where('availability_status', ProductVariation::TILL_STOCK_LAST);
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutUs()
    {
        return view('web.about-us');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contactUs()
    {
        return view('web.contact-us');
    }

    public function privacyPolicy()
    {
        return view('web.privacy-policy');
    }

    public function termsAndConditions()
    {
        return view('web.terms-and-conditions');
    }

    public function returnPolicy()
    {
        return view('web.return-policy');
    }

    public function shippingPolicy()
    {
        return view('web.shipping-policy');
    }

    public function becomeSupplier()
    {
        return view('web.become-supplier');
    }

    public function subscription()
    {
        return view('web.subscription');
    }

    public function integration()
    {
        return view('web.integration');
    }

    /**
     * Contact us post request
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Contact us post request
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function contactUsPost(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
                'g-recaptcha-response' => 'required|recaptchav3:contact_us,0.5',
            ],[
                'g-recaptcha-response.recaptchav3' => __('auth.recaptcha'),
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode200'));
            }

            // $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            //     'secret'   => config('services.recaptcha.secret_key'),
            //     'response' => $request->input('g-recaptcha-response'),
            //     'remoteip' => $request->ip(),
            // ]);
        
            // $recaptchaData = $response->json();
        
            // if(!$recaptchaData['success'] || $recaptchaData['score'] < 0.5) {
            //     return response()->json(['data' => [
            //         'statusCode' => __('statusCode.statusCode422'),
            //         'status' => __('statusCode.status422'),
            //         'message' => __('auth.recaptcha'),
            //     ]], __('statusCode.statusCode200'));
            // }

            // Create a new contact us record
            ContactUs::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);

            // Send an email by mail
            Mail::to($request->email)
            ->send(new ContactUsMail($request->all()));

            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.contactUsSuccess'),
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
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => __('auth.invalidInputData'),
                ],
            ], __('statusCode.statusCode500'));
        }
    }

    /**
     * unsubscribe post request user model
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe($token)
    {
        try {
            $hashedToken = hash('sha256', $token);
            $unsubscribeToken = UnSubscribeToken::where('token', $hashedToken)->first();
    
            if (!$unsubscribeToken || $unsubscribeToken->expires_at->isPast()) {
                return response()->json(['message' => 'This token is invalid or has expired.'], 400);
            }
    
            $user = $unsubscribeToken->user_id;
            $unSubscribe = User::find($user);
            $unSubscribe->subscribe = User::SUBSCRIBE_NO;
            $unSubscribe->save();
          
            return redirect()->route('unsubscribe.view');
            
        } catch (\Exception $e) {
            // Handle and log exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            event(new ExceptionEvent($exceptionDetails));
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => __('auth.invalidInputData'),
                ],
            ], __('statusCode.statusCode500'));
        }
    }
}

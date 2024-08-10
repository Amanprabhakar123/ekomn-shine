<?php

namespace App\Http\Controllers\web;

use App\Events\ExceptionEvent;
use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use App\Models\ProductVariationMedia;
use App\Services\CategoryService;
use App\Transformers\ProductsCategoryWiseTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;

class WebController extends Controller
{
    /**
     * Class WebController
     *
     * This class is responsible for handling web requests and controlling the web application.
     */
    protected $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    public function index()
    {
        return view('web.index');
    }

    public function productCategory($slug)
    {

        return view('web.product-category', compact('slug'));
    }

    public function productDetails($id)
    {
        $id = salt_decrypt($id);
        $productVariations = ProductVariation::where('id', $id)->with('media')->first();
        $shippingRatesTier = json_decode($productVariations->tier_shipping_rate, true);

        return view('web.product-details', compact('productVariations', 'shippingRatesTier'));
    }

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
            $perPage = $request->input('per_page', 10);
            $searchTerm = $request->input('query', null);
            $sort = $request->input('sort', 'id'); // Default sort field 'id'
            $sortOrder = $request->input('categories', 'desc'); // Default sort direction 'desc'
            $sortByStatus = (int) $request->input('status', 1); // Default status filter

            // Define allowed sort fields to prevent SQL injection
            $allowedSorts = ['slug', 'sku', 'title', 'description', 'created_at', 'status'];
            $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'desc';

            // Get category details
            $categoryService = new CategoryService;
            $categoryDetails = $categoryService->getCategoryBySlug($slug);
            $product_ids = [];
            $categorySlug = '';

            if ($categoryDetails['status'] === true) {
                $product_ids = $categoryDetails['result']['productIds'];
                $categorySlug = $categoryDetails['result']['category'];
            }

            // Query for product variations
            $productVariations = ProductVariation::whereIn('status', [
                ProductVariation::STATUS_OUT_OF_STOCK,
                ProductVariation::STATUS_ACTIVE,
            ])
                ->whereIn('product_id', $product_ids)
                ->with('media')
                ->when($searchTerm, function ($query) use ($searchTerm) {
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
            if ($min !== '' && $max !== '') {
                $productVariations = $productVariations->whereBetween('price_before_tax', [$min, $max]);
            } elseif ($min != '') {
                // Only $min is provided
                $productVariations = $productVariations->where('price_before_tax', '>=', $min);
            } elseif ($max != '') {
                // Only $max is provided
                $productVariations = $productVariations->where('price_before_tax', '<=', $max);
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
}

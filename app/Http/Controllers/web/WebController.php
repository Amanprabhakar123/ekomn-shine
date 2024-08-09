<?php

namespace App\Http\Controllers\web;

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

    public function productDetails()
    {
        return view('web.product-details');
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

            // Get pagination and sorting parameters from the request
            $productWithVideos = $request->input('productWithVideos', '');
            $newArrived = $request->input('new_arrived', '');
            $min = $request->input('min', '');
            $max = $request->input('max', '');
            $minmax = $request->input('minmax', '');

            $perPage = $request->input('per_page', 10);
            $searchTerm = $request->input('query', null);
            $sort = $request->input('sort', 'id'); // Default sort field 'id'
            $sortOrder = $request->input('categories', 'desc'); // Default sort direction 'desc'
            $sort_by_status = (int) $request->input('status', '1'); // Default sort by 'all'

            // Define allowed sort fields to prevent SQL injection
            $allowedSorts = ['slug', 'sku', 'title', 'description', 'created_at', 'status'];
            $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';
            $categoryService = new CategoryService;
            $categoryDetails = $categoryService->getCategoryBySlug($slug);
            $product_ids = [];
            $s_slug = '';
            if ($categoryDetails['status'] == true) {
                $product_ids = $categoryDetails['result']['productIds'];
                $s_slug = $categoryDetails['result']['category'];
            }
            // Find the product variations in the ProductVariation table
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

            // Filter by newArrived if provided
            if ($newArrived == true) {
                // Get records from the last 30 days
                $productVariations = $productVariations->where('created_at', '>=', Carbon::now()->subDays(30))->latest();
            }
            if ($productWithVideos == true) {
                $productVariations = $productVariations->whereHas('media', function ($query) {
                    $query->where('media_type', '=', ProductVariationMedia::MEDIA_TYPE_VIDEO);
                });
            }
            if ($min != '' && $max != '') {
                $productVariations = $productVariations->whereBetween('price_before_tax', [$min, $max]);
            }
            if ($minmax != '') {
                $productVariations = $productVariations->where('price_before_tax', $minmax);
            }
            // Apply sorting and pagination
            $productVariations = $productVariations->orderBy($sort, $sortOrder)
                ->paginate($perPage);

            // Transform product variations using Fractal
            $resource = new Collection($productVariations, new ProductsCategoryWiseTransformer);
            $resource->setPaginator(new IlluminatePaginatorAdapter($productVariations));
            $products = $this->fractal->createData($resource)->toArray();

            // Prepare data for response
            $data = [
                'slug' => $s_slug,
                'productVariations' => $products,
            ];

            // Return the transformed data as a JSON response
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'data' => $data,
                ],
            ], __('statusCode.statusCode200'));

        } catch (\Exception $e) {
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Optionally, trigger an event with exception details (if needed)
            // event(new ExceptionEvent($exceptionDetails));

            // Return a JSON response with error details
            return response()->json(['error' => $e->getLine().' '.$e->getMessage()]);
        }

    }
}

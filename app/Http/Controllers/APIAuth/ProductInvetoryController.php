<?php

namespace App\Http\Controllers\APIAuth;

use App\Models\User;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use League\Fractal\Resource\Collection;
use App\Transformers\ProductVariationTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class ProductInvetoryController extends Controller
{

    protected $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * Retrieve a paginated list of product inventories.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @OA\Get(
     *     path="/api/product-inventories",
     *     summary="Retrieve a paginated list of product inventories",
     *     tags={"Product Inventories"},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             default=10
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         description="Search term",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Sort field",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"id", "title", "sku", "price_after_tax", "stock"},
     *             default="id"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="order",
     *         in="query",
     *         description="Sort order",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"asc", "desc"},
     *             default="asc"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ProductInventory")
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 ref="#/components/schemas/Meta"
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 ref="#/components/schemas/Links"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized action"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="string"
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            // Get the authenticated user's ID
            $userId = auth()->user()->id;

            $perPage = $request->input('per_page', 10);
            $searchTerm = $request->input('query', null);
            $sort = $request->input('sort', 'id'); // Default sort by 'title'
            $sortOrder = $request->input('order', 'asc'); // Default sort direction 'asc'
            $sort_by_status = (int) $request->input('sort_by_status', '0'); // Default sort by 'all'

            // Allowed sort fields to prevent SQL injection
            $allowedSorts = ['title', 'sku', 'price_after_tax', 'stock'];
            $sort = in_array($sort, $allowedSorts) ? $sort : 'title';
            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

            if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {

                // Eager load product variations with product inventory that matches user_id
                $variations = ProductVariation::whereHas('product', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
                if ($sort_by_status != 0) {
                    $variations = $variations->where('status', $sort_by_status);
                }
                $variations = $variations->when($searchTerm, function ($query) use ($searchTerm) {
                    $query->where(function ($query) use ($searchTerm) {
                        $query->where('title', 'like', '%' . $searchTerm . '%')
                            ->orWhere('sku', 'like', '%' . $searchTerm . '%')
                            ->orWhere('product_slug_id', 'like', '%' . $searchTerm . '%');
                    });
                })
                    ->with([
                        'media',
                        'product',
                        'product.category'
                    ]) // Eager load the product and category relationships
                    ->orderBy($sort, $sortOrder) // Apply sorting
                    ->paginate($perPage); // Paginate results


            } elseif (auth()->user()->hasRole(User::ROLE_ADMIN)) {
                // Eager load product variations with product inventory that matches user_id
                $variations = ProductVariation::when($searchTerm, function ($query) use ($searchTerm) {
                    $query->where(function ($query) use ($searchTerm) {
                        $query->where('title', 'like', '%' . $searchTerm . '%')
                            ->orWhere('sku', 'like', '%' . $searchTerm . '%')
                            ->orWhere('product_slug_id', 'like', '%' . $searchTerm . '%');
                    });
                });
                if ($sort_by_status != 0) {
                    $variations = $variations->where('status', $sort_by_status);
                }
                $variations = $variations->with([
                        'media',
                        'product',
                        'product.category',
                        'product.company'
                    ]) // Eager load the product and category relationships
                    ->orderBy($sort, $sortOrder) // Apply sorting
                    ->paginate($perPage); // Paginate results
            } else {
                abort('403', 'Unauthorized action.');
            }
            // Transform the paginated results using Fractal
            $resource = new Collection($variations, new ProductVariationTransformer());

            // // Add pagination information to the resource
            $resource->setPaginator(new IlluminatePaginatorAdapter($variations));

            // // Create the data array using Fractal
            $data = $this->fractal->createData($resource)->toArray();

            // Return the JSON response with paginated data
            return response()->json($data);
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['data' =>  __('auth.productInventoryShowFailed')], __('statusCode.statusCode500'));
        }
    }

    /**
     * Update the stock of a product variation.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @OA\Put(
     *     path="/api/product-inventories/{variation_id}/update-stock",
     *     summary="Update the stock of a product variation",
     *     tags={"Product Inventories"},
     *     @OA\Parameter(
     *         name="variation_id",
     *         in="path",
     *         description="ID of the product variation",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="ID of the product",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="stock",
     *         in="query",
     *         description="New stock value",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized action"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="string"
     *             )
     *         )
     *     )
     * )
     */
    public function updateStock(Request $request, $variation_id)
    {
        try {
            // dd($request->all());
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|string',
                'stock' => 'required|integer'
            ]);
            $variation_id = salt_decrypt($variation_id);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status400'),
                    'message' => $validator->errors()->first()
                ]], __('statusCode.statusCode400'));
            }

            // Find the product variation
            $variation = ProductVariation::where(['id' => $variation_id, 'product_slug_id' => $request->input('product_id')])->firstOrFail();

            if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
                // Check if the product variation belongs to the authenticated user
                if ($variation->product->user_id !== auth()->user()->id) {
                    abort(403, 'Unauthorized action.');
                }
                // Update the stock of the product variation
                $variation->stock = $request->input('stock');
                $variation->save();

                $response['data'] = [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.updateStock'),
                ];
                // Return a success message
                return response()->json($response);
            } elseif (auth()->user()->hasRole(User::ROLE_ADMIN)) {
                // Update the stock of the product variation
                $variation->stock = $request->input('stock');
                $variation->save();

                $response['data'] = [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.updateStock'),
                ];
                // Return a success message
                return response()->json($response);
            } else {
                abort('403', 'Unauthorized action.');
            }
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['data' => __('auth.updateStockFailed')], __('statusCode.statusCode500'));
        }
    }

    /**
     * Update the status of a product variation.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @OA\Put(
     *     path="/api/product-inventories/{variation_id}/update-status",
     *     summary="Update the status of a product variation",
     *     tags={"Product Inventories"},
     *     @OA\Parameter(
     *         name="variation_id",
     *         in="path",
     *         description="ID of the product variation",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="ID of the product",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="New status value",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             enum={"active", "inactive"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized action"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="string"
     *             )
     *         )
     *     )
     * )
     */
    public function updateStatus(Request $request, $variation_id)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|string',
                'status' => 'required|integer'
            ]);
            $variation_id = salt_decrypt($variation_id);
            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status400'),
                    'message' => $validator->errors()->first()
                ]], __('statusCode.statusCode400'));
            }
            // Find the product variation
            $variation = ProductVariation::where(['id' => $variation_id, 'product_slug_id' => $request->input('product_id')])->firstOrFail();
            if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
                // Check if the product variation belongs to the authenticated user
                if ($variation->product->user_id !== auth()->user()->id) {
                    abort(403, 'Unauthorized action.');
                }
                // Update the status of the product variation
                $variation->status = $request->input('status');
                $variation->save();
                $response['data'] = [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.updateStatus'),
                ];
                // Return a success message
                return response()->json($response);
            } elseif (auth()->user()->hasRole(User::ROLE_ADMIN)) {
                // Update the status of the product variation
                $variation->status = $request->input('status');
                $variation->save();

                $response['data'] = [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.updateStatus'),
                ];
                // Return a success message
                return response()->json($response);
            } else {
                abort('403', 'Unauthorized action.');
            }
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['data' => __('auth.updateStatusFailed')], __('statusCode.statusCode500'));
        }
    }
}

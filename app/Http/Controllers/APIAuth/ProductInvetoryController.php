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
use App\Models\ProductKeyword;
use App\Models\ProductInventory;
use App\Models\ProductFeature;

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
     * Add inventory to the product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addInventory(Request $request){

       // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'product_name' => 'required|string|max:255',
                'product_description' => 'required|string',
                'product_keywords' => 'required|array',
                'product_keywords.*' => 'string',
                'product_category' => 'required|string|max:255',
                'product_sub_category' => 'required|string|max:255',
                'feature' => 'nullable|array',
                'feature.*' => 'string',
                'dropship_rate' => 'required|numeric',
                'potential_mrp' => 'required|numeric',
                'bulk' => 'required|array',
                'bulk.*.quantity' => 'required|numeric|min:1',
                'bulk.*.price' => 'required|numeric|min:1',
                'shipping' => 'required|array',
                'shipping.*.quantity' => 'required|numeric|min:1',
                'shipping.*.local' => 'required|numeric|min:1',
                'shipping.*.regional' => 'required|numeric|min:1',
                'shipping.*.national' => 'required|numeric|min:1',
                'upc' => 'nullable|numeric',
                'isbn' => 'nullable|string||regex:/^\d{10}(\d{3})?$/',
                'mpn' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9- ]+$/',
                'package_volumetric_weight' => 'required|numeric',
                'volumetric_weight' => 'required|numeric',
                'model' => 'required|string|max:255',
                'product_hsn' => 'required|string|string|digits_between:6,8|regex:/^\d{6,8}$/',
                'gst_bracket' => 'required|numeric|in:0,5,12,18,28',
                'availability' => 'required|string|in:1,2',
                'length' => 'required|numeric',
                'width' => 'required|numeric',
                'height' => 'required|numeric',
                'dimension_class' => 'required|in:mm,cm,inch',
                'weight' => 'required|numeric',
                'weight_class' => 'required|in:mg,gm,kg,ml,ltr',
                'package_length' => 'required|numeric',
                'package_width' => 'required|numeric',
                'package_height' => 'required|numeric',
                'package_dimension_class' => 'required|in:mm,cm,inch',
                'package_weight' => 'required|numeric',
                'package_weight_class' => 'required|in:mg,gm,kg,ml,ltr',
                'product_listing_status' => 'required|in:0,1,2',
                'variant' => 'required|array',
                'variant.*.color' => 'required',
                'variant.*.size.*' => 'required|string',
                'variant.*.stock.*' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status400'),
                    'message' => $validator->errors()
                ]], __('statusCode.statusCode400'));
            }

            // Find the product variation

            if (1) {
                $user_id = auth()->user()->id;
                $company_id =auth()->user()->company_id;
                // Check if the product variation belongs to the authenticated user
                $data = $request->all();
                if(count($data['bulk']) > 0){
                    $tierRate = [];
                    $min = 1;
                    foreach ($data['bulk'] as $bulk) {
                            $tierRate[] = [
                                'range' => [
                                    'min' => $min, // You might want to adjust this according to your logic
                                    'max' => (int) $bulk['quantity']
                                ],
                                'price' => $bulk['price']
                            ];
                            $min = (int) $bulk['quantity'] + 1;
                    }
                }
                    $tierShippingRate = [];
                    $minRange = 1;
                    if(count($data['shipping']) > 0){

                    foreach ($data['shipping'] as $shipping) {
                        $tierShippingRate[] = [
                            'range' => [
                                'min' => $minRange, // You might want to adjust this according to your logic
                                'max' => (int) $shipping['quantity']
                            ],
                            'local' => $shipping['local'],
                            'regional' => $shipping['regional'],
                            'national' => $shipping['national']
                        ];
                        $minRange = (int) $shipping['quantity'] + 1;
                    }
                }

                $product = ProductInventory::create([
                    'title' =>  $data['product_name'],
                    'description' =>  $data['product_description'],
                    'product_category' =>  salt_decrypt($data['product_category_id']),
                    'product_subcategory' => salt_decrypt ($data['product_sub_category_id']),
                    'company_id' =>  $company_id,
                    'user_id' => $user_id,
                    'model' =>  $data['model'],
                    'hsn' =>  $data['product_hsn'],
                    'gst_percentage' =>  $data['gst_bracket'],
                    'upc' =>  $data['upc'] ?? null,
                    'isbn' =>  $data['isbn'] ?? null,
                    'mpin' =>  $data['mpn'] ?? null,
                    'gst_percentage' =>  $data['gst_bracket'],
                    'availability_status' => $data['availability'],
                    'status' => $data['product_listing_status'] ?? 1
                ]);

                $product_id =  $product->id;
                if(count($data['product_keywords']) > 0){
                    foreach ($data['product_keywords'] as $key => $product_keyword) {
                        ProductKeyword::create([
                            'product_id' => $product_id,
                            'company_id' => $company_id,
                            'keyword' => $product_keyword
                        ]);
                    }
                }

                if(count($data['feature']) > 0){
                    foreach ($data['feature'] as $key => $feature) {
                        ProductFeature::create([
                            'product_id' => $product_id,
                            'company_id' => $company_id,
                            'feature_name' => $feature,
                            'value' => $feature
                        ]);
                    }
                }
               
            
                $generateProductID = generateProductID($request->product_name, $product_id);
                    foreach ($data['variant'] as $key => $value) {
                        foreach ($value['size'] as $size_key => $value1) {
                            $productVariation = ProductVariation::create([
                                'product_id' => $product_id,
                                'company_id' => $company_id,
                                'product_slug_id' => $generateProductID,
                                'slug' => '',
                                'sku' => generateSKU($request->product_name, $data['product_category']),
                                'size' => $value1,
                                'stock' => $data['variant'][$key]['stock'][$size_key],
                                'title' => $request->product_name,
                                'description' => $request->product_description,
                                'color' => $value['color'],
                                'length' => $request->length,
                                'width' => $request->width,
                                'height' => $request->height,
                                'dimension_class' => $request->dimension_class,
                                'weight' => $request->weight,
                                'weight_class' => $request->weight_class,
                                'volumetric_weight' => $request->volumetric_weight,
                                'package_length' => $request->package_length,
                                'package_width' => $request->package_width,
                                'package_height' => $request->package_height,
                                'package_dimension_class' => $request->package_dimension_class,
                                'package_weight' => $request->package_weight,
                                'package_weight_class' => $request->package_weight_class,
                                'price_before_tax' => 0,
                                'price_after_tax' => 0,
                                'status' => $data['product_listing_status'] ?? 1,
                                'availability_status' => $request->availability,
                                'dropship_rate' => $request->dropship_rate,
                                'potential_mrp' => $request->potential_mrp,
                                'tier_rate' => json_encode($tierRate),
                                'tier_shipping_rate' => json_encode($tierShippingRate),
                            ]); 

                            $productVariation->slug = generateSlug($request->product_name, $productVariation->id);
                            $productVariation->save();
                        }
                        
                    }
                    // Create new product variation
                    
            
                
                
                $response['data'] = [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.updateStock'),
                ];
                // Return a success message
                return response()->json($response);
            } 
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Handle the exception
            return response()->json(['data' => __('auth.updateStockFailed')], __('statusCode.statusCode500'));
        }

        dd($request->all());
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

<?php

namespace App\Http\Controllers\APIAuth;

use App\Models\User;
use Illuminate\Support\Str;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Models\ProductFeature;
use App\Models\ProductKeyword;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CompanyDetail;
use App\Models\ProductVariationMedia;
use Illuminate\Support\Facades\Storage;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Validator;
use App\Transformers\ProductVariationTransformer;
use App\Transformers\BulkDataTransformer;
use Illuminate\Support\Facades\File;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Models\Import;

class ProductInvetoryController extends Controller
{

    protected $fractal;
    protected $BulkDataTransformer;

    public function __construct(Manager $fractal, BulkDataTransformer $BulkDataTransformer)
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
            $sortOrder = $request->input('order', 'desc'); // Default sort direction 'asc'
            $sort_by_status = (int) $request->input('sort_by_status', '0'); // Default sort by 'all'

            // Allowed sort fields to prevent SQL injection
            $allowedSorts = ['title', 'sku', 'price_after_tax', 'stock'];
            $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

            if (auth()->user()->hasRole(User::ROLE_SUPPLIER) && auth()->user()->hasPermissionTo(User::PERMISSION_LIST_PRODUCT)) {

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


            } elseif (auth()->user()->hasRole(User::ROLE_ADMIN) && auth()->user()->hasPermissionTo(User::PERMISSION_LIST_PRODUCT)) {
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
                return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
            }
            // Transform the paginated results using Fractal
            $resource = new Collection($variations, new ProductVariationTransformer());

            // // Add pagination information to the resource
            $resource->setPaginator(new IlluminatePaginatorAdapter($variations));

            // // Create the data array using Fractal
            $data = $this->fractal->createData($resource)->toArray();

            // Return the JSON response with paginated data
            return response()->json($data);
            dd($data);
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
    public function addInventory(Request $request)
    {
        if (auth()->user()->hasPermissionTo(User::PERMISSION_ADD_PRODUCT)) {
            try {
                $rules = [
                    'product_name' => 'required|string|max:255',
                    'product_description' => 'required|string',
                    'product_keywords' => 'required|array',
                    'product_keywords.*' => 'string',
                    'product_category' => 'required|string|max:255',
                    'product_sub_category' => 'required|string|max:255',
                    'feature' => 'required|array',
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
                    'isbn' => 'nullable|string',
                    'mpn' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9- ]+$/',
                    'model' => 'required|string|max:255',
                    'product_hsn' => 'required|string|digits_between:6,8|regex:/^\d{6,8}$/',
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
                    'package_volumetric_weight' => 'required|numeric',
                    'product_listing_status' => 'required|in:1,2,3,4',
                ];
                $variant_key = "no_variant";
                if ($request->has('no_variant')) {
                    $variant_key = "no_variant";
                } else if ($request->has('yes_variant')) {
                    $variant_key = "yes_variant";
                }
                // Define validation rules
                $rules = array_merge($rules, [
                    "$variant_key" => 'array',
                    "$variant_key.*.stock" => 'required|array|min:0',
                    "$variant_key.*.stock.*" => 'required|numeric|min:0',
                    "$variant_key.*.size" => 'required|array|min:1',
                    "$variant_key.*.size.*" => 'required|string',
                    "$variant_key.*.media" => 'required|array|min:5',
                    "$variant_key.*.media.*" => 'required|mimes:png,jpeg,jpg,mp4',
                    "$variant_key.*.color" => 'required|string',
                ]);

                // Define validation messages
                $messages = [
                    "feature" => "The feature list field is required",
                    "$variant_key.*.stock.required" => "The stock field is required when no variant is present.",
                    "$variant_key.*.stock.array" => "The stock must be an array.",
                    "$variant_key.*.stock.min" => "The stock must have at least one entry.",
                    "$variant_key.*.stock.*.required" => "Each stock entry is required and must be numeric.",
                    "$variant_key.*.stock.*.numeric" => "Each stock entry must be a number.",
                    "$variant_key.*.size.required" => "The size field is required when no variant is present.",
                    "$variant_key.*.size.array" => "The size must be an array.",
                    "$variant_key.*.size.min" => "The size must have at least one entry.",
                    "$variant_key.*.size.*.required" => "Each size entry is required.",
                    "$variant_key.*.size.*.string" => "Each size entry must be a string.",
                    "$variant_key.*.media.required" => "The media field is required when no variant is present.",
                    "$variant_key.*.media.array" => "The media must be an array.",
                    "$variant_key.*.media.min" => "The media must have at least 5 images including main image.",
                    "$variant_key.*.media.*.required" => "Each media entry is required.",
                    "$variant_key.*.media.*.mimes" => "Each media entry must be an image or video (png, jpeg, jpg, mp4).",
                    "$variant_key.*.color.required" => "The color field is required when no variant is present.",
                    "$variant_key.*.color.string" => "The color must be a string.",
                ];

                if (auth()->user()->hasRole(User::ROLE_ADMIN)) {
                    $rules['supplier_id'] = 'required|string|max:20';
                }

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {
                    $step_1 = [
                        'product_name',
                        'product_description',
                        'product_keywords',
                        'product_category',
                        'product_sub_category',
                        'feature',
                        'supplier_id',
                    ];
                    $step_2 = [
                        'dropship_rate',
                        'potential_mrp',
                        'bulk',
                        'shipping'
                    ];
                    $step_3 = [
                        'upc',
                        'isbn',
                        'mpn',
                        'model',
                        'product_hsn',
                        'gst_bracket',
                        'availability',
                        'length',
                        'width',
                        'height',
                        'dimension_class',
                        'weight',
                        'weight_class',
                        'package_length',
                        'package_width',
                        'package_height',
                        'package_dimension_class',
                        'package_weight',
                        'package_weight_class',
                        'package_volumetric_weight',
                    ];

                    if (in_array($validator->errors()->keys()[0], $step_1)) {
                        $step = 1;
                    } else if (in_array($validator->errors()->keys()[0], $step_2)) {
                        $step = 2;
                    } else if (in_array($validator->errors()->keys()[0], $step_3)) {
                        $step = 3;
                    } else {
                        $step = 4;
                    }
                    return response()->json(['data' => [
                        'statusCode' => __('statusCode.statusCode422'),
                        'status' => __('statusCode.status422'),
                        'message' => $validator->errors(),
                        'step' => $step,
                    ]], __('statusCode.statusCode200'));
                }

                $user_id = null;
                $company_id = null;
                if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
                    $user_id = auth()->user()->id;
                    $company_id = auth()->user()->companyDetails->id;
                } elseif (auth()->user()->hasRole(User::ROLE_ADMIN)) {
                    $companyDetail = CompanyDetail::where('company_serial_id', $request->supplier_id)->first();
                    if ($companyDetail) {
                        $user_id = $companyDetail->user_id;
                        $company_id = $companyDetail->id;
                    } else {
                        return response()->json(['data' => [
                            'statusCode' => __('statusCode.statusCode422'),
                            'status' => __('statusCode.status422'),
                            'message' => ['supplier_id' => [__('auth.supplierNotFound')]],
                            'step' => 1,
                        ]], __('statusCode.statusCode200'));
                    }
                } else {
                    return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
                }
                // Check if the product variation belongs to the authenticated user
                $data = $request->all();
                if ($request->has('no_variant') || $request->has('yes_variant')) {

                    // bulk order tier rate
                    if (count($data['bulk']) > 0) {
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

                    // shipping tier rate

                    $tierShippingRate = [];
                    $minRange = 1;
                    if (count($data['shipping']) > 0) {

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

                    DB::beginTransaction();
                    $product = ProductInventory::create([
                        'title' =>  $data['product_name'],
                        'description' =>  $data['product_description'],
                        'product_category' =>  salt_decrypt($data['product_category_id']),
                        'product_subcategory' => salt_decrypt($data['product_sub_category_id']),
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
                        'status' => $data['product_listing_status'] ?? ProductInventory::STATUS_INACTIVE
                    ]);

                    $product_id =  $product->id;
                    if (count($data['product_keywords']) > 0) {
                        foreach ($data['product_keywords'] as $key => $product_keyword) {
                            ProductKeyword::create([
                                'product_id' => $product_id,
                                'company_id' => $company_id,
                                'keyword' => $product_keyword
                            ]);
                        }
                    }

                    if (count($data['feature']) > 0) {
                        foreach ($data['feature'] as $key => $feature) {
                            ProductFeature::create([
                                'product_id' => $product_id,
                                'company_id' => $company_id,
                                'feature_name' => $feature,
                                'value' => $feature
                            ]);
                        }
                    }

                    $img_ext = ['png', 'jpeg', 'jpg', 'PNG', 'JPEG', 'JPG'];
                    $vide_ext = ['mp4', 'MP4'];
                    // Insert Product Variation table
                    foreach ($data[$variant_key] as $key => $value) {
                        $is_master = ProductVariationMedia::IS_MASTER_FALSE;
                        $first_image_processed = false;
                        $media_images = [];
                        foreach ($value['media'] as $k => $med) {
                            $filename = md5(Str::random(40)) . '.' . $med->getClientOriginalExtension();
                            // Get the file contents
                            $fileContents = $med->get();
                            // Define the path
                            $path = "company_{$company_id}/" . $product_id . "/documents/{$filename}";
                            if (in_array($med->getClientOriginalExtension(), $img_ext)) {
                                $path = "company_{$company_id}/" . $product_id . "/images/{$filename}";
                                $media_type = ProductVariationMedia::MEDIA_TYPE_IMAGE;
                                // Set $is_master to true only for the first image
                                if (!$first_image_processed) {
                                    $is_master = ProductVariationMedia::IS_MASTER_TRUE;
                                    $first_image_processed = true;
                                } else {
                                    $is_master = ProductVariationMedia::IS_MASTER_FALSE;
                                }
                            } else if (in_array($med->getClientOriginalExtension(), $vide_ext)) {
                                $path = "company_{$company_id}/" . $product_id . "/videos/{$filename}";
                                $media_type = ProductVariationMedia::MEDIA_TYPE_VIDEO;
                                $is_master = ProductVariationMedia::IS_MASTER_FALSE;
                            }
                            // Store the file
                            Storage::disk('public')->put($path, $fileContents);
                            $media_images[] = ['file_path' =>  $path, 'is_image' => $media_type, 'is_master' => $is_master];
                        }
                        foreach ($value['size'] as $size_key => $value1) {
                            $price = calculateInclusivePriceAndTax($data['dropship_rate'], $data['gst_bracket']);
                            $color =  !empty($value['color']) ? $value['color'] : $data[$variant_key][$key]['color'][$key];
                            // check stock array key not exist
                            $stock = 0;
                            if ($data['product_listing_status'] == ProductInventory::STATUS_OUT_OF_STOCK) {
                                $stock = 0;
                            } else {
                                if (array_key_exists($size_key, $data[$variant_key][$key]['stock'])) {
                                    $stock = $data[$variant_key][$key]['stock'][$size_key];
                                }
                            }
                            if ($data['product_listing_status'] == ProductInventory::STATUS_DRAFT) {
                                $allow_editable = ProductVariation::ALLOW_EDITABLE_TRUE;
                                $title = $request->product_name;
                            } else {
                                $allow_editable = ProductVariation::ALLOW_EDITABLE_FALSE;
                                $title = $request->product_name . ' ( ' . $color . ', ' . $value1 . ' ) ';
                            }
                            $productVariation = ProductVariation::create([
                                'product_id' => $product_id,
                                'company_id' => $company_id,
                                'product_slug_id' => '',
                                'slug' => '',
                                'sku' => generateSKU($request->product_name, $data['product_category']),
                                'size' => $value1,
                                'stock' => $stock,
                                'title' => $title,
                                'description' => $request->product_description,
                                'color' => $color,
                                'length' => $request->length,
                                'width' => $request->width,
                                'height' => $request->height,
                                'dimension_class' => $request->dimension_class,
                                'weight' => $request->weight,
                                'weight_class' => $request->weight_class,
                                'package_volumetric_weight' => $request->package_volumetric_weight,
                                'package_length' => $request->package_length,
                                'package_width' => $request->package_width,
                                'package_height' => $request->package_height,
                                'package_dimension_class' => $request->package_dimension_class,
                                'package_weight' => $request->package_weight,
                                'package_weight_class' => $request->package_weight_class,
                                'price_before_tax' =>  (float) $price['price_before_tax'],
                                'price_after_tax' =>   (float) $price['price_after_tax'],
                                'status' => $data['product_listing_status'] ?? 1,
                                'availability_status' => $request->availability,
                                'dropship_rate' => $request->dropship_rate,
                                'potential_mrp' => $request->potential_mrp,
                                'tier_rate' => json_encode($tierRate),
                                'tier_shipping_rate' => json_encode($tierShippingRate),
                                'allow_editable' => $allow_editable
                            ]);

                            $generateProductID = generateProductID($request->product_name, $productVariation->id);
                            $productVariation->product_slug_id = $generateProductID;
                            $productVariation->slug = generateSlug($request->product_name, $generateProductID);
                            $productVariation->save();

                            foreach ($media_images as $media) {
                                ProductVariationMedia::create([
                                    'product_id' => $product_id,
                                    'product_variation_id' => $productVariation->id,
                                    'media_type' => $media['is_image'],
                                    'file_path' => $media['file_path'],
                                    'is_master' => $media['is_master'],
                                    'is_active' => ProductVariationMedia::IS_ACTIVE_TRUE,
                                    'is_compressed' => ProductVariationMedia::IS_COMPRESSED_FALSE
                                ]);
                            }
                        }
                    }
                    // 
                    DB::commit();
                    $response['data'] = [
                        'statusCode' => __('statusCode.statusCode200'),
                        'status' => __('statusCode.status200'),
                        'message' => __('auth.updateStock'),
                    ];
                    // Return a success message
                    return response()->json($response);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                // Handle the exception
                return response()->json(['data' => __('statusCode.status500')], __('statusCode.statusCode500'));
            }
        } else {
            return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
        }
    }

    public function updateInventory(Request $request)
    {
        // dd($request->all());
        if (auth()->user()->hasPermissionTo(User::PERMISSION_EDIT_PRODUCT_DETAILS)) {
            try {
                $rules = [
                    'varition_id' => 'required|string',
                    'product_name' => 'required|string|max:255',
                    'product_description' => 'required|string',
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
                    'isbn' => 'nullable|string',
                    'mpn' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9- ]+$/',
                    'model' => 'required|string|max:255',
                    'product_hsn' => 'required|string|digits_between:6,8|regex:/^\d{6,8}$/',
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
                    'package_volumetric_weight' => 'required|numeric',
                    'product_listing_status' => 'required|in:1,2,3,4',
                ];
                if (auth()->user()->hasRole(User::ROLE_ADMIN)) {
                    $rules['supplier_id'] = 'required|string|max:20';
                    $rules = array_merge($rules, [
                        'product_keywords' => 'required|array',
                        'product_keywords.*' => 'string',
                        'product_category' => 'required|string|max:255',
                        'product_sub_category' => 'required|string|max:255',
                        'feature' => 'required|array',
                        'feature.*' => 'string',
                    ]);
                }
                $variant_key = "no_variant";
                if ($request->has('no_variant')) {
                    $variant_key = "no_variant";
                } else if ($request->has('yes_variant')) {
                    $variant_key = "yes_variant";
                }
                // Define validation rules
                $rules = array_merge($rules, [
                    "$variant_key" => 'array',
                    "$variant_key.*.stock" => 'required|array|min:0',
                    "$variant_key.*.stock.*" => 'required|numeric|min:0',
                    "$variant_key.*.size" => 'required|array|min:1',
                    "$variant_key.*.size.*" => 'required|string',
                    "$variant_key.*.media" => 'array|min:1',
                    "$variant_key.*.media.*" => 'mimes:png,jpeg,jpg,mp4',
                    "$variant_key.*.color" => 'required|string',
                ]);

                // Define validation messages
                $messages = [
                    "feature" => "The feature list field is required",
                    "$variant_key.*.stock.required" => "The stock field is required when no variant is present.",
                    "$variant_key.*.stock.array" => "The stock must be an array.",
                    "$variant_key.*.stock.min" => "The stock must have at least one entry.",
                    "$variant_key.*.stock.*.required" => "Each stock entry is required and must be numeric.",
                    "$variant_key.*.stock.*.numeric" => "Each stock entry must be a number.",
                    "$variant_key.*.size.required" => "The size field is required when no variant is present.",
                    "$variant_key.*.size.array" => "The size must be an array.",
                    "$variant_key.*.size.min" => "The size must have at least one entry.",
                    "$variant_key.*.size.*.required" => "Each size entry is required.",
                    "$variant_key.*.size.*.string" => "Each size entry must be a string.",
                    "$variant_key.*.media.required" => "The media field is required when no variant is present.",
                    "$variant_key.*.media.array" => "The media must be an array.",
                    "$variant_key.*.media.min" => "The media must have at least 5 images including main image.",
                    "$variant_key.*.media.*.required" => "Each media entry is required.",
                    "$variant_key.*.media.*.mimes" => "Each media entry must be an image or video (png, jpeg, jpg, mp4).",
                    "$variant_key.*.color.required" => "The color field is required when no variant is present.",
                    "$variant_key.*.color.string" => "The color must be a string.",
                ];

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {
                    $step_1 = [
                        'product_name',
                        'product_description',
                        'product_keywords',
                        'product_category',
                        'product_sub_category',
                        'feature',
                        'supplier_id',
                        'varition_id'
                    ];
                    $step_2 = [
                        'dropship_rate',
                        'potential_mrp',
                        'bulk',
                        'shipping'
                    ];
                    $step_3 = [
                        'upc',
                        'isbn',
                        'mpn',
                        'model',
                        'product_hsn',
                        'gst_bracket',
                        'availability',
                        'length',
                        'width',
                        'height',
                        'dimension_class',
                        'weight',
                        'weight_class',
                        'package_length',
                        'package_width',
                        'package_height',
                        'package_dimension_class',
                        'package_weight',
                        'package_weight_class',
                        'package_volumetric_weight',
                    ];

                    if (in_array($validator->errors()->keys()[0], $step_1)) {
                        $step = 1;
                    } else if (in_array($validator->errors()->keys()[0], $step_2)) {
                        $step = 2;
                    } else if (in_array($validator->errors()->keys()[0], $step_3)) {
                        $step = 3;
                    } else {
                        $step = 4;
                    }
                    return response()->json(['data' => [
                        'statusCode' => __('statusCode.statusCode422'),
                        'status' => __('statusCode.status422'),
                        'message' => $validator->errors(),
                        'step' => $step,
                    ]], __('statusCode.statusCode200'));
                }

                $user_id = null;
                $company_id = null;
                if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
                    $user_id = auth()->user()->id;
                    $company_id = auth()->user()->companyDetails->id;
                } elseif (auth()->user()->hasRole(User::ROLE_ADMIN)) {
                    $companyDetail = CompanyDetail::where('company_serial_id', $request->supplier_id)->first();
                    if ($companyDetail) {
                        $user_id = $companyDetail->user_id;
                        $company_id = $companyDetail->id;
                    } else {
                        return response()->json(['data' => [
                            'statusCode' => __('statusCode.statusCode422'),
                            'status' => __('statusCode.status422'),
                            'message' => ['supplier_id' => [__('auth.supplierNotFound')]],
                            'step' => 1,
                        ]], __('statusCode.statusCode200'));
                    }
                } else {
                    return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
                }

                // Check if the product variation belongs to the authenticated user
                $data = $request->all();
                if ($request->has('no_variant') || $request->has('yes_variant')) {

                    // bulk order tier rate
                    if (count($data['bulk']) > 0) {
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

                    // shipping tier rate

                    $tierShippingRate = [];
                    $minRange = 1;
                    if (count($data['shipping']) > 0) {

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

                    DB::beginTransaction();
                    $productVariation = ProductVariation::where('id', salt_decrypt($data['varition_id']))->first();
                    if (empty($productVariation)) {
                        return response()->json(['data' => __('auth.variantNotFound')], __('statusCode.statusCode200'));
                    }
                    $product_id = $productVariation->product_id;

                    // add logic if record is draft
                    if (($productVariation->status == ProductInventory::STATUS_DRAFT) && $productVariation->allow_editable) {
                        $product = ProductInventory::where('id', $product_id)->first();
                        $product->title =  $data['product_name'];
                        $product->description =  $data['product_description'];
                        $product->product_category =  salt_decrypt($data['product_category_id']);
                        $product->product_subcategory = salt_decrypt($data['product_sub_category_id']);
                        $product->company_id =  $company_id;
                        $product->user_id = $user_id;
                        $product->model =  $data['model'];
                        $product->hsn =  $data['product_hsn'];
                        $product->gst_percentage =  $data['gst_bracket'];
                        $product->upc =  $data['upc'] ?? null;
                        $product->isbn =  $data['isbn'] ?? null;
                        $product->mpin =  $data['mpn'] ?? null;
                        $product->gst_percentage =  $data['gst_bracket'];
                        $product->availability_status = $data['availability'];
                        $product->status = $data['product_listing_status'] ?? ProductInventory::STATUS_INACTIVE;
                        $product->save();

                        $product_id =  $product->id;
                        ProductKeyword::where('product_id', $product_id)->delete();
                        if (count($data['product_keywords']) > 0) {
                            foreach ($data['product_keywords'] as $key => $product_keyword) {
                                ProductKeyword::create([
                                    'product_id' => $product_id,
                                    'company_id' => $company_id,
                                    'keyword' => $product_keyword
                                ]);
                            }
                        }

                        ProductFeature::where('product_id', $product_id)->delete();
                        if (count($data['feature']) > 0) {
                            foreach ($data['feature'] as $key => $feature) {
                                ProductFeature::create([
                                    'product_id' => $product_id,
                                    'company_id' => $company_id,
                                    'feature_name' => $feature,
                                    'value' => $feature
                                ]);
                            }
                        }

                        
                        $img_ext = ['png', 'jpeg', 'jpg', 'PNG', 'JPEG', 'JPG'];
                        $vide_ext = ['mp4', 'MP4'];
                        $existingMedia = ProductVariationMedia::where('product_id', $product_id)->where('product_variation_id', $productVariation->id)->get();
                        $update_only_first_record = true;
                        $update_only_first_media_record = true;
                        // Iterate through the product variations
                        foreach ($data[$variant_key] as $key => $value) {
                            // Upload media files
                            $is_master = ProductVariationMedia::IS_MASTER_FALSE;
                            $first_image_processed = false;
                            $media_images = [];
                                if (isset($value['media'])) {
                                    foreach ($value['media'] as $k => $med) {
                                        $filename = md5(Str::random(40)) . '.' . $med->getClientOriginalExtension();
                                        // Get the file contents
                                        $fileContents = $med->get();
                                        // Define the path
                                        $path = "company_{$company_id}/" . $product_id . "/documents/{$filename}";
                                        if (in_array($med->getClientOriginalExtension(), $img_ext)) {
                                            $path = "company_{$company_id}/" . $product_id . "/images/{$filename}";
                                            $media_type = ProductVariationMedia::MEDIA_TYPE_IMAGE;
                                            // Set $is_master to true only for the first image
                                            if (!$first_image_processed) {
                                                $is_master = ProductVariationMedia::IS_MASTER_TRUE;
                                                $first_image_processed = true;
                                            } else {
                                                $is_master = ProductVariationMedia::IS_MASTER_FALSE;
                                            }
                                        } else if (in_array($med->getClientOriginalExtension(), $vide_ext)) {
                                            $path = "company_{$company_id}/" . $product_id . "/videos/{$filename}";
                                            $media_type = ProductVariationMedia::MEDIA_TYPE_VIDEO;
                                            $is_master = ProductVariationMedia::IS_MASTER_FALSE;
                                        }
                                        // Store the file
                                        Storage::disk('public')->put($path, $fileContents);
                                        $media_images[] = ['file_path' =>  $path, 'is_image' => $media_type, 'is_master' => $is_master];
                                    }
                                }

                                // Insert Product Variation table
                                foreach ($value['size'] as $size_key => $value1) {
                                    $price = calculateInclusivePriceAndTax($data['dropship_rate'], $data['gst_bracket']);
                                    $color =  !empty($value['color']) ? $value['color'] : $data[$variant_key][$key]['color'][$key];
                                    // check stock array key not exist
                                    $stock = 0;
                                    if ($data['product_listing_status'] == ProductInventory::STATUS_OUT_OF_STOCK) {
                                        $stock = 0;
                                    } else {
                                        if (array_key_exists($size_key, $data[$variant_key][$key]['stock'])) {
                                            $stock = $data[$variant_key][$key]['stock'][$size_key];
                                        }
                                    }
                                    if ($data['product_listing_status'] == ProductInventory::STATUS_DRAFT) {
                                        $allow_editable = ProductVariation::ALLOW_EDITABLE_TRUE;
                                    } else {
                                        $allow_editable = ProductVariation::ALLOW_EDITABLE_FALSE;
                                    }
                                    if($productVariation && $update_only_first_record){
                                        $productVariation->product_id = $product_id;
                                        $productVariation->company_id = $company_id;
                                        $productVariation->size = $value1;
                                        $productVariation->stock = $stock;
                                        if ($data['product_listing_status'] == ProductInventory::STATUS_DRAFT) {
                                            $productVariation->title = $request->product_name;
                                        }else{
                                        $productVariation->title = $request->product_name . ' ( ' . $color . ', ' . $value1 . ' ) ';
                                        }
                                        $productVariation->description = $request->product_description;
                                        $productVariation->color = $color;
                                        $productVariation->length = $request->length;
                                        $productVariation->width = $request->width;
                                        $productVariation->height = $request->height;
                                        $productVariation->dimension_class = $request->dimension_class;
                                        $productVariation->weight = $request->weight;
                                        $productVariation->weight_class = $request->weight_class;
                                        $productVariation->package_volumetric_weight = $request->package_volumetric_weight;
                                        $productVariation->package_length = $request->package_length;
                                        $productVariation->package_width = $request->package_width;
                                        $productVariation->package_height = $request->package_height;
                                        $productVariation->package_dimension_class = $request->package_dimension_class;
                                        $productVariation->package_weight = $request->package_weight;
                                        $productVariation->package_weight_class = $request->package_weight_class;
                                        $productVariation->price_before_tax = (float) $price['price_before_tax'];
                                        $productVariation->price_after_tax = (float) $price['price_after_tax'];
                                        $productVariation->status = $data['product_listing_status'] ?? ProductVariation::STATUS_ACTIVE;
                                        $productVariation->availability_status = $request->availability;
                                        $productVariation->dropship_rate = $request->dropship_rate;
                                        $productVariation->potential_mrp = $request->potential_mrp;
                                        $productVariation->tier_rate = json_encode($tierRate);
                                        $productVariation->tier_shipping_rate = json_encode($tierShippingRate);
                                        $productVariation->allow_editable = $allow_editable;
                                        $productVariation->save();
                                        $update_only_first_record = false;
                                    }else{
                                        $productVariation = ProductVariation::create([
                                            'product_id' => $product_id,
                                            'company_id' => $company_id,
                                            'product_slug_id' => '',
                                            'slug' => '',
                                            'sku' => generateSKU($request->product_name, $data['product_category']),
                                            'size' => $value1,
                                            'stock' => $stock,
                                            'title' => $request->product_name . ' ( ' . $color . ', ' . $value1 . ' ) ',
                                            'description' => $request->product_description,
                                            'color' => $color,
                                            'length' => $request->length,
                                            'width' => $request->width,
                                            'height' => $request->height,
                                            'dimension_class' => $request->dimension_class,
                                            'weight' => $request->weight,
                                            'weight_class' => $request->weight_class,
                                            'package_volumetric_weight' => $request->package_volumetric_weight,
                                            'package_length' => $request->package_length,
                                            'package_width' => $request->package_width,
                                            'package_height' => $request->package_height,
                                            'package_dimension_class' => $request->package_dimension_class,
                                            'package_weight' => $request->package_weight,
                                            'package_weight_class' => $request->package_weight_class,
                                            'price_before_tax' =>  (float) $price['price_before_tax'],
                                            'price_after_tax' =>   (float) $price['price_after_tax'],
                                            'status' => $data['product_listing_status'] ?? ProductVariation::STATUS_ACTIVE,
                                            'availability_status' => $request->availability,
                                            'dropship_rate' => $request->dropship_rate,
                                            'potential_mrp' => $request->potential_mrp,
                                            'tier_rate' => json_encode($tierRate),
                                            'tier_shipping_rate' => json_encode($tierShippingRate),
                                            'allow_editable' => $allow_editable
                                        ]);
            
                                        $generateProductID = generateProductID($request->product_name, $productVariation->id);
                                        $productVariation->product_slug_id = $generateProductID;
                                        $productVariation->slug = generateSlug($request->product_name, $generateProductID);
                                        $productVariation->save();

                                    }
                                    // Insertor Update Product Variation Media table
                                    if(!empty($media_images)){
                                        foreach ($media_images as $media_key => $media) {
                                            $where = [];
                                            if (isset($existingMedia[$media_key]) && $update_only_first_media_record) {
                                                $where = ['id' => $existingMedia[$media_key]['id'], 'product_variation_id' => $productVariation->id];
                                                // Remove the original file
                                                $img1 = str_replace('storage/', '', $existingMedia[$media_key]['file_path']);
                                                $img1 = storage_path('app/public/' . $img1);
                                                $img2 = str_replace('storage/', '', $existingMedia[$media_key]['thumbnail_path']);
                                                $img2 = storage_path('app/public/' . $img2);
                                                if (File::exists($img1) && !empty($img1)) {
                                                    File::delete($img1);
                                                }
                                                if (File::exists($img2) && !empty($img2)) {
                                                    File::delete($img2);
                                                }
        
                                                ProductVariationMedia::where($where)->update([
                                                    'product_id' => $product_id,
                                                    'product_variation_id' => $productVariation->id,
                                                    'media_type' => $media['is_image'],
                                                    'file_path' => $media['file_path'],
                                                    'is_master' => $media['is_master'],
                                                    'thumbnail_path' => null,
                                                    'is_active' => ProductVariationMedia::IS_ACTIVE_TRUE,
                                                    'is_compressed' => ProductVariationMedia::IS_COMPRESSED_FALSE
                                                ]);
                                            } else {
                                                ProductVariationMedia::create([
                                                    'product_id' => $product_id,
                                                    'product_variation_id' => $productVariation->id,
                                                    'media_type' => $media['is_image'],
                                                    'file_path' => $media['file_path'],
                                                    'is_master' => $media['is_master'],
                                                    'thumbnail_path' => null,
                                                    'is_active' => ProductVariationMedia::IS_ACTIVE_TRUE,
                                                    'is_compressed' => ProductVariationMedia::IS_COMPRESSED_FALSE
                                                ]);
                                            }
                                        }
                                        $update_only_first_media_record = false;
                                    }
                                }
                        }
                    } else {
                        if (auth()->user()->hasRole(User::ROLE_ADMIN)) {
                            $product = ProductInventory::where('id', $product_id)->first();
                            $product->description =  $data['product_description'];
                            $product->product_category =  salt_decrypt($data['product_category_id']);
                            $product->product_subcategory = salt_decrypt($data['product_sub_category_id']);
                            $product->company_id =  $company_id;
                            $product->user_id = $user_id;
                            $product->model =  $data['model'];
                            $product->hsn =  $data['product_hsn'];
                            $product->gst_percentage =  $data['gst_bracket'];
                            $product->upc =  $data['upc'] ?? null;
                            $product->isbn =  $data['isbn'] ?? null;
                            $product->mpin =  $data['mpn'] ?? null;
                            $product->gst_percentage =  $data['gst_bracket'];
                            $product->availability_status = $data['availability'];
                            $product->status = $data['product_listing_status'] ?? ProductInventory::STATUS_INACTIVE;
                            $product->save();

                            $product_id =  $product->id;
                            ProductKeyword::where('product_id', $product_id)->delete();
                            if (count($data['product_keywords']) > 0) {
                                foreach ($data['product_keywords'] as $key => $product_keyword) {
                                    ProductKeyword::create([
                                        'product_id' => $product_id,
                                        'company_id' => $company_id,
                                        'keyword' => $product_keyword
                                    ]);
                                }
                            }

                            ProductFeature::where('product_id', $product_id)->delete();
                            if (count($data['feature']) > 0) {
                                foreach ($data['feature'] as $key => $feature) {
                                    ProductFeature::create([
                                        'product_id' => $product_id,
                                        'company_id' => $company_id,
                                        'feature_name' => $feature,
                                        'value' => $feature
                                    ]);
                                }
                            }
                        }

                        $img_ext = ['png', 'jpeg', 'jpg', 'PNG', 'JPEG', 'JPG'];
                        $vide_ext = ['mp4', 'MP4'];
                        $existingMedia = ProductVariationMedia::where('product_id', $product_id)->where('product_variation_id', $productVariation->id)->get();

                        // Insert Product Variation table
                        foreach ($data[$variant_key] as $key => $value) {
                            $media_images = [];
                            if (isset($value['media'])) {
                                foreach ($value['media'] as $k => $med) {
                                    $filename = md5(Str::random(40)) . '.' . $med->getClientOriginalExtension();
                                    // Get the file contents
                                    $fileContents = $med->get();
                                    // Define the path
                                    $path = "company_{$company_id}/" . $product_id . "/documents/{$filename}";
                                    if (in_array($med->getClientOriginalExtension(), $img_ext)) {
                                        $path = "company_{$company_id}/" . $product_id . "/images/{$filename}";
                                        $media_type = ProductVariationMedia::MEDIA_TYPE_IMAGE;
                                    } else if (in_array($med->getClientOriginalExtension(), $vide_ext)) {
                                        $path = "company_{$company_id}/" . $product_id . "/videos/{$filename}";
                                        $media_type = ProductVariationMedia::MEDIA_TYPE_VIDEO;
                                    }
                                    // Store the file
                                    Storage::disk('public')->put($path, $fileContents);
                                    $media_images[$k] = ['file_path' =>  $path, 'is_image' => $media_type];
                                }
                            }
                            foreach ($value['size'] as $size_key => $value1) {
                                $price = calculateInclusivePriceAndTax($data['dropship_rate'], $data['gst_bracket']);
                                $color =  !empty($value['color']) ? $value['color'] : $data[$variant_key][$key]['color'][$key];
                                // check stock array key not exist
                                $stock = 0;
                                if ($data['product_listing_status'] == ProductInventory::STATUS_OUT_OF_STOCK) {
                                    $stock = 0;
                                } else {
                                    if (array_key_exists($size_key, $data[$variant_key][$key]['stock'])) {
                                        $stock = $data[$variant_key][$key]['stock'][$size_key];
                                    }
                                }

                                if ($productVariation) {
                                    $productVariation->product_id = $product_id;
                                    $productVariation->company_id = $company_id;
                                    $productVariation->size = $value1;
                                    $productVariation->stock = $stock;
                                    $productVariation->title = $request->product_name;
                                    $productVariation->description = $request->product_description;
                                    $productVariation->color = $color;
                                    $productVariation->length = $request->length;
                                    $productVariation->width = $request->width;
                                    $productVariation->height = $request->height;
                                    $productVariation->dimension_class = $request->dimension_class;
                                    $productVariation->weight = $request->weight;
                                    $productVariation->weight_class = $request->weight_class;
                                    $productVariation->package_volumetric_weight = $request->package_volumetric_weight;
                                    $productVariation->package_length = $request->package_length;
                                    $productVariation->package_width = $request->package_width;
                                    $productVariation->package_height = $request->package_height;
                                    $productVariation->package_dimension_class = $request->package_dimension_class;
                                    $productVariation->package_weight = $request->package_weight;
                                    $productVariation->package_weight_class = $request->package_weight_class;
                                    $productVariation->price_before_tax = (float) $price['price_before_tax'];
                                    $productVariation->price_after_tax = (float) $price['price_after_tax'];
                                    $productVariation->status = $data['product_listing_status'] ?? 1;
                                    $productVariation->availability_status = $request->availability;
                                    $productVariation->dropship_rate = $request->dropship_rate;
                                    $productVariation->potential_mrp = $request->potential_mrp;
                                    $productVariation->tier_rate = json_encode($tierRate);
                                    $productVariation->tier_shipping_rate = json_encode($tierShippingRate);
                                    $productVariation->save();
                                }
                            }
                            foreach ($media_images as $key => $media) {
                                $where = [];
                                if (isset($existingMedia[$key])) {
                                    $where = ['id' => $existingMedia[$key]['id'], 'product_variation_id' => $productVariation->id];
                                    // Remove the original file
                                    $img1 = str_replace('storage/', '', $existingMedia[$key]['file_path']);
                                    $img1 = storage_path('app/public/' . $img1);
                                    $img2 = str_replace('storage/', '', $existingMedia[$key]['thumbnail_path']);
                                    $img2 = storage_path('app/public/' . $img2);
                                    if (File::exists($img1) && !empty($img1)) {
                                        File::delete($img1);
                                    }
                                    if (File::exists($img2) && !empty($img2)) {
                                        File::delete($img2);
                                    }

                                    ProductVariationMedia::where($where)->update([
                                        'product_id' => $product_id,
                                        'product_variation_id' => $productVariation->id,
                                        'media_type' => $media['is_image'],
                                        'file_path' => $media['file_path'],
                                        'thumbnail_path' => null,
                                        'is_active' => ProductVariationMedia::IS_ACTIVE_TRUE,
                                        'is_compressed' => ProductVariationMedia::IS_COMPRESSED_FALSE
                                    ]);
                                } else {
                                    ProductVariationMedia::create([
                                        'product_id' => $product_id,
                                        'product_variation_id' => $productVariation->id,
                                        'media_type' => $media['is_image'],
                                        'file_path' => $media['file_path'],
                                        'thumbnail_path' => null,
                                        'is_active' => ProductVariationMedia::IS_ACTIVE_TRUE,
                                        'is_compressed' => ProductVariationMedia::IS_COMPRESSED_FALSE
                                    ]);
                                }
                            }
                        }
                    }
                    //
                    DB::commit();
                    $response['data'] = [
                        'statusCode' => __('statusCode.statusCode200'),
                        'status' => __('statusCode.status200'),
                        'message' => __('auth.productInventoryUpdate'),
                    ];
                    // Return a success message
                    return response()->json($response);
                }
            } catch (\Exception $e) {
                dd($e->getMessage(), $e->getLine());
                // Handle the exception
                return response()->json(['data' => __('statusCode.status500')], __('statusCode.statusCode500'));
            }
        } else {
            return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
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
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|string',
                'stock' => 'required|integer|min:0'
            ]);
            $variation_id = salt_decrypt($variation_id);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first()
                ]], __('statusCode.statusCode200'));
            }

            // Find the product variation
            $variation = ProductVariation::where(['id' => $variation_id, 'product_slug_id' => $request->input('product_id')])->firstOrFail();

            if (auth()->user()->hasRole(User::ROLE_SUPPLIER) && auth()->user()->hasPermissionTo(User::PERMISSION_EDIT_PRODUCT_DETAILS)) {
                // Check if the product variation belongs to the authenticated user
                if ($variation->product->user_id !== auth()->user()->id) {
                    abort(403, 'Unauthorized action.');
                }
                // Update the stock of the product variation
                $variation->stock = $request->input('stock');
                if ($request->input('stock') == 0) {
                    $variation->status = ProductVariation::STATUS_OUT_OF_STOCK;
                } else {
                    $variation->status = ProductVariation::STATUS_ACTIVE;
                }
                $variation->save();

                $response['data'] = [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.updateStock'),
                ];
                // Return a success message
                return response()->json($response);
            } elseif (auth()->user()->hasRole(User::ROLE_ADMIN) && auth()->user()->hasPermissionTo(User::PERMISSION_EDIT_PRODUCT_DETAILS)) {
                // Update the stock of the product variation
                $variation->stock = $request->input('stock');
                if ($request->input('stock') == 0) {
                    $variation->status = ProductVariation::STATUS_OUT_OF_STOCK;
                } else {
                    $variation->status = ProductVariation::STATUS_ACTIVE;
                }
                $variation->save();

                $response['data'] = [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.updateStock'),
                ];
                // Return a success message
                return response()->json($response);
            } else {
                return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
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
            if (auth()->user()->hasRole(User::ROLE_SUPPLIER) && auth()->user()->hasPermissionTo(User::PERMISSION_EDIT_PRODUCT_DETAILS)) {
                // Check if the product variation belongs to the authenticated user
                if ($variation->product->user_id !== auth()->user()->id) {
                    abort(403, 'Unauthorized action.');
                }
                // Update the status of the product variation
                $variation->status = $request->input('status');
                if ($request->input('status') == ProductVariation::STATUS_OUT_OF_STOCK) {
                    $variation->stock = 0;
                }
                $variation->save();
                $response['data'] = [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.updateStatus'),
                ];
                // Return a success message
                return response()->json($response);
            } elseif (auth()->user()->hasRole(User::ROLE_ADMIN) && auth()->user()->hasPermissionTo(User::PERMISSION_EDIT_PRODUCT_DETAILS)) {
                // Update the status of the product variation
                $variation->status = $request->input('status');
                if ($request->input('status') == ProductVariation::STATUS_OUT_OF_STOCK) {
                    $variation->stock = 0;
                }
                $variation->save();

                $response['data'] = [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.updateStatus'),
                ];
                // Return a success message
                return response()->json($response);
            } else {
                return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
            }
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['data' => __('auth.updateStatusFailed')], __('statusCode.statusCode500'));
        }
    }

    /**
     * Get bulk inventory data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataBulkInventory(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $searchTerm = $request->input('query', null);
            $sort = $request->input('sort', 'id'); // Default sort by 'title'
            $sortOrder = $request->input('order', 'desc'); // Default sort direction 'asc'
            $sort_by_status = (int) $request->input('sort_by_status', '0'); // Default sort by 'all'

            // Allowed sort fields to prevent SQL injection
            $allowedSorts = ['processed_records', 'failed_records', 'status'];
            $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

            if (auth()->user()->hasRole(User::ROLE_SUPPLIER) && auth()->user()->hasPermissionTo(User::PERMISSION_LIST_PRODUCT)) {
                // Get the authenticated user's ID
                $company_id = auth()->user()->companyDetails->id;
                // Eager load product variations with product inventory that matches user_id
                $bulkData = Import::where('company_id', $company_id);

                if ($sort_by_status != 0) {
                    $bulkData = $bulkData->where('status', $sort_by_status);
                }
                $bulkData = $bulkData->when($searchTerm, function ($query) use ($searchTerm) {
                    $query->where(function ($query) use ($searchTerm) {
                        $query->where('filename', 'like', '%' . $searchTerm . '%')
                            ->orWhere('success_count', 'like', '%' . $searchTerm . '%')
                            ->orWhere('type', 'like', '%' . $searchTerm . '%');
                    });
                })->orderBy($sort, $sortOrder) // Apply sorting
                    ->paginate($perPage); // Paginate results


            } elseif (auth()->user()->hasRole(User::ROLE_ADMIN) && auth()->user()->hasPermissionTo(User::PERMISSION_LIST_PRODUCT)) {
                // Eager load product variations with product inventory that matches user_id
                $bulkData = Import::when($searchTerm, function ($query) use ($searchTerm) {
                    $query->where(function ($query) use ($searchTerm) {
                        $query->where('filename', 'like', '%' . $searchTerm . '%')
                            ->orWhere('success_count', 'like', '%' . $searchTerm . '%')
                            ->orWhere('type', 'like', '%' . $searchTerm . '%');
                    });
                });
                if ($sort_by_status != 0) {
                    $bulkData = $bulkData->where('status', $sort_by_status);
                }
                $bulkData = $bulkData->orderBy($sort, $sortOrder) // Apply sorting
                    ->paginate($perPage); // Paginate results
            } else {
                return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
            }
            // Transform the paginated results using Fractal
            $resource = new Collection($bulkData, new BulkDataTransformer());

            // Add pagination information to the resource
            $resource->setPaginator(new IlluminatePaginatorAdapter($bulkData));

            // Create the data array using Fractal
            $data = $this->fractal->createData($resource)->toArray();

            // Return the JSON response with paginated data
            return response()->json($data);
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['data' =>  __('auth.productInventoryShowFailed')], __('statusCode.statusCode500'));
        }
    }
}

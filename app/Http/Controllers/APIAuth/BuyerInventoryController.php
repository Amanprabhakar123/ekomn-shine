<?php

namespace App\Http\Controllers\APIAuth;

use ZipArchive;
use App\Models\User;
use League\Fractal\Manager;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Events\ExceptionEvent;
use App\Models\BuyerInventory;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use App\Models\ChannelProductMap;
use App\Traits\SubscriptionTrait;
use App\Http\Controllers\Controller;
use App\Models\CompanyPlanPermission;
use App\Models\ProductVariationMedia;
use App\Services\UserActivityService;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Validator;
use App\Transformers\BuyerInventoryTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class BuyerInventoryController extends Controller
{
    use SubscriptionTrait;
    
    protected $fractal;

    protected $BulkDataTransformer;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * Retrieve the paginated buyer inventory data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            // Get the authenticated user's ID
            $userId = auth()->user()->id;
            $perPage = $request->input('per_page', 10);
            $searchTerm = $request->input('query', null);
            $sort = $request->input('sort', 'id'); // Default sort by 'id'
            $sortOrder = $request->input('order', 'desc'); // Default sort direction 'desc'
            $sort_by_status = (int) $request->input('sort_by_status', '0'); // Default sort by 'all'

            // Allowed sort fields to prevent SQL injection
            $allowedSorts = ['title', 'sku', 'price_after_tax', 'stock', 'product_slug_id', 'name'];
            $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

            if (auth()->user()->hasRole(User::ROLE_BUYER)) {
                // Initialize the BuyerInventory query
                $buyerInventory = BuyerInventory::where('buyer_id', $userId);

                if ($sort_by_status != 0) {
                    $buyerInventory = $buyerInventory->whereHas('product', function ($query) use ($sort_by_status) {
                        $query->where('status', $sort_by_status);
                    });
                }

                if ($searchTerm) {
                    $buyerInventory = $buyerInventory->whereHas('product', function ($query) use ($searchTerm) {
                        $query->where('title', 'like', '%'.$searchTerm.'%')
                            ->orWhere('sku', 'like', '%'.$searchTerm.'%')
                            ->orWhere('product_slug_id', 'like', '%'.$searchTerm.'%')
                            ->orWhereHas('product.category', function ($query) use ($searchTerm) {
                                $query->where('name', 'like', '%'.$searchTerm.'%');
                            });
                    });
                }

                $buyerInventory = $buyerInventory->with([
                    'product',
                    'product.media',
                    'product.product.category',
                    'product.salesChannelProductMaps',
                ]);

                // Handle sorting by category name
                $buyerInventory = $buyerInventory->join('product_variations', 'buyer_inventories.product_id', '=', 'product_variations.id')
                    ->join('product_inventories', 'product_variations.product_id', '=', 'product_inventories.id')
                    ->join('categories', 'product_inventories.product_category', '=', 'categories.id')
                    ->select('buyer_inventories.*');

                if ($sort == 'name') {
                    $buyerInventory = $buyerInventory->orderBy('categories.name', $sortOrder);
                } else {
                    $buyerInventory = $buyerInventory->orderBy('product_variations.'.$sort, $sortOrder);
                }

                // Paginate results
                $buyerInventory = $buyerInventory->paginate($perPage);

                // Transform the paginated results using Fractal
                $resource = new Collection($buyerInventory, new BuyerInventoryTransformer);

                // Add pagination information to the resource
                $resource->setPaginator(new IlluminatePaginatorAdapter($buyerInventory));

                // Create the data array using Fractal
                $data = $this->fractal->createData($resource)->toArray();

                // Return the JSON response with paginated data
                return response()->json($data);
            } else {
                return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
            }
        } catch (\Exception $e) {
            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            // Handle the exception
            return response()->json(['data' => __('auth.productInventoryShowFailed')], __('statusCode.statusCode500'));
        }
    }

    /**
     * Add a product to the buyer's inventory.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|array',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data' => [
                        'statusCode' => __('statusCode.statusCode422'),
                        'status' => __('statusCode.status422'),
                        'message' => $validator->errors()->first(),
                    ],
                ], __('statusCode.statusCode200'));
            }

            // Check if the user is authenticated
            if (! auth()->check()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizeLogin'),
                ]], __('statusCode.statusCode200'));
            }

            // Get the authenticated user's ID
            $userId = auth()->user()->id;

            // Check if the user has the buyer role
            if (! auth()->user()->hasRole(User::ROLE_BUYER)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }

            $encryptedProductIds = $request->product_id['variation_id'];
            $productIds = [];
            $existingProductIds = [];
            
            // add plan permission for inventory count
            $variation_ids = array_map('salt_decrypt', $encryptedProductIds);
            $count = $this->getInventoryCount($variation_ids);
            $status = $this->isBuyerAddedInventoryCount(auth()->user()->companyDetails->id, $count);
            if($status['data']['statusCode'] == __('statusCode.statusCode422')){
                return response()->json(['data' => $status['data']], __('statusCode.statusCode200'));
            }

            foreach ($encryptedProductIds as $encryptedProductId) {
                $productId = salt_decrypt($encryptedProductId);
                $product = ProductVariation::find($productId);

                if (! $product) {
                    return response()->json([
                        'data' => [
                            'statusCode' => __('statusCode.statusCode404'),
                            'status' => __('statusCode.status404'),
                            'message' => __('auth.productNotFound'),
                        ],
                    ], __('statusCode.statusCode200'));
                }

                $productIds[] = $product->id;
            }

            // Fetch existing products in buyer's inventory in a single query
            $existingProductIds = BuyerInventory::where('buyer_id', $userId)
                ->whereIn('product_id', $productIds)
                ->pluck('product_id')
                ->toArray();

            // Filter out products that are already in the buyer's inventory
            $newProductIds = array_diff($productIds, $existingProductIds);

            $userActivityService = new UserActivityService;
            
            // Prepare the data for bulk insert
            $insertData = [];
            foreach ($newProductIds as $productId) {
                $product = ProductVariation::find($productId);
                // Log the user add to inventory activity
                $userActivityService->logActivity($productId, UserActivity::ACTIVITY_TYPE_ADD_TO_INVENTORY);
                $insertData[] = [
                    'buyer_id' => $userId,
                    'product_id' => $product->id,
                    'company_id' => $product->company_id,
                    'added_to_inventory_at' => now(),
                    'created_at' => now(),   // Manually set created_at
                    'updated_at' => now(),   // Manually set updated_at
                ];
            }

            // Insert new records in bulk if there are any
            if (! empty($insertData)) {
                BuyerInventory::insert($insertData);
            }

            // Return a success message
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.addBuyerInventory'),
                ],
            ], __('statusCode.statusCode200'));

        } catch (\Exception $e) {
            // Log the exception details and trigger an ExceptionEvent
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            // Handle the exception
            return response()->json([
                'data' => __('auth.addBuyerInventoryFailed'),
            ], __('statusCode.statusCode500'));
        }
    }

    /**
     * Get the inventory data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        try {
            // Validate the request data
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|string',
            ]);
            $id = salt_decrypt($id);
            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status400'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode400'));
            }
            // Find the product variation
            if (auth()->user()->hasRole(User::ROLE_BUYER)) {
                BuyerInventory::where(['id' => $id])->delete();
                // Update Inventory Count Company Plan Permission
                $company_id = auth()->user()->companyDetails->id;
                $inventory_count = $this->getMyInventoryCount();
                CompanyPlanPermission::where('company_id', $company_id)->update(['inventory_count' => $inventory_count]);
                $response['data'] = [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.removeBuyerInventory'),
                ];

                // Return a success message
                return response()->json($response);
            } else {
                return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
            }
        } catch (\Exception $e) {
            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            // Handle the exception
            return response()->json(['data' => __('auth.removeBuyerInventoryFailed')], __('statusCode.statusCode500'));
        }
    }

    /**
     * Export the product variation data to a CSV file.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function exportProductVariationData(Request $request)
    {
        try {
            if (! auth()->check()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode403'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizeLogin'),
                ]], __('statusCode.statusCode403'));
            }
            
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'variation_id' => 'required|array',
                'variation_id.*' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode422'));
            }

            // Decrypt the product variation IDs
            $decryptedVariationIds = [];
            foreach ($request->variation_id as $variationId) {
                $decryptedVariationIds[] = salt_decrypt($variationId);
            }

            if ( auth()->user()->hasRole(User::ROLE_BUYER)) {
                $count = count(array_unique($decryptedVariationIds));
                $company_id = auth()->user()->companyDetails->id;
                $status = $this->isBuyerDownloadCount($company_id, $count);
                if ($status['data']['statusCode'] == __('statusCode.statusCode422')) {
                    return response()->json(['data' => $status['data']], __('statusCode.statusCode422'));
                }

            }

            // Find the product variations
            $allProductVariations = ProductVariation::whereIn('id', $decryptedVariationIds)->get();

            if ($allProductVariations->isEmpty()) {
                return response()->json(['data' => __('auth.productNotFound')], __('statusCode.statusCode404'));
            }

            // Initialize CSV data array with headers
            $csvData = [
                [
                    'PRODUCT_NAME',
                    'DESCRIPTION',
                    'PRODUCT_KEYWORDS',
                    'PRODUCT_FEATURES',
                    'SKU',
                    'MODEL',
                    'PRODUCT_HSN',
                    'GST_BRACKET',
                    'AVAILABILITY',
                    'UPC',
                    'ISBN',
                    'MPN',
                    'LENGTH',
                    'WIDTH',
                    'HEIGHT',
                    'PRODUCT_DIMENSION_UNIT',
                    'WEIGHT',
                    'PRODUCT_WEIGHT_UNIT',
                    'PACKAGE_LENGTH',
                    'PACKAGE_WIDTH',
                    'PACKAGE_HEIGHT',
                    'PACKAGE_WEIGHT',
                    'PACKAGE_DIMENSION_UNIT',
                    'PACKAGE_WEIGHT_UNIT',
                    'SELLING_PRICE',
                    'POTENTIAL_MRP',
                    'COLOR',
                    'SIZE',
                    'PRODUCT_STOCK',
                    'CATEGORY',
                    'SUB_CATEGORY',
                ],
            ];
            $time = time();
            // Generate a unique base path for storing the files
            $basePath = 'storage/export/'.auth()->user()->id.'/product_data_'.$time;
            if (! file_exists($basePath)) {
                mkdir($basePath, 0777, true);
            }
           
            $userActivityService = new UserActivityService;
            // Process each product variation
            foreach ($allProductVariations as $key => $productVariation) {
                // check auth user role
                if ( auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
                    if(auth()->user()->companyDetails->company_serial_id == $productVariation->company_id){
                        return response()->json(['data' => [
                            'statusCode' => __('statusCode.statusCode403'),
                            'status' => __('statusCode.status422'),
                            'message' => __('auth.otherSupplierProduct'),
                        ]], __('statusCode.statusCode403'));
                    }
                }
                // Log the download activity
                $userActivityService->logActivity($productVariation->id, UserActivity::ACTIVITY_TYPE_DOWNLOAD);
                $product = $productVariation->product;
                $productVariationList = $product->variations;
                $productCategory = $product->category;
                $productSubCategory = $product->subCategory;
                $productKeywords = $product->keywords;
                $productFeatures = $product->features;
                $media = $productVariation->media->where('is_compressed', ProductVariationMedia::IS_COMPRESSED_TRUE);
                $video = $productVariation->media->where('media_type', ProductVariationMedia::MEDIA_TYPE_VIDEO);

                // Add data for each product variation
                foreach ($productVariationList as $variation) {
                    $csvData[] = [
                        $variation->title,
                        $variation->description,
                        implode(', ', $productKeywords->pluck('keyword')->toArray()),
                        implode(', ', $productFeatures->pluck('value')->toArray()),
                        $variation->sku,
                        $product->model,
                        $product->hsn,
                        $product->gst_percentage,
                        ($variation->availability_status == ProductInventory::TILL_STOCK_LAST) ? 'Till Stock Last' : 'Regular Available',
                        $product->upc,
                        $product->isbn,
                        $product->mpn,
                        $variation->length,
                        $variation->width,
                        $variation->height,
                        $variation->dimension_class,
                        $variation->weight,
                        $variation->weight_class,
                        $variation->package_length,
                        $variation->package_width,
                        $variation->package_height,
                        $variation->package_weight,
                        $variation->package_dimension_class,
                        $variation->package_weight_class,
                        $variation->price_after_tax,
                        $variation->potential_mrp,
                        $variation->color,
                        $variation->size,
                        $variation->stock,
                        isset($productCategory->name) ? $productCategory->name : '',
                        isset($productSubCategory->name) ? $productSubCategory->name : '',
                    ];
                }

                // Create directories for each product variation
                $variationPath = $basePath.'/'.$key + 1;
                $mediaPath = $variationPath;
                // $mediaPath = $variationPath . '/media';
                // $mediaThumbnailPath = $variationPath . '/media/thumbnail';
                if (! file_exists($variationPath)) {
                    mkdir($variationPath, 0777, true);
                }
                if (! file_exists($mediaPath)) {
                    mkdir($mediaPath, 0777, true);
                }
                // if (!file_exists($mediaThumbnailPath)) {
                //     mkdir($mediaThumbnailPath, 0777, true);
                // }

                foreach ($media as $mediaItem) {
                    if ($mediaItem->file_path == null) {
                        continue;
                    }
                    $mediaFile = substr($mediaItem->file_path, strrpos($mediaItem->file_path, '/') + 1);
                    $mediaItem->file_path = str_replace('storage/', '', $mediaItem->file_path);
                    file_put_contents($mediaPath.'/'.$mediaFile, file_get_contents(storage_path('app/public/'.$mediaItem->file_path)));
                }

                /*
                foreach ($media as $mediaItem) {
                    if ($mediaItem->thumbnail_path == null) {
                        continue;
                    }
                    $mediaThumbnailFile = substr($mediaItem->thumbnail_path, strrpos($mediaItem->thumbnail_path, '/') + 1);
                    $mediaItem->thumbnail_path = str_replace('storage/', '', $mediaItem->thumbnail_path);
                    file_put_contents($mediaThumbnailPath . '/' . $mediaThumbnailFile, file_get_contents(storage_path('app/public/' . $mediaItem->thumbnail_path)));
                }
                */

                foreach ($video as $videoItem) {
                    if ($videoItem->file_path == null) {
                        continue;
                    }
                    $videoFile = substr($videoItem->file_path, strrpos($videoItem->file_path, '/') + 1);
                    $videoItem->file_path = str_replace('storage/', '', $videoItem->file_path);
                    file_put_contents($mediaPath.'/'.$videoFile, file_get_contents(storage_path('app/public/'.$videoItem->file_path)));
                }
            }

            // Create a temporary CSV file
            $csvFilename = 'product_data_'.$time.'.csv';
            $csvFilePath = $basePath.'/'.$csvFilename;
            $file = fopen($csvFilePath, 'w');

            // Write the CSV data to the file
            foreach ($csvData as $rowData) {
                fputcsv($file, $rowData);
            }

            // Close the file
            fclose($file);

            // Create a zip archive
            $zipFilePath = $basePath.'.zip';
            $zip = new ZipArchive;
            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                addFolderToZip($zip, $basePath, '');
                $zip->close();
            } else {
                throw new \Exception('Could not create zip file');
            }

            // Send the zip file to the user
            $response = response()->download($zipFilePath)->deleteFileAfterSend(true);

            // Clean up temporary files and folders
            unlinkFile($basePath);

            return $response;
        } catch (\Exception $e) {
            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            \Log::error('Download Product ---'.$e->getMessage().'--------'.$e->getFile());

            // Handle the exception
            return response()->json(['data' => __('auth.productInventoryDownloadFailed')], __('statusCode.statusCode500'));
        }
    }

    /**
     * Get the bulk inventory data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeChannelProductMap(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'sales_channel_id' => 'required|array',
                'sales_channel_id.*' => 'required|string',
                'product_variation_id' => 'required|string',
                'sales_channel_product_sku' => 'required|array',
                'sales_channel_product_sku.*' => 'required|string',
            ]);

            // Check if the request data is valid
            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode200'));
            }

            // check buyer role only
            if (! auth()->user()->hasRole(User::ROLE_BUYER)) {
                return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
            }

            $data = $request->all();
            $id = [];
            $variationId = [];
            foreach ($data['sales_channel_id'] as $key => $value) {
                $record = ChannelProductMap::updateOrCreate(['product_variation_id' => salt_decrypt($data['product_variation_id']), 'sales_channel_id' => base64_decode($value)], [
                    'sales_channel_id' => base64_decode($value),
                    'product_variation_id' => salt_decrypt($data['product_variation_id']),
                    'sales_channel_product_sku' => $data['sales_channel_product_sku'][$key],
                ]);
                $id[] = $record->sales_channel_id;
                $variationId[] = $record->product_variation_id;
            }
            $deleteRecord = ChannelProductMap::where(['product_variation_id' => $variationId])->whereNotIn('sales_channel_id', $id)->get();
            foreach ($deleteRecord as $record) {
                $record->forceDelete();
            }

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.channelProductMapStored'),
            ]], __('statusCode.statusCode200'));

        } catch (\Exception $e) {
            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            // Handle the exception
            return response()->json(['data' => __('api.channelProductMapStoreFailed')], __('statusCode.statusCode500'));
        }
    }

    /**
     * Edit the channel product map.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editChannelProductMap(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'product_variation_id' => 'required|string',
            ]);

            // Check if the request data is valid
            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode200'));
            }

            // check buyer role only
            if (! auth()->user()->hasRole(User::ROLE_BUYER)) {
                return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
            }
            // Check if the channel product map exists
            $channelProductMap = ChannelProductMap::where('product_variation_id', salt_decrypt($request->input('product_variation_id')))->get();
            if ($channelProductMap->isEmpty()) {
                return response()->json(['data' => __('auth.channelProductMapNotFound')], __('statusCode.statusCode404'));
            }

            //create a array data and return in json
            $data = [];
            foreach ($channelProductMap as $key => $value) {
                $data[$key]['id'] = salt_encrypt($value->id);
                $data[$key]['sales_channel_id'] = base64_encode($value->sales_channel_id);
                $data[$key]['channel_name'] = $value->salesChannel->name;
                $data[$key]['product_variation_id'] = salt_encrypt($value->product_variation_id);
                $data[$key]['sales_channel_product_sku'] = $value->sales_channel_product_sku;
            }

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.channelProductMapList'),
                'list' => $data,
            ]], __('statusCode.statusCode200'));

        } catch (\Exception $e) {
            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            // Handle the exception
            return response()->json(['data' => __('api.channelProductMapUpdateFailed')], __('statusCode.statusCode500'));
        }
    }

    /**
     * Delete the channel product map.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteChannelProductMap(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'product_variation_id' => 'required|string',
            ]);

            // Check if the request data is valid
            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode200'));
            }

            // check buyer role only
            if (! auth()->user()->hasRole(User::ROLE_BUYER)) {
                return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
            }
            // Check if the channel product map exists
            $channelProductMap = ChannelProductMap::where('product_variation_id', salt_decrypt($request->input('product_variation_id')))->get();
            if ($channelProductMap->isEmpty()) {
                return response()->json(['data' => __('auth.channelProductMapNotFound')], __('statusCode.statusCode404'));
            }

            // Delete the channel product map
            $channelProductMap->each(function ($map) {
                $map->forceDelete();
            });

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.channelProductMapDeleted'),
            ]], __('statusCode.statusCode200'));

        } catch (\Exception $e) {
            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            // Handle the exception
            return response()->json(['data' => __('api.channelProductMapDeleteFailed')], __('statusCode.statusCode500'));
        }
    }
}

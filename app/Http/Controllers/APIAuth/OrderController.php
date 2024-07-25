<?php

namespace App\Http\Controllers\APIAuth;

use App\Models\User;
use App\Models\AddToCart;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Validator;
use App\Transformers\ProductSkuTransformer;

class OrderController extends Controller
{
    protected $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * Add a product to the cart.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addToCart(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|array',
                'product_id.*' => 'required|string',
                'quantity' => 'nullable|array',
                'quantity.*' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], 422);
            }

            // Check if the user has the permission to add a new order
            if (!auth()->user()->hasPermissionTo(User::PERMISSION_ADD_NEW_ORDER)) {
                return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
            }

            $cart = [];
            // Loop through the product IDs and quantities
            foreach ($request->product_id as $key => $product_id) {
                // Decrypt the product ID
                $product = ProductVariation::find(salt_decrypt($product_id));
                if (!empty($product)) {
                    // Create a new Add To Cart record
                    $cart[] = [
                        'buyer_id' => auth()->user()->id,
                        'product_id' => $product->id,
                        'quantity' => $request->quantity[$key] ?? AddToCart::DEFAULT_QUANTITY,
                        'added_at' => now(),
                    ];
                } else {
                    // Return a not found message
                    return response()->json(['data' => __('auth.productNotFound')], __('statusCode.statusCode404'));
                }
            }

            if (!empty($cart)) {
                // Create a new Add To Cart record
                AddToCart::insert($cart);
            }

            // Return a success message
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.addToCart'),
            ]], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            // Handle the exception
            Log::error('Add to cart failed: ' . $e->getMessage() . 'Line:- ' . $e->getLine());
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode500'),
                'status' => __('statusCode.status500'),
                'message' => __('auth.addToCartFailed'),
            ]], __('statusCode.statusCode200'));
        }
    }

    /**
     * Search for a product by SKU.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchProductBySku(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'sku' => 'required|string|max:15',
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], 422);
            }

            // Check if the user has the permission to add a new order
            if (!auth()->user()->hasPermissionTo(User::PERMISSION_ADD_NEW_ORDER)) {
                return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
            }

            // Retrieve the SKU from the request
            $sku = $request->input('sku');
            $user = auth()->user();

            $productVariationSku = ProductVariation::where(['sku' => $sku])->first();

            if (empty($productVariationSku)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => __('auth.productNotFoundBySku'),
                ]], __('statusCode.statusCode200'));
            }
            // Check if the product variation SKU exists
            $checkDuplicate = AddToCart::where('product_id', $productVariationSku->product_id)->get();

            // Check if the product variation SKU exists
            if ($checkDuplicate->isEmpty()) {
                // Check if the product variation SKU exists
                if (!empty($productVariationSku)) {
                    
                    if($productVariationSku->stock > 0){
                        // Create a new Add To Cart record
                        AddToCart::create([
                            'buyer_id' => $user->id,
                            'product_id' => $productVariationSku->product_id,
                            'quantity' => AddToCart::DEFAULT_QUANTITY,
                            'added_at' => now(),
                        ]);

                        // Return a success message
                        return response()->json(['data' => [
                            // 'data' => $productVariationSku,
                            'statusCode' => __('statusCode.statusCode200'),
                            'status' => __('statusCode.status200'),
                            'message' => __('auth.addSku'),
                        ]], __('statusCode.statusCode200'));
                    }else{
                        return response()->json(['data' => [
                            'statusCode' => __('statusCode.statusCode404'),
                            'status' => __('statusCode.status404'),
                            'message' => __('auth.productOutOfStock'),
                        ]], __('statusCode.statusCode200'));
                    }
                    
                }
            } else {
                // Return a duplicate SKU message
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode404'),
                    'status' => __('statusCode.status422'),
                    'message' => __('auth.skuDuplicate'),
                ]], __('statusCode.statusCode200'));
            }
        } catch (\Exception $e) {
            // Handle the exception
            Log::error('Search product by sku failed: ' . $e->getMessage() . 'Line:- ' . $e->getLine());
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode500'),
                'status' => __('statusCode.status500'),
                'message' => __('auth.addSkuFailed'),
            ]], __('statusCode.statusCode200'));
        }
    }

    public function fetchSku()
    {
        try {
            $user = auth()->user();

            // Check if the user has the 'buyer' role
            if (!$user->hasRole(User::ROLE_BUYER)) {
                return response()->json(['data' => __('auth.unauthorizedAction')], 403);
            }

            $fetchSku = AddToCart::where('buyer_id', $user->id)->get();
            $products = [];

            if ($fetchSku->isEmpty()) {
                return response()->json(['data' => __('auth.skuNotFound')], __('statusCode.statusCode404'));
            } else {
                foreach ($fetchSku as $fetch) {
                    $product = ProductVariation::where('product_id', $fetch->product_id)->with('product')->first(); // Changed `$fetch->id` to `$fetch->product_id`
                    if ($product) {
                        $products[] = $product; // Append product to the array
                    }
                }
                $resource = new Collection($products, new ProductSkuTransformer());
                $data = $this->fractal->createData($resource)->toArray();

                return response()->json(['data' => [
                    'data' => $data,
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.fetchSku'),
                ]], __('statusCode.statusCode200'));
            }
        } catch (\Exception $e) {
            \Log::error('Add to cart failed: ' . $e->getMessage()); // Log the error message

            return response()->json(['data' => __('auth.addSkuFailed')], 500);
        }
    }



    public function deleteSku($id)
    {
        try {
            $user = auth()->user();
            $product_id = $id;

            // Check if the user has the 'buyer' role
            if (!$user->hasRole(User::ROLE_BUYER)) {
                return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
            }

            if (!empty($product_id)) {
                AddToCart::where([
                    'buyer_id' => $user->id,
                    'product_id' => $product_id,
                ])->delete();

                return response()->json([
                    'data' => [
                        'statusCode' => __('statusCode.statusCode200'),
                        'status' => __('statusCode.status200'),
                        'message' => __('auth.deleteSku'),
                    ],
                ], __('statusCode.statusCode200'));
            } else {
                return response()->json(['data' => __('auth.skuNotFound')], __('statusCode.statusCode404'));
            }
        } catch (\Exception $e) {
            // Handle the exception

            // \Log::error('Add to cart failed: ' . $e->getMessage());
            return response()->json(['data' => __('auth.deleteSkuFailed')], __('statusCode.statusCode500'));
        }
    }
}

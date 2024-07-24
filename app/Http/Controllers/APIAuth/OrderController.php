<?php

namespace App\Http\Controllers\APIAuth;

use App\Http\Controllers\Controller;
use App\Models\AddToCart;
use App\Models\ProductVariation;
use App\Models\User;
use App\Transformers\ProductSkuTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class OrderController extends Controller
{
    protected $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    public function addToCart(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|string',
                'quantity' => 'required|integer|min:1', // Ensure quantity is provided and is a valid integer
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], 422);
            }

            // Get the authenticated user's ID
            $user = auth()->user();

            // Check if the user has the 'buyer' role
            if (! $user->hasRole(User::ROLE_BUYER)) {
                return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
            }
            // Decrypt the product ID
            $product = ProductVariation::find(salt_decrypt($request->input('product_id')));

            if (! empty($product)) {
                // Create a new Add To Cart record
                AddToCart::create([
                    'buyer_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'added_at' => now(),
                ]);

                // Return a success message
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.addToCart'),
                ]], __('statusCode.statusCode200'));
            } else {
                return response()->json(['data' => __('auth.productNotFound')], __('statusCode.statusCode404'));
            }
        } catch (\Exception $e) {
            // Handle the exception
            // dd($e->getMessage());
            // \Log::error('Add to cart failed: ' . $e->getMessage());
            return response()->json(['data' => __('auth.addToCartFailed')], __('statusCode.statusCode500'));
        }
    }

    public function searchSku(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'sku' => 'required|string|max:255',
                // Ensure quantity is provided and is a valid integer
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], 422);
            }

            // Retrieve the SKU from the request
            $sku = $request->input('sku');
            $user = auth()->user();

            $productVariationSku = ProductVariation::where(['sku' => $sku])->first();
            $checkDuplicate = AddToCart::where('product_id', $productVariationSku->product_id)->get();
            if ($checkDuplicate->isEmpty()) {
                if (! empty($productVariationSku)) {
                    AddToCart::create([
                        'buyer_id' => $user->id,
                        'product_id' => $productVariationSku->product_id,
                        'quantity' => 1,
                        'added_at' => now(),
                    ]);

                    return response()->json(['data' => [
                        // 'data' => $productVariationSku,
                        'statusCode' => __('statusCode.statusCode200'),
                        'status' => __('statusCode.status200'),
                        'message' => __('auth.addSku'),
                    ]], __('statusCode.statusCode200'));

                } else {
                    return response()->json(['data' => __('auth.skuNotFound')], __('statusCode.statusCode404'));

                }
            } else {
                return response()->json(['data' => __('auth.skuDuplicate')], __('statusCode.statusCode404'));

            }

        } catch (\Exception $e) {
            // Handle the exception

            return response()->json(['data' => __('auth.addSkuFailed')], __('statusCode.statusCode500'));
        }
    }

    public function fetchSku()
    {
        try {
            $user = auth()->user();

            // Check if the user has the 'buyer' role
            if (! $user->hasRole(User::ROLE_BUYER)) {
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
            \Log::error('Add to cart failed: '.$e->getMessage()); // Log the error message

            return response()->json(['data' => __('auth.addSkuFailed')], 500);
        }
    }

    public function deleteSku($id)
    {
        try {
            $user = auth()->user();
            $product_id = $id;

            // Check if the user has the 'buyer' role
            if (! $user->hasRole(User::ROLE_BUYER)) {
                return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
            }

            if (! empty($product_id)) {
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

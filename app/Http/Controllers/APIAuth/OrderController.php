<?php

namespace App\Http\Controllers\APIAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AddToCart;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    function addToCart(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|string',
                'quantity' => 'required|integer|min:1' // Ensure quantity is provided and is a valid integer
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first()
                ]], 422);
            }

            // Get the authenticated user's ID
            $user = auth()->user();

            // Check if the user has the 'buyer' role
            if (!$user->hasRole(User::ROLE_BUYER)) {
                return response()->json(['data' => __('auth.unauthorizedAction')], __('statusCode.statusCode403'));
            }
            // dd(salt_decrypt($request->input('product_id')));
            // Decrypt the product ID
            $product = ProductVariation::find(salt_decrypt($request->input('product_id')));

            if (!empty($product)) {
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
                    'message' => __('auth.addToCart')
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

    function addSku(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'sku' => 'required|string|max:255',
                // Ensure quantity is provided and is a valid integer
            ]);

        if ($validator->fails()) {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => $validator->errors()->first()
            ]], 422);
        }

        // Retrieve the SKU from the request
        $sku = $request->input('sku');


         $productVariationSku = ProductVariation::where(['sku'=>$sku])->with('product','orderItems')->get();
            // dd($productVariationSku);
            if($productVariationSku->isEmpty()){

                return response()->json(['data' => __('auth.skuNotFound')], __('statusCode.statusCode404'));

            } else {
                return response()->json(['data' => [
                    'data' => $productVariationSku,
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.addSku')
                ]], __('statusCode.statusCode200'));
            }
    } catch (\Exception $e) {
        // Handle the exception
        // dd($e->getMessage());
        // \Log::error('Add to cart failed: ' . $e->getMessage());
        return response()->json(['data' => __('auth.addSkuFailed')], __('statusCode.statusCode500'));
    }
}



}

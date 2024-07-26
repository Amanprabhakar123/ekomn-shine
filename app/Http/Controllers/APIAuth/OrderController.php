<?php

namespace App\Http\Controllers\APIAuth;

use App\Models\User;
use App\Models\AddToCart;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Order;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Validator;
use App\Transformers\ProductCartListTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

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
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
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
                    return response()->json(['data' => [
                        'statusCode' => __('statusCode.statusCode400'),
                        'status' => __('statusCode.status403'),
                        'message' => __('auth.productNotFound'),
                    ]], __('statusCode.statusCode200'));
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
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
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

                    if ($productVariationSku->stock > 0) {
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
                    } else {
                        return response()->json(['data' => [
                            'statusCode' => __('statusCode.statusCode400'),
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

    /**
     * Get the products in the cart.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductInCart(Request $request)
    {
        try {
            // Check if the user has the permission to add a new order
            if (!auth()->user()->hasPermissionTo(User::PERMISSION_ADD_NEW_ORDER)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }

            $user = auth()->user();
            // Fetch the SKU
            $productCartList = AddToCart::where('buyer_id', $user->id)->with('product')->get();

            // Check if the SKU exists
            if ($productCartList->isEmpty()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status404'),
                    'message' => __('auth.skuNotFound'),
                ]], __('statusCode.statusCode200'));
            } else {
                // Transform the results using Fractal
                $resource = new Collection($productCartList, new ProductCartListTransformer($request->all()));

                // Create the data array using Fractal
                $data = $this->fractal->createData($resource)->toArray();
                // return response()->json($data);

                return response()->json(['data' => [
                    'data' => $data,
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.fetchSku'),
                ]], __('statusCode.statusCode200'));
            }
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getLine());
            \Log::error('Add to cart failed: ' . $e->getMessage()); // Log the error message

            return response()->json(['data' => __('auth.addSkuFailed')], 500);
        }
    }


    /**
     * Update the quantity of a product in the cart.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProductQuantityInCart(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'cart_id' => 'required|string',
                'quantity' => 'required|integer|min:1',
                'order_type' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode200'));
            }

            // Check if the user has the permission to add a new order
            if (!auth()->user()->hasPermissionTo(User::PERMISSION_ADD_NEW_ORDER)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }

            // add condition for check the product is available in cart or not
            $cart = AddToCart::where('id', salt_decrypt($request->cart_id))->first();
            if (empty($cart)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status404'),
                    'message' => __('auth.productNotFoundCart'),
                ]], __('statusCode.statusCode200'));
            }

            // add condition for check quantity less then product stock
            $product = ProductVariation::find($cart->product_id);
            if ($request->quantity > $product->stock) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status404'),
                    'message' => __('auth.quantityExceedsStock'),
                ]], __('statusCode.statusCode200'));
            }

            if($request->order_type == Order::ORDER_TYPE_DROPSHIP) {
                if ($request->quantity > Order::DROPSHIP_ORDER_QUANTITY) {
                    return response()->json(['data' => [
                        'statusCode' => __('statusCode.statusCode400'),
                        'status' => __('statusCode.status404'),
                        'message' => __('auth.quantityExceedsDropship', ['quantity' => Order::DROPSHIP_ORDER_QUANTITY]),
                    ]], __('statusCode.statusCode200'));
                }
            }   

            // Update the quantity of the product in the cart
            $cart->quantity = $request->quantity;
            $cart->save();

            // Return a success message
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.updateProductQuantityInCart'),
            ]], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            // Handle the exception
            Log::error('update quantity failed: ' . $e->getMessage() . 'Line:- ' . $e->getLine());
            return
                response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => __('auth.addToCartFailed'),
                ]], __('statusCode.statusCode200'));
        }
    }

    /**
     * Remove a product from the cart.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeProductInCart($id)
    {
        try {
            // Check if the ID is a string
            if (!is_string($id)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status400'),
                    'message' => __('auth.invalidId'),
                ]], __('statusCode.statusCode200'));
            }

            // Decrypt the product ID
            $product_id = (int) salt_decrypt($id);

            // Check if the user has the permission to add a new order
            if (!auth()->user()->hasPermissionTo(User::PERMISSION_ADD_NEW_ORDER)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }

            // Check if the product ID is not empty
            if (!empty($product_id)) {
                AddToCart::where([
                    'buyer_id' =>  auth()->user()->id,
                    'product_id' => $product_id
                ])->delete();

                // Return a success message
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.deleteSku'),
                ]], __('statusCode.statusCode200'));
            } else {

                // Return a not found message
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.skuNotFound'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
        } catch (\Exception $e) {
            // Handle the exception
            Log::error('Add to cart failed: ' . $e->getMessage() . 'Line:- ' . $e->getLine());
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode500'),
                'status' => __('statusCode.status500'),
                'message' => __('auth.deleteSkuFailed'),
            ]], __('statusCode.statusCode200'));
        }
    }
}

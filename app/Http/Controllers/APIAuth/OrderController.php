<?php

namespace App\Http\Controllers\APIAuth;

use ZipArchive;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\AddToCart;
use App\Models\CompanyPlan;
use App\Models\ShipmentAwb;
use League\Fractal\Manager;
use App\Models\OrderPayment;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Events\ExceptionEvent;
use App\Services\OrderService;
use App\Models\SupplierPayment;
use App\Models\ProductVariation;
use App\Models\OrderItemAndCharges;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\UserActivityService;
use App\Events\OrderStatusChangedEvent;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Validator;
use App\Transformers\OrderDataTransformer;
use App\Transformers\OrderTrackingTransformer;
use Illuminate\Validation\ValidationException;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function addToCart(Request $request)
    {
        try {
            if (! auth()->check()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizeLogin'),
                ]], __('statusCode.statusCode200'));
            }

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
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_ADD_NEW_ORDER)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }

            // check plan is active or inactive
            $company_plan = CompanyPlan::with('plan')->where('company_id', auth()->user()->CompanyDetails->id)
                ->where('status', CompanyPlan::STATUS_ACTIVE)->orderBy('id', 'desc')->first();
            if (empty($company_plan)) {
                    return response()->json(['data' => [
                        'statusCode' => __('statusCode.statusCode422'),
                        'status' => __('statusCode.status422'),
                        'message' => __('auth.planNotActive'),
                    ]], __('statusCode.statusCode200'));
            }
            $cart = [];
            // Loop through the product IDs and quantities
            foreach ($request->product_id as $key => $product_id) {
                // Decrypt the product ID
                $product = ProductVariation::find(salt_decrypt($product_id));
                if (! empty($product)) {
                    $o_qty = $request->quantity[$key] ?? AddToCart::DEFAULT_QUANTITY;
                    if($product->stock < $o_qty) {
                        return response()->json(['data' => [
                            'statusCode' => __('statusCode.statusCode400'),
                            'status' => __('statusCode.status404'),
                            'message' => __('auth.quantityExceedsStock'),
                        ]], __('statusCode.statusCode200'));
                    }
                    // Create a new Add To Cart record
                    $cart[] = [
                        'buyer_id' => auth()->user()->id,
                        'product_id' => $product->id,
                        'quantity' => $o_qty,
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

            $userActivityService = new UserActivityService;
            if (! empty($cart)) {
                // Upsert the cart items
                foreach ($cart as $cartItem) {
                    // Log the user add to cart activity
                    $userActivityService->logActivity($cartItem['product_id'], UserActivity::ACTIVITY_TYPE_BUY_NOW_OR_ADD_TO_CART);
                    AddToCart::updateOrCreate(
                        [
                            'buyer_id' => $cartItem['buyer_id'],
                            'product_id' => $cartItem['product_id']
                        ],
                        [
                            'buyer_id' => $cartItem['buyer_id'],
                            'product_id' => $cartItem['product_id'],
                            'quantity' => $cartItem['quantity'],
                            'added_at' => $cartItem['added_at'],
                        ]
                    );
                }
            }

            // Return a success message
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.addToCart'),
            ]], __('statusCode.statusCode200'));
        } catch (\Exception $e) {

            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            dd($exceptionDetails);
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            // Handle the exception
            Log::error('Add to cart failed: '.$e->getMessage().'Line:- '.$e->getLine());

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchProductBySku(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'sku' => 'required|string|max:35',
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], 422);
            }

            // Check if the user has the permission to add a new order
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_ADD_NEW_ORDER)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }

            // check plan is active or inactive
            $company_plan = CompanyPlan::with('plan')->where('company_id', auth()->user()->CompanyDetails->id)
                ->where('status', CompanyPlan::STATUS_ACTIVE)->orderBy('id', 'desc')->first();
            if (empty($company_plan)) {
                    return response()->json(['data' => [
                        'statusCode' => __('statusCode.statusCode422'),
                        'status' => __('statusCode.status422'),
                        'message' => __('auth.planNotActive'),
                    ]], __('statusCode.statusCode200'));
            }
            // Retrieve the SKU from the request
            $sku = $request->input('sku');
            $user = auth()->user();

            $productVariationSku = ProductVariation::where(['sku' => $sku, 'status' => ProductVariation::STATUS_ACTIVE])->first();
            
            if (empty($productVariationSku)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => __('auth.productNotFoundBySku'),
                ]], __('statusCode.statusCode200'));
            }
            // Check if the product variation SKU exists
            $checkDuplicate = AddToCart::where('product_id', $productVariationSku->id)->where('buyer_id', $user->id)->get();

            // Check if the product variation SKU exists
            if ($checkDuplicate->isEmpty()) {
                // Check if the product variation SKU exists
                if (! empty($productVariationSku)) {

                    if ($productVariationSku->stock > 0) {
                        $userActivityService = new UserActivityService;
                        // Create a new Add To Cart record
                        AddToCart::create([
                            'buyer_id' => $user->id,
                            'product_id' => $productVariationSku->id,
                            'quantity' => AddToCart::DEFAULT_QUANTITY,
                            'added_at' => now(),
                        ]);

                        $userActivityService->logActivity($productVariationSku->id, UserActivity::ACTIVITY_TYPE_BUY_NOW_OR_ADD_TO_CART);

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
            Log::error('Search product by sku failed: '.$e->getMessage().'Line:- '.$e->getLine());

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
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_ADD_NEW_ORDER)) {
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

            // Log the exception details and trigger an ExceptionEvent
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            Log::error('Add to cart failed: '.$e->getMessage()); // Log the error message

            return response()->json(['data' => __('auth.addSkuFailed')], 500);
        }
    }

    /**
     * Update the quantity of a product in the cart.
     *
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
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_ADD_NEW_ORDER)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }

             // check plan is active or inactive
             $company_plan = CompanyPlan::with('plan')->where('company_id', auth()->user()->CompanyDetails->id)
             ->where('status', CompanyPlan::STATUS_ACTIVE)->orderBy('id', 'desc')->first();
                if (empty($company_plan)) {
                        return response()->json(['data' => [
                            'statusCode' => __('statusCode.statusCode422'),
                            'status' => __('statusCode.status422'),
                            'message' => __('auth.planNotActive'),
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

            if ($request->order_type == Order::ORDER_TYPE_DROPSHIP) {
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
            Log::error('update quantity failed: '.$e->getMessage().'Line:- '.$e->getLine());

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeProductInCart($id)
    {
        try {
            // Check if the ID is a string
            if (! is_string($id)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status400'),
                    'message' => __('auth.invalidId'),
                ]], __('statusCode.statusCode200'));
            }

            // Decrypt the product ID
            $product_id = (int) salt_decrypt($id);

            // Check if the user has the permission to add a new order
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_ADD_NEW_ORDER)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }

            // Check if the product ID is not empty
            if (! empty($product_id)) {
                AddToCart::where([
                    'buyer_id' => auth()->user()->id,
                    'product_id' => $product_id,
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
            Log::error('Add to cart failed: '.$e->getMessage().'Line:- '.$e->getLine());

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode500'),
                'status' => __('statusCode.status500'),
                'message' => __('auth.deleteSkuFailed'),
            ]], __('statusCode.statusCode200'));
        }
    }

    /**
     * Get the orders.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function orders(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $searchTerm = $request->input('query', null);
            $sort = $request->input('sort', 'id'); // Default sort by 'title'
            $sortOrder = $request->input('order', 'desc'); // Default sort direction 'asc'
            $sort_by_status = (int) $request->input('sort_by_status', '0'); // Default sort by 'all'

            // Allowed sort fields to prevent SQL injection
            $allowedSorts = ['order_number', 'quantity', 'order_date', 'order_type', 'order_channel_type', 'payment_status'];
            $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

            $orderList = Order::with(['orderItemsCharges', 'orderItemsCharges.product', 'buyer', 'supplier'])
                ->when($searchTerm, function ($query) use ($searchTerm) {
                    $query->where(function ($query) use ($searchTerm) {
                        $query->where('order_number', 'like', '%'.$searchTerm.'%')
                            ->orWhere('store_order', 'like', '%'.$searchTerm.'%')
                            ->orWhere('full_name', 'like', '%'.$searchTerm.'%')
                            ->orWhereHas('orderItemsCharges.product', function ($query) use ($searchTerm) {
                                $query->where('title', 'like', '%'.$searchTerm.'%');
                            });
                    });
                });
            if ($sort_by_status != 0) {
                $orderList = $orderList->where('status', $sort_by_status);
            }
            if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
                $orderList = $orderList->where('orders.supplier_id', auth()->user()->id);
                $orderList = $orderList->whereIn('status', Order::STATUS_ARRAY);
            } elseif (auth()->user()->hasRole(User::ROLE_BUYER)) {
                $orderList = $orderList->whereIn('status', Order::STATUS_ARRAY);
                $orderList = $orderList->where('buyer_id', auth()->user()->id);
            } elseif (auth()->user()->hasRole(User::ROLE_ADMIN) || auth()->user()->hasRole(User::ROLE_SUB_ADMIN)) {
                // $orderList = $orderList->whereIn('status', Order::STATUS_ARRAY);
            }

            if ($sort == 'quantity') {
                $orderList->join('order_item_and_charges', 'orders.id', '=', 'order_item_and_charges.order_id');
                $orderList->select('orders.*', \DB::raw('SUM(order_item_and_charges.quantity) as quantity'));
                $orderList->groupBy('orders.id');
            }
            $orderList = $orderList->orderBy($sort, $sortOrder) // Apply sorting
                ->paginate($perPage); // Paginate results

            // Transform the paginated results using Fractal
            $resource = new Collection($orderList, new OrderDataTransformer);

            // Add pagination information to the resource
            $resource->setPaginator(new IlluminatePaginatorAdapter($orderList));

            // Create the data array using Fractal
            $data = $this->fractal->createData($resource)->toArray();

            // Return the JSON response with paginated data
            return response()->json($data);

        } catch (\Exception $e) {

            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
            // Log the exception details and trigger an ExceptionEvent

            Log::error('Get Orders failed: '.$e->getMessage().' Line:- '.$e->getLine());

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode500'),
                'status' => __('statusCode.status500'),
                'message' => __('auth.orderListFailed'),
            ]], __('statusCode.statusCode200'));
        }
    }

    /**
     * Store a new order.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Check if the user has the permission to add a new order
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_ADD_NEW_ORDER)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
             // check plan is active or inactive
             $company_plan = CompanyPlan::with('plan')->where('company_id', auth()->user()->CompanyDetails->id)
             ->where('status', CompanyPlan::STATUS_ACTIVE)->orderBy('id', 'desc')->first();
            if (empty($company_plan)) {
                    return response()->json(['data' => [
                        'statusCode' => __('statusCode.statusCode201'),
                        'status' => __('statusCode.status201'),
                        'message' => __('auth.planNotActive'),
                    ]], __('statusCode.statusCode200'));
            }
            if ($request->input('order_id')) {
                $order_id = salt_decrypt($request->input('order_id'));
                $order = Order::find($order_id);
                $orderService = new OrderPayment;
                // crete response array
                $response = [
                    'total_amount' => (string) ($order->total_amount * 100),
                    'currency' => $orderService->getCurrency((int) OrderPayment::CURRENCY_INR),
                    'razorpy_order_id' => $order->orderPayments->first()->razorpay_order_id,
                    'full_name' => $order->full_name,
                    'email' => $order->email,
                    'mobile_number' => $order->mobile_number,
                    'order_id' => salt_encrypt($order->id),
                ];

                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.orderCreatedSuccesfully'),
                    'data' => $response,
                ]], __('statusCode.statusCode200'));
            }
            if ($request->order_type != Order::ORDER_TYPE_BULK) {
                $validator = Validator::make($request->all(), [
                    'full_name' => 'required|string',
                    'email' => 'nullable|string',
                    'mobile' => 'required|string|max:10|min:10',
                    'order_type' => 'required|integer',
                    'store_order' => 'nullable|string',
                    'invoice' => 'nullable|mimes:pdf',
                    'address' => 'required|string',
                    'state' => 'required|string',
                    'city' => 'required|string',
                    'pincode' => 'required|string|max:6|min:6',
                    'b_address' => 'required|string',
                    'b_state' => 'required|string',
                    'b_city' => 'required|string',
                    'b_pincode' => 'required|string|max:6|min:6',
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'order_type' => 'required|integer',
                ]);
            }

            try {
                $validator->validate();
            } catch (ValidationException $e) {
                $errors = $validator->errors();
                $field = $errors->keys()[0]; // Get the first field that failed validation
                $errorMessage = $errors->first($field);

                return errorResponse($errorMessage.'-'.$field);
            }

            // Check Order Type is Reseller with Plan Permission
            if ($request->order_type == Order::ORDER_TYPE_RESELL) {
                $feature = json_decode($company_plan->plan->features, true);
                $reseller_program = $feature['reseller_program'];
                if($reseller_program == false) {
                    return response()->json(['data' => [
                        'statusCode' => __('statusCode.statusCode201'),
                        'status' => __('statusCode.status201'),
                        'message' => __('auth.resellerProgramNotActive'),
                    ]], __('statusCode.statusCode200'));
                }
            }
            // Fetch the Cart Data
            $productCartList = AddToCart::where('buyer_id', auth()->user()->id)->with('product')->get();
            // Check if the SKU exists
            if ($productCartList->isEmpty()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status404'),
                    'message' => __('auth.skuNotFound'),
                ]], __('statusCode.statusCode200'));
            }

            // Transform the results using Fractal
            $resource = new Collection($productCartList, new ProductCartListTransformer($request->all()));

            // Create the data array using Fractal
            $data = $this->fractal->createData($resource)->toArray();

            $OrderService = new OrderService;

            return $OrderService->createOrder($request->all(), $data, $productCartList);
        } catch (\Exception $e) {
            // Handle the exception
            Log::error('Store order failed: '.$e->getMessage().'Line:- '.$e->getLine().'File:- '.$e->getFile());
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            // Log the exception details and trigger an ExceptionEvent
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode500'),
                'status' => __('statusCode.status500'),
                'message' => __('auth.orderStoreFailed'),
            ]], __('statusCode.statusCode200'));
        }
    }

    /**
     * Order Payment Success
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderPaymentSuccess(Request $request)
    {
        try {
            $OrderService = new OrderService;
            $success = $OrderService->confirmOrder($request->all());
            if ($success) {
                return redirect()->route('my.orders');
            } else {
                return redirect()->route('payment.failed');
            }
        } catch (\Exception $e) {
            Log::info('Request data: '.$e->getMessage().'---- '.$e->getLine());
            if (config('app.front_end_tech') == false) {
                return redirect()->route('payment.failed');
            }

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => __('auth.paymentFailed'),
            ]], __('statusCode.statusCode422'));
        }
    }

    /**
     * Update the order status.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder(Request $request)
    {
        try {
            // Check if the user has the permission to edit an order
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_EDIT_ORDER)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }

            // Validate the request data
            $validator = Validator::make($request->all(), [
                'orderID' => 'required|string',
                'shippingDate' => 'required|date',
                'deliveryDate' => 'required|date',
                'courier_id' => 'required|int',
                'courierName' => 'nullable|string',
                'trackingNo' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode200'));
            }
            // Decrypt the order ID from the request and fetch the associated order items and charges
            $orderID = salt_decrypt($request->orderID);
            $order_details = Order::find($orderID);
            $orderItems = OrderItemAndCharges::where('order_id', $orderID)->get();
            Order::where('id', $orderID)->update(['status' => Order::STATUS_DISPATCHED]);

            // Parse the dates using Carbon
            $shippingDate = Carbon::parse($request->shippingDate)->toDateString();
            $deliveryDate = Carbon::parse($request->deliveryDate)->toDateString();

            // Prepare data for updating or creating a shipment record
            $shipmentData = [
                'shipment_date' => $shippingDate,
                'delivery_date' => $deliveryDate,
                'courier_id' => $request->courier_id,
            ];

            // Iterate over each order item to update or create a shipment record
            foreach ($orderItems as $item) {
                // Update or create a shipment record for each order item
                $shipment = Shipment::updateOrCreate(
                    [
                        'order_id' => $item->order_id,
                        'order_item_charges_id' => $item->id,
                    ],
                    $shipmentData
                );
                // Prepare data for updating or creating a shipment AWB (Air Waybill) record
                $awbData = [
                    'shipment_id' => $shipment->id,
                    'awb_number' => $request->trackingNo,
                    'awb_date' => $shippingDate,
                    'courier_provider_name' => $request->courierName,
                    'status' => ShipmentAwb::STATUS_SHIPPED_DISPATCHE, // Corrected constant value
                ];

                // Update or create a shipment AWB record
                $shipmentAwb = ShipmentAwb::updateOrCreate(
                    ['shipment_id' => $shipment->id],
                    $awbData
                );
            }
            $OrderService = new OrderService();
            $OrderService->getSupplierPayment($order_details);
            // Prepare the mail data
            $mail = [
                'order_number' => $order_details->order_number,
                'status' => Order::STATUS_DISPATCHED,
            ];

            event(new OrderStatusChangedEvent($order_details->buyer, $mail));

            // Return a success response
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.orderUpdate'),
                ],
            ], __('statusCode.statusCode200'));

        } catch (\Exception $e) {
            // Handle any exceptions that occur during the database operations

            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];

            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            // Log the error message for debugging purposes
            \Log::error('Error updating or creating shipment records: '.$e->getMessage());

            // Return an error response with a message
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => __('auth.orderUpdateFailed'),
                ],
            ], __('statusCode.statusCode500'));
        }
    }

    /**
     * Cancel an order.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelOrder(Request $request)
    {
        try {
            // add validation for order id
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode200'));
            }
            // Check if the user has the permission to cancel an order
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_CANCEL_ORDER)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }

            // Decrypt the order ID from the request
            $order_id = salt_decrypt($request->order_id);

            $OrderService = new OrderService;

            return $OrderService->cancelOrder($order_id, $request->reason);

        } catch (\Exception $e) {
            // Handle any exceptions that occur during the database operations
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
            // Log the error message for debugging purposes
            \Log::error('Error cancelling order: '.$e->getMessage().'Line:- '.$e->getLine().'File:- '.$e->getFile());

            // Return an error response with a message
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode500'),
                'status' => __('statusCode.status500'),
                'message' => __('auth.orderCancelFailed'),
            ]], __('statusCode.statusCode200'));
        }
    }

    /**
     * Get the order details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function downloadInvoice($order_id)
    {
        try {
            $validator = Validator::make(['order_id' => $order_id], [
                'order_id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode200'));
            }
            $order_id = salt_decrypt($order_id);
            $order = Order::find($order_id);
            if (empty($order)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status404'),
                    'message' => __('auth.orderNotFound'),
                ]], __('statusCode.statusCode200'));
            }
            if ($order->isDropship() || $order->isResell()) {
                $orderInvoice = $order->orderInvoices->first();
                $path = str_replace('public/', 'storage/', $orderInvoice->uploaded_invoice_path);

                return response()->download($path)->deleteFileAfterSend(false);

            } else {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status404'),
                    'message' => __('auth.invoiceNotFound'),
                ]], __('statusCode.statusCode200'));
            }
        } catch (\Exception $e) {
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode500'),
                'status' => __('statusCode.status500'),
                'message' => __('auth.invoiceDownloadFailed'),
            ]], __('statusCode.statusCode200'));
        }

    }

    /**
     * Get the order details for download invoice.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderInvoice(Request $request)
    {
        try {
            // Decrypt the order ID from the request
            $orderId = salt_decrypt($request->all()[0]);

            $orderService = new OrderService;
            $fileName = $orderService->orderInvoice($orderId);
            $originalFullPath = storage_path('app/public/' . $fileName);
            $file = file_get_contents($originalFullPath);
            
            // Return the file as a download
            $response = response($file, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
            ]);

            // Delete the file after sending the response
            unlink($originalFullPath);

            // Delete the directory if it is empty
            $directory = dirname($originalFullPath);
            if (is_dir($directory) && count(scandir($directory)) == 2) {
                rmdir($directory);
            }

            return $response;
        } catch (\Exception $e) {
           // Handle any exceptions that occur during the database operations
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            event(new ExceptionEvent($exceptionDetails));
              // Return error response for failed invoice download
              return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => __('auth.invoiceDownloadFailed'),
                ],
            ], __('statusCode.statusCode200'));
        }
    }

    /**
     * Get the order details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function OrderTrackingList(Request $request){
        try{
              // Check if the user has the permission to cancel an order
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_ORDER_TRACKING)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            
            $perPage = $request->input('per_page', 10);
            $searchTerm = $request->input('query', null);
            $sort = $request->input('sort', 'id'); // Default sort by 'title'
            $sortOrder = $request->input('order', 'desc'); // Default sort direction 'asc'
            $sort_by_status = (int) $request->input('sort_by_status', '0'); // Default sort by 'all'

            // Allowed sort fields to prevent SQL injection
            $allowedSorts = ['order_number', 'status'];
            $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

            $orderList = Order::with(['orderItemsCharges', 'orderItemsCharges.product', 'shipments', 'shipments.shipmentAwb'])
                ->when($searchTerm, function ($query) use ($searchTerm) {
                    $query->where(function ($query) use ($searchTerm) {
                        $query->where('order_number', 'like', '%' . $searchTerm . '%')
                            ->orWhereHas('orderItemsCharges.product', function ($query) use ($searchTerm) {
                                $query->where('title', 'like', '%' . $searchTerm . '%');
                            });
                    });
                });
                if ($sort_by_status != 0) {
                    $orderList = $orderList->where('status', $sort_by_status);
                }
                if(auth()->user()->hasRole(User::ROLE_ADMIN) || auth()->user()->hasRole(User::ROLE_SUB_ADMIN)){
                    $orderList = $orderList->whereIn('status', Order::STATUS_ORDER_TRACKING);
                }
                
                $orderList = $orderList->orderBy($sort, $sortOrder) // Apply sorting
                ->paginate($perPage); // Paginate results
          
            // Transform the paginated results using Fractal
            $resource = new Collection($orderList, new OrderTrackingTransformer());

            // Add pagination information to the resource
            $resource->setPaginator(new IlluminatePaginatorAdapter($orderList));

            // Create the data array using Fractal
            $data = $this->fractal->createData($resource)->toArray();

            // Return the JSON response with paginated data
            return response()->json($data);
        }catch(\Exception $e){
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            event(new ExceptionEvent($exceptionDetails));

            // Return error response for failed invoice download
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => __('auth.invoiceDownloadFailed'),
                ],
            ], __('statusCode.statusCode200'));
        }
    }

    /**
     * Get the order details for Export Ordders and download CSV.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function exportOrders(Request $request)
    {
        try {
            // Retrieve and validate order IDs
            $orderIds = $request->data;
            if (! is_array($orderIds)) {
                throw new \Exception('Invalid order IDs format.');
            }

            // Generate a unique filename for the CSV
            $timestamp = time();
            $csvFilename = 'orders-'.$timestamp.'.csv';
            $csvFilepath = storage_path('app/public/export/'.auth()->user()->id.'/'.$csvFilename);

            // Create a base path for storing the files
            $basePath = storage_path('app/public/export/'.auth()->user()->id);
            if (! file_exists($basePath)) {
                mkdir($basePath, 0777, true);
            }

            // Create and write headers to the CSV file
            $file = fopen($csvFilepath, 'w');
            fputcsv($file, [
                'ORDER NUMBER', 'STORE ORDER', 'PRODUCT TITLE', 'CUSTOMER NAME',
                'CUSTOMER EMAIL', 'CUSTOMER PHONE', 'DELIVERY ADDRESS',
                'BILLING ADDRESS', 'QUANTITY', 'DATE', 'TOTAL AMOUNT',
                'CATEGORY', 'TYPE', 'STATUS', 'PAYMENT STATUS',
            ]);

            foreach ($orderIds as $encryptedId) {
                $orderId = salt_decrypt($encryptedId);
                $order = Order::find($orderId);

                if (! $order) {
                    fclose($file);

                    return response()->json([
                        'data' => [
                            'statusCode' => __('statusCode.statusCode404'),
                            'status' => __('statusCode.status404'),
                            'message' => __('auth.orderNotFound'),
                        ],
                    ], __('statusCode.statusCode404'));
                }

                // Collect and write order data to the CSV file
                $quantity = 0;
                $title = '';
                foreach ($order->orderItemsCharges as $itemCharge) {
                    $quantity += $itemCharge->quantity;
                    $title = $itemCharge->product->title;
                }

                if($order->isDropship()){
                    fputcsv($file, [
                        $order->order_number,
                        $order->store_order ?? '',
                        $title,
                        $order->full_name,
                        $order->email,
                        $order->mobile_number,
                        $order->shippingAddress->street.' '.$order->shippingAddress->city.' '.$order->shippingAddress->state.' - '.$order->shippingAddress->postal_code,
                        $order->billingAddress->street.' '.$order->billingAddress->city.' '.$order->billingAddress->state.' - '.$order->billingAddress->postal_code,
                        $quantity,
                        $order->order_date->toDateString(),
                        $order->total_amount,
                        $order->getOrderType(),
                        $order->getOrderChannelType(),
                        $order->getStatus(),
                        $order->getPaymentStatus(),
                    ]);
                }else{
                    if (auth()->user()->hasRole(User::ROLE_ADMIN) || auth()->user()->hasRole(User::ROLE_SUB_ADMIN)) {
                        fputcsv($file, [
                            $order->order_number,
                            $order->store_order ?? '',
                            $title,
                            $order->full_name,
                            $order->email,
                            $order->mobile_number,
                            $order->shippingAddress->street.' '.$order->shippingAddress->city.' '.$order->shippingAddress->state.' - '.$order->shippingAddress->postal_code,
                            $order->billingAddress->street.' '.$order->billingAddress->city.' '.$order->billingAddress->state.' - '.$order->billingAddress->postal_code,
                            $quantity,
                            $order->order_date->toDateString(),
                            $order->total_amount,
                            $order->getOrderType(),
                            $order->getOrderChannelType(),
                            $order->getStatus(),
                            $order->getPaymentStatus(),
                        ]);
                    }
                    else{
                        fputcsv($file, [
                            $order->order_number,
                            $order->store_order ?? '',
                            $title,
                            $order->full_name,
                            'support@ekomn.com',
                            '+91-xxx-xxx-xxxx',
                            $order->pickupAddress->street.' '.$order->pickupAddress->city.' '.$order->pickupAddress->state.' - '.$order->pickupAddress->postal_code,
                            $order->billingAddress->street.' '.$order->billingAddress->city.' '.$order->billingAddress->state.' - '.$order->billingAddress->postal_code,
                            $quantity,
                            $order->order_date->toDateString(),
                            $order->total_amount,
                            $order->getOrderType(),
                            $order->getOrderChannelType(),
                            $order->getStatus(),
                            $order->getPaymentStatus(),
                        ]);
                    }
                }

                // Add order invoice to the base path if available
                if ($order->isDropship() || $order->isResell()) {
                    $orderInvoice = $order->orderInvoices->first();
                    $invoicePath = str_replace('public/', 'storage/', $orderInvoice->uploaded_invoice_path);

                    if ($orderInvoice) {
                        $destinationPath = $basePath.'/invoices/'.basename($invoicePath);
                        if (! file_exists(dirname($destinationPath))) {
                            mkdir(dirname($destinationPath), 0777, true);
                        }
                        copy($invoicePath, $destinationPath);
                    }
                }
            }

            fclose($file);

            // Create a ZIP file containing the CSV and any invoices
            $zip = new ZipArchive;
            $zipFilename = 'invoices_'.$timestamp.'.zip';
            $zipFilePath = storage_path('app/public/export/').$zipFilename;

            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                addFolderToZip($zip, $basePath, '');
                $zip->close();
            } else {
                throw new \Exception('Could not create zip file');
            }

            // Send the ZIP file to the user and clean up temporary files
            $response = response()->download($zipFilePath)->deleteFileAfterSend(true);
            unlinkFile($basePath);

            return $response;

        } catch (\Exception $e) {
            // Log exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode500'),
                'status' => __('statusCode.status500'),
                'message' => __('auth.orderTrackingListFailed'),
            ]], __('statusCode.statusCode200'));
        }
    }


    /**
     * Update the order tracking status.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatOrderTrackingStatus(Request $request){
        try {
            // Check if the user has the permission to edit an order
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_ORDER_TRACKING)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }

            // Validate the request data
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|string',
                'status' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode200'));
            }
            // Decrypt the order ID from the request and fetch the associated order items and charges
            $order_id = salt_decrypt($request->order_id);
            $order = Order::find($order_id);
            $order->status = $request->status;
            $order->save();

            if($request->status == Order::STATUS_RTO){
                 // Supplier Payment Status
                SupplierPayment::where('order_id', $order->id)
                ->update(['payment_status' => SupplierPayment::PAYMENT_STATUS_HOLD]);
            }
            if($request->status == Order::STATUS_DELIVERED){
                $shipment = Shipment::where('order_id', $order_id)->first();
                $shipment->delivery_date = now();
                $shipment->save();
                $update = ['status' => ShipmentAwb::STATUS_DELIVERED];
                ShipmentAwb::where('shipment_id', $shipment->id)->update($update);

                // Prepare data for send notification
                $shipment = $order->shipments->first();
                $courier_name = '';
                $tracking_number = '';
                if($shipment){
                    $courier_name = $shipment->courier->courier_name;
                    $shipmet_awb = $shipment->shipmentAwb()->first();
                    if($shipment->courier->id == 1){
                        $courier_name = $shipmet_awb->courier_provider_name;
                    }
                    $tracking_number = $shipmet_awb->awb_number;
                }
                $mail = [
                    'order_number' => $order->order_number,
                    'status' => (int) $request->status,
                    'courier_name' => $courier_name,
                    'tracking_number' => $tracking_number,
                ];
                event(new OrderStatusChangedEvent($order->buyer, $mail));
            }
           
            // Return a success response
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.shipmetUpdate'),
                ],
            ], __('statusCode.statusCode200'));

        } catch (\Exception $e) {
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));

            // Log the error message for debugging purposes
            Log::error('Error updating or creating shipment records: '.$e->getMessage());

            // Return an error response with a message
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => __('auth.invoiceDownloadFailed'),
                ],
            ], __('statusCode.statusCode200'));
        }
        
    }
}

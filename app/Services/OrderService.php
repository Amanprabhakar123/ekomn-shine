<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Order;
use Razorpay\Api\Api;
use App\Models\AddToCart;
use App\Models\OrderAddress;
use App\Models\OrderInvoice;
use App\Models\OrderPayment;
use App\Events\ExceptionEvent;
use App\Models\OrderTransaction;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItemAndCharges;
use App\Models\CompanyAddressDetail;
use App\Models\OrderPaymentDistribution;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{

    /**
     * Create Order
     *
     * @param array $orderData
     * @param array $orderItems
     * @param object $productCartList
     * @return void
     */
    public function createOrder(array $orderData, array $orderItems, object $productCartList)
    {
        try {
            DB::beginTransaction();
            // Get supplier address
            $supplierAddress = [];
            $supplier_id = [];
            $orderItemsCharges = [];
            $orderAddress = [];
            // Check if product cart list is not empty
            if ($productCartList->isNotEmpty()) {
                foreach ($productCartList as $product) {
                    $supplier_id[] = $product->product->company->user_id;
                    $s_address = $product->product->company->address->where('address_type', CompanyAddressDetail::TYPE_PICKUP_ADDRESS)->first();
                    $supplierAddress[] = [
                        'street' =>  $s_address->address_line1 . ' ' . $s_address->address_line2,
                        'city' => $s_address->city,
                        'state' => $s_address->state,
                        'postal_code' => $s_address->pincode,
                        'address_type' => OrderAddress::TYPE_PICKUP_ADDRESS,
                    ];
                }
            }

            // Check if supplier IDs are not unique
            if (count(array_unique($supplier_id)) !== 1) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode201'),
                    'status' => __('statusCode.status201'),
                    'message' => __('auth.duplicatSupplierOrder'),
                ]], __('statusCode.statusCode200'));
            }

            $order_number = Order::generateOrderNumber();

            // Create order address array
            if($orderData['order_type'] == Order::ORDER_TYPE_BULK){
                $user = auth()->user()->companyDetails;
                // Create order array
                $order = [
                    'order_number' => $order_number,
                    'buyer_id' => auth()->user()->id,
                    'supplier_id' => $supplier_id[0],
                    'full_name' => $user->first_name.' '.$user->last_name,
                    'email' => $user->email,
                    'mobile_number' => $user->mobile_no,
                    'gst_number' => $user->gst_no,
                    'store_order' => isset($orderData['store_order']) ? $orderData['store_order'] : '',
                    'order_date' => Carbon::now()->toDateTimeString(),
                    'status' => Order::STATUS_DRAFT,
                    'total_amount' => isset($orderItems['data']) ? end($orderItems['data'])['overAllCost'] : 0,
                    'discount' => isset($orderData['data']) ? end($orderData['data'])['discount'] : 0,
                    'payment_status' => Order::PAYMENT_STATUS_PENDING,
                    'payment_currency' => Order::PAYMENT_CURRENCY_INR,
                    'order_type' => $orderData['order_type'],
                    'order_channel_type' => Order::ORDER_CHANNEL_TYPE_MANUAL,
                    'payment_method' => Order::PAYMENT_METHOD_ONLINE,
                ];

                $order = Order::create($order);
                $delivery = $user->address->where('address_type', CompanyAddressDetail::TYPE_DELIVERY_ADDRESS)->first();
                $billing = $user->address->where('address_type', CompanyAddressDetail::TYPE_BILLING_ADDRESS)->first();
                $orderAddress = [
                    // Create order delivery address array
                    'orderDeliveryAddress' => [
                        'order_id' => $order->id,
                        'buyer_id' => auth()->user()->id,
                        'street' => $delivery->address_line1 . ' ' . $delivery->address_line2,
                        'city' => $delivery->city,
                        'state' => $delivery->state,
                        'postal_code' => $delivery->pincode,
                        'address_type' => OrderAddress::TYPE_DELIVERY_ADDRESS,
                    ],

                    // Create order billing address array
                    'orderBillingAddress' => [
                        'order_id' => $order->id,
                        'buyer_id' => auth()->user()->id,
                        'street' => $billing->address_line1 . ' ' . $billing->address_line2,
                        'city' => $billing->city,
                        'state' => $billing->state,
                        'postal_code' => $billing->pincode,
                        'address_type' => OrderAddress::TYPE_BILLING_ADDRESS,
                    ],

                    'pickUpAddress' => [
                        'order_id' => $order->id,
                        'buyer_id' => auth()->user()->id,
                        'street' => $supplierAddress[0]['street'],
                        'city' => $supplierAddress[0]['city'],
                        'state' => $supplierAddress[0]['state'],
                        'postal_code' => $supplierAddress[0]['postal_code'],
                        'address_type' => $supplierAddress[0]['address_type'],
                    ]
                ];
            }else{
                // Create order array
                $order = [
                    'order_number' => $order_number,
                    'buyer_id' => auth()->user()->id,
                    'supplier_id' => $supplier_id[0],
                    'full_name' => $orderData['full_name'],
                    'email' => $orderData['email'],
                    'mobile_number' => $orderData['mobile'],
                    'store_order' => $orderData['store_order'],
                    'order_date' => Carbon::now()->toDateTimeString(),
                    'status' => Order::STATUS_DRAFT,
                    'total_amount' => isset($orderItems['data']) ? end($orderItems['data'])['overAllCost'] : 0,
                    'discount' => isset($orderData['data']) ? end($orderData['data'])['discount'] : 0,
                    'payment_status' => Order::PAYMENT_STATUS_PENDING,
                    'payment_currency' => Order::PAYMENT_CURRENCY_INR,
                    'order_type' => $orderData['order_type'],
                    'order_channel_type' => Order::ORDER_CHANNEL_TYPE_MANUAL,
                    'payment_method' => Order::PAYMENT_METHOD_ONLINE,
                ];

                $order = Order::create($order);
                $orderAddress = [
                    // Create order delivery address array
                    'orderDeliveryAddress' => [
                        'order_id' => $order->id,
                        'buyer_id' => auth()->user()->id,
                        'street' => $orderData['address'],
                        'city' => DB::table('cities')->where('id', $orderData['city'])->pluck('name')->first(),
                        'state' => DB::table('states')->where('id', $orderData['state'])->pluck('name')->first(),
                        'postal_code' => $orderData['pincode'],
                        'address_type' => OrderAddress::TYPE_DELIVERY_ADDRESS,
                    ],

                    // Create order billing address array
                    'orderBillingAddress' => [
                        'order_id' => $order->id,
                        'buyer_id' => auth()->user()->id,
                        'street' => $orderData['b_address'],
                        'city' => DB::table('cities')->where('id', $orderData['b_city'])->pluck('name')->first(),
                        'state' => DB::table('states')->where('id', $orderData['b_state'])->pluck('name')->first(),
                        'postal_code' => $orderData['b_pincode'],
                        'address_type' => OrderAddress::TYPE_BILLING_ADDRESS,
                    ],

                    'pickUpAddress' => [
                        'order_id' => $order->id,
                        'buyer_id' => auth()->user()->id,
                        'street' => $supplierAddress[0]['street'],
                        'city' => $supplierAddress[0]['city'],
                        'state' => $supplierAddress[0]['state'],
                        'postal_code' => $supplierAddress[0]['postal_code'],
                        'address_type' => $supplierAddress[0]['address_type'],
                    ]
                ];
            }
            // Create order items charges array
            $orderDeliveryAddress = OrderAddress::create($orderAddress['orderDeliveryAddress']);
            $orderBillingAddress =  OrderAddress::create($orderAddress['orderBillingAddress']);
            $pickUpAddress =  OrderAddress::create($orderAddress['pickUpAddress']);

            $order->shipping_address_id = $orderDeliveryAddress->id;
            $order->billing_address_id = $orderBillingAddress->id;
            $order->pickup_address_id = $pickUpAddress->id;
            $order->save();

            $isValidQuantity = false;
            $isOutOfStock = false;
            // check OrderItems is not empty
            if (isset($orderItems['data']) && !empty($orderItems['data'])) {
                foreach ($orderItems['data'] as $item) {
                    if ($orderData['order_type'] == Order::ORDER_TYPE_DROPSHIP && $item['quantity'] > Order::DROPSHIP_ORDER_QUANTITY) {
                        $isValidQuantity = true;
                        break;
                    }
                     // add condition for check quantity less then product stock
                    $product = ProductVariation::find(salt_decrypt($item['product_id']));
                    if ($item['quantity'] > $product->stock) {
                       $isOutOfStock = true;
                        break;
                    }
                    $orderItemsCharges[] = [
                        'order_id' => $order->id,
                        'product_id' => salt_decrypt($item['product_id']),
                        'supplier_id' => $supplier_id[0],
                        'quantity' => $item['quantity'],
                        'per_item_price' => $item['price_per_piece'],
                        'total_price_inc_gst' => $item['priceWithGst'],
                        'total_price_exc_gst' => $item['total_price_exc_gst'],
                        'gst_percentage' => $item['gst_percentage'],
                        'igst' => $item['gst_percentage'] / 2,
                        'cgst' => $item['gst_percentage'] / 2,
                        'shipping_gst_percent' => $item['shipping_gst_percent'],
                        'shipping_charges' => $item['shipping_charges'],
                        'packing_charges' => $item['packing_charges'],
                        'packaging_gst_percent' => $item['packing_gst_percent'],
                        'labour_charges' => $item['labour_charges'],
                        'labour_gst_percent' => $item['labour_gst_percent'],
                        'processing_charges' => $item['processing_charges'],
                        'processing_gst_percent' => $item['processing_gst_percent'],
                        'payment_gateway_percentage' => $item['payment_gateway_percentage'],
                        'payment_gateway_charges' => $item['payment_gateway_charges'],
                        'payment_gateway_gst_percent' => $item['payment_gateway_gst_percent'],
                    ];
                }
            }

            // add condition if order type is dropship restrict maximum quantity
            if ($isValidQuantity) {
                // Rollback transaction
                DB::rollBack();
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode201'),
                    'status' => __('statusCode.status201'),
                    'message' => __('auth.quantityExceedsDropship', ['quantity' => Order::DROPSHIP_ORDER_QUANTITY]),
                ]], __('statusCode.statusCode200'));
            }

            if($isOutOfStock) {
                // Rollback transaction
                DB::rollBack();
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode201'),
                    'status' => __('statusCode.status201'),
                    'message' => __('auth.quantityExceedsStock'),
                ]], __('statusCode.statusCode200'));
            }


            // Create order items charges
            $insertOrderItemsCharges = OrderItemAndCharges::insert($orderItemsCharges);

            if(isset($orderData['invoice'])){
                $filename = $order_number . '.' . $orderData['invoice']->getClientOriginalExtension();
                $invocie_path = storage('order_invoices', file_get_contents($orderData['invoice']), [1], $filename, 'public');
            }
            $orderInvoiceNumber = new OrderInvoice();
            // create Order Invoice Data
            $orderInvoice = [
                'order_id' => $order->id,
                'buyer_id' => auth()->user()->id,
                'supplier_id' => $supplier_id[0],
                'invoice_number' => $orderInvoiceNumber->generateInvoiceNumber(),
                'invoice_date' => Carbon::now()->toDateTimeString(),
                'total_amount' => isset($orderItems['data']) ? end($orderItems['data'])['overAllCost'] : 0,
                'status' => OrderInvoice::STATUS_DUE,
                'uploaded_invoice_path' => $invocie_path ?? null,
            ];

            // Create order invoice
            $orderInvoice = OrderInvoice::create($orderInvoice);

            // Create order transaction by razor pay
            $orderService = new OrderPayment();
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $orderPayment = $api->order->create([
                'amount' => (string) $order->total_amount * 100, // Amount in paise
                'currency' => $orderService->getCurrency((int) OrderPayment::CURRENCY_INR),
                'receipt' => (string) $order_number,
                'notes' => [
                    'order' => 'Create payment for order by Ekomn Platform',
                ],
            ]);

            // store order payment data
            $orderPaymentData = [
                'order_id' => $order->id,
                'razorpay_payment_id' => $orderPayment->id, // transaction id
                'payment_method' => OrderPayment::PAYMENT_METHOD_RAZORPAY,
                'payment_date' => Carbon::now()->toDateTimeString(),
                'amount' => $order->total_amount,
                'currency' => OrderPayment::CURRENCY_INR,
                'status' => OrderPayment::STATUS_CREATED,
                'description' => json_encode($orderPayment->toArray()),
            ];

            // Create order payment
            $insertorderPaymentData = OrderPayment::create($orderPaymentData);

            // Order Distribute Payment
            $orderDistribution =[
                'order_id' => $order->id,
                'order_payment_id' => $insertorderPaymentData->id,
                'supplier_id' => $supplier_id[0],
                'amount' => $order->total_amount,
                'status' => OrderPaymentDistribution::STATUS_NA,
                'is_refunded' => false,
                'refund_status' => OrderPaymentDistribution::REFUND_STATUS_NA,
                'refunded_amount' => 0,
            ];

            // Create order payment distribution
            $insertOrderDistribution = OrderPaymentDistribution::create($orderDistribution);

            // crete response array
            $response = [
                'total_amount' => (string) ($order->total_amount * 100),
                'currency' => $orderService->getCurrency((int) OrderPayment::CURRENCY_INR),
                'order_id' => $insertorderPaymentData->razorpay_payment_id,
                'full_name' => $order->full_name,
                'email' => $order->email,
                'mobile_number' => $order->mobile_number,
            ];

            // Commit transaction
            DB::commit();
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.orderCreatedSuccesfully'),
                'data' => $response,
            ]], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            DB::rollBack();
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
            throw $e;
        }
    }

    /**
     * Confirm Order Details
     *
     * @param array $request
     * @return void
     */
    public function confirmOrder($request){
        $paymentId = $request['razorpay_payment_id'];
        $razorpay_order_id = $request['razorpay_order_id'];
        $signature = $request['razorpay_signature'];

        $orderPayment = OrderPayment::where('razorpay_payment_id', $razorpay_order_id)->first();
        if(!$orderPayment){
            return false;
        }
        $orderPayment->status = OrderPayment::STATUS_AUTHORIZED;
        $orderPayment->save();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $attributes = [
            'razorpay_order_id' => $razorpay_order_id,
            'razorpay_payment_id' => $paymentId,
            'razorpay_signature' => $signature,
        ];
        try{
            $api->utility->verifyPaymentSignature($attributes);

            // update order payment status
            $order = Order::find($orderPayment->order_id);
            $order->payment_status = Order::PAYMENT_STATUS_PAID;
            $order->status = Order::STATUS_PENDING;
            $order->save();

            // update order payment data

            $orderPayment->status = OrderPayment::STATUS_CAPTURED;
            $orderPayment->razorpay_signature = $signature;
            $orderPayment->save();

            // update order payment distribution
            $orderDistribution = OrderPaymentDistribution::where('order_id', $orderPayment->order_id)->first();
            $orderDistribution->status = OrderPaymentDistribution::STATUS_HOLD;
            $orderDistribution->save();

            // update order invoice status
            $orderInvoice = OrderInvoice::where('order_id', $orderPayment->order_id)->first();
            $orderInvoice->status = OrderInvoice::STATUS_PAID;
            $orderInvoice->save();

            // create order transaction
            OrderTransaction::create([
                'order_id' => $orderPayment->order_id,
                'order_payment_id' => $orderPayment->id,
                'transaction_date' => Carbon::now()->toDateTimeString(),
                'transaction_type' => OrderTransaction::TRANSACTION_TYPE_PAYMENT,
                'transaction_amount' => $orderPayment->amount,
                'transaction_currency' => OrderTransaction::CURRENCY_INR,
                'razorpay_transaction_id' => $orderPayment->razorpay_payment_id,
                'status' => OrderTransaction::STATUS_SUCCESS,
            ]);

            // Update product stock
            $order_item = OrderItemAndCharges::where('order_id', $orderPayment->order_id)->get();
            foreach($order_item as $item){
                $product = ProductVariation::find($item->product_id);
                $product->stock = $product->stock - $item->quantity;
                $product->save();

                // Remove Cart Item
                AddToCart::where('product_id', $item->product_id)->delete();
            }      
            return true;
            
        } catch(\Exception $e){
             // update order payment status
             $order = Order::find($orderPayment->order_id);
             $order->payment_status = Order::PAYMENT_STATUS_FAILED;
             $order->status = Order::STATUS_DRAFT;
             $order->save();
 
             // update order payment data
 
             $orderPayment->status = OrderPayment::STATUS_FAILED;
             $orderPayment->razorpay_signature = $signature;
             $orderPayment->save();
 
             // update order payment distribution
             $orderDistribution = OrderPaymentDistribution::where('order_id', $orderPayment->order_id)->first();
             $orderDistribution->status = OrderPaymentDistribution::STATUS_NA;
             $orderDistribution->save();
 
             // update order invoice status
             $orderInvoice = OrderInvoice::where('order_id', $orderPayment->order_id)->first();
             $orderInvoice->status = OrderInvoice::STATUS_DUE;
             $orderInvoice->save();
 
             // create order transaction
             OrderTransaction::create([
                 'order_id' => $orderPayment->order_id,
                 'order_payment_id' => $orderPayment->id,
                 'transaction_date' => Carbon::now()->toDateTimeString(),
                 'transaction_type' => OrderTransaction::TRANSACTION_TYPE_PAYMENT,
                 'transaction_amount' => $orderPayment->amount,
                 'transaction_currency' => OrderTransaction::CURRENCY_INR,
                 'razorpay_transaction_id' => $orderPayment->razorpay_payment_id,
                 'status' => OrderTransaction::STATUS_FAILED,
             ]);

             $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
            throw $e;
        }

    }
}

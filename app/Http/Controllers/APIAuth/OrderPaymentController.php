<?php

namespace App\Http\Controllers\APIAuth;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderRefund;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Events\ExceptionEvent;
use App\Models\SupplierPayment;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use League\Fractal\Resource\Collection;
use App\Transformers\OrderPaymentTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class OrderPaymentController extends Controller
{

    protected $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * Show the order payment page.
     *
     * @param Request $request
     * 
     * Illuminate\View\View
     */
    public function orderPayment(Request $request)
    {
         // Check if the user has permission to update the payment information
         if (! auth()->user()->hasPermissionTo(User::PERMISSION_PAYMENT_LIST)) {
            return abort(403, __('auth.unauthorizedAction'));
        }
        if(auth()->user()->hasRole(User::ROLE_SUPPLIER)){
            $orderList = Order::with(['supplierPayments'])
            ->where('supplier_id', auth()->user()->id)
            ->whereIn('status', Order::STATUS_ORDER_TRACKING)
            ->get();
        }else{
            $orderList = Order::with(['supplierPayments'])
            ->whereIn('status', Order::STATUS_ORDER_TRACKING)
            ->get();
        }
        $total_balance_due = 0;
        $total_payment_due = 0;
        $total_statement_amount = 0;
        if($orderList->isNotEmpty()){
            foreach($orderList as $order){
                $order->supplierPayments()->get()->each(function($payment) use (&$total_balance_due, &$total_payment_due, &$total_statement_amount){
                    if($payment->isPaymentStatusHold() || $payment->isPaymentStatusAccured() || $payment->isPaymentStatusDue()){
                        $total_balance_due += $payment->disburse_amount;
                    }
                    if($payment->isPaymentStatusDue()){
                        $total_payment_due += $payment->disburse_amount;
                    }
                    $total_statement_amount += $payment->disburse_amount;
                });
            }
        }
        return view('dashboard.common.payment', compact('total_balance_due', 'total_payment_due', 'total_statement_amount'));
    }

    /**
     * Order payment update.
     * 
     * @param Request $request
     * 
     * Illuminate\Http\JsonResponse
     */
    public function orderPaymentUpdate(Request $request)
    {
        try {
            // Check if the user has permission to update the payment information
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_PAYMENT_EDIT)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            $order_id = $request->input('order_id');
            $id = salt_decrypt($order_id);
            $order = Order::find($id);
            $processing_charges = 0;
            $payment_gateway_charges = 0;
            $refund_amount = 0;

            $order->orderItemsCharges()->get()->each(function($orderItemsCharges) use (&$processing_charges, &$payment_gateway_charges){
                $processing_charges += $orderItemsCharges->processing_charges;
                $payment_gateway_charges += $orderItemsCharges->payment_gateway_charges;
            });
            $order->orderRefunds()->where('status',OrderRefund::STATUS_COMPLETED)->select('amount')->get()->each(function($refund) use (&$refund_amount){
                $refund_amount += $refund->refund_amount;
            });
            $payment = SupplierPayment::where('order_id', $id)->first();
            if (! $payment) {
                return response()->json([
                    'data' => [
                        'statusCode' => __('statusCode.statusCode400'),
                        'status' => __('statusCode.status404'),
                        'message' => __('auth.paymentNotFound'),
                    ]
                ]);
            }
            $disburse_amount = ($order->total_amount - ($payment->tds + $payment->tcs + $request->input('adjustment_amount') + $refund_amount + $processing_charges + $payment_gateway_charges));
            $payment->adjustment_amount = $request->input('adjustment_amount');
            $payment->disburse_amount = $disburse_amount;
            $payment->save();

            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => __('auth.adjustmeAmountUpdated'),
                ]
            ]);
        }
        catch (\Exception $e) {
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => 'Failed to update order payment',
                ]
            ]);
        }
    }

    /**
     * Get the payment information.
     *
     * @param Request $request
     * 
     * Illuminate\Http\JsonResponse
     */
    public function paymentWeekly(Request $request)
    {
        try {
            // Check if the user has permission to view the payment information
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_PAYMENT_LIST)) {
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
            $sort_by_order_status = (int) $request->input('sort_by_order_status', '0'); // Default sort by 'all'
            $order_date = $request->input('order_date', now()->subDays(30)->format('Y-m-d'));
            $order_last_date = $request->input('order_last_date', now()->format('Y-m-d'));
            $statement_date = $request->input('statement_date', null);

            // Allowed sort fields to prevent SQL injection
            $allowedSorts = ['order_number', 'quantity', 'order_date', 'order_type', 'order_channel_type', 'payment_status'];
            $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

            $orderList = Order::with(['orderItemsCharges', 'orderRefunds', 'supplierPayments', 'supplier.CompanyDetails'])
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('order_number', 'like', '%'.$searchTerm.'%')
                        ->orWhereHas('supplier.CompanyDetails', function ($query) use ($searchTerm) {
                            $query->where('company_serial_id', 'like', '%'.$searchTerm.'%');
                        });
                });
            })
            ->whereIn('status', Order::STATUS_ORDER_TRACKING);
            if ($sort_by_status != 0) {
                $orderList = $orderList->when($sort_by_status, function ($query) use ($sort_by_status) {
                    $query->whereHas('supplierPayments', function ($query) use ($sort_by_status) {
                        $query->where('payment_status', $sort_by_status);
                    });
                });
            }
            if ($sort_by_order_status != 0) {
                $orderList = $orderList->where('status', $sort_by_order_status);
            }
            if(auth()->user()->hasRole(User::ROLE_SUPPLIER)){
                $orderList = $orderList->where('supplier_id', auth()->user()->id);
            }
            
            $orderList = $orderList->where(function ($qu) use ($order_date, $order_last_date) {
                $qu->where('order_date', '>=', $order_date)
                ->Orwhere('order_date', '<=', $order_last_date);
            });
            if($statement_date){
                $orderList = $orderList->whereHas('supplierPayments', function ($query) use ($statement_date) {
                    $query->where('statement_date', $statement_date);
                });
            }
            $orderList = $orderList->orderBy($sort, $sortOrder) // Apply sorting
            ->paginate($perPage); // Paginate results
         
             // Add pagination information to the resource
            $resource = new Collection($orderList, new OrderPaymentTransformer);

            // Prepare the response
            $resource->setPaginator(new IlluminatePaginatorAdapter($orderList));

            // Create the data array using Fractal
            $transformedData = $this->fractal->createData($resource)->toArray();
            return response()->json($transformedData);
        } catch (\Exception $e) {
            
             // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => 'Failed to fetch payment information',
                ]
            ]);
        }

    }

    /**
     * Export the payment information.
     *
     * @param Request $request
     * 
     * Illuminate\Http\JsonResponse
     */
    public function exportPaymentWeekly(Request $request)
    {
        try{
            // Check if the user has permission to export payment information
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_PAYMENT_EXPORT)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            $orderIds = $request->data;
            if (! is_array($orderIds)) {
                throw new \Exception('Invalid order IDs format.');
            }

            // Generate a unique filename for the CSV
            $timestamp = time();
            $csvFilename = 'order-payments'.$timestamp.'.csv';
            $csvFilepath = storage_path('app/public/export/'.auth()->user()->id.'/'.$csvFilename);

            // Create a base path for storing the files
            $basePath = storage_path('app/public/export/'.auth()->user()->id);
            if (! file_exists($basePath)) {
                mkdir($basePath, 0777, true);
            }
             // Create and write headers to the CSV file
             $file = fopen($csvFilepath, 'w');

             $header = [];
            if(auth()->user()->hasRole(User::ROLE_ADMIN)){
                $header = ['SUPPLIER_ID'];
            }
            // Add the default headers
            $header = array_merge($header, [
                'EKOMN_ORDER_NO',
                'DATE',
                'PRODUCT_CHARGES',
                'DISCOUNT',
                'SHIPPING_CHARGES',
                'PACKING_CHARGES',
                'LABOUR_CHARGES',
                'PAYMENT_CHARGES',
                'TOTAL_GST',
                'ORDER_AMOUNT',
                'ORDER_STATUS',
                'CATEGORY',
                'REFUNDS',
                'REFERRAL_FEE',
                'ADJUSTMENTS',
                'TDS',
                'TCS',
                'ORDER_DISBURSEMENT_AMOUNT',
                'PAYMENT_STATUS',
                'STATEMENT_WK'
            ]);
            if(auth()->user()->hasRole(User::ROLE_ADMIN)){
                $header = array_merge($header,['BANK_NAME', 'BANK_ACCOUNT_NO', 'IFSC_CODE', 'SWIFT_CODE']);
            }
            fputcsv($file, $header);
            $order_id_list = [];
            foreach($orderIds as $orderId){
                $order_id_list[] = salt_decrypt($orderId);
            }

            $orderList = Order::with(['orderItemsCharges', 'orderItemsCharges.product', 'orderRefunds', 'supplierPayments'])
            ->whereIn('id', $order_id_list)->get();

            // Add pagination information to the resource
            $resource = new Collection($orderList, new OrderPaymentTransformer);

            // Create the data array using Fractal
            $transformedData = $this->fractal->createData($resource)->toArray();
            
            if($transformedData['data']){
                foreach($transformedData['data'] as $order){
                    $list = [];
                    if(auth()->user()->hasRole(User::ROLE_ADMIN)){
                        $list[] = $order['supplier_id'];
                    }
                    $list = array_merge($list, [
                        $order['order_no'],
                        $order['order_date'],
                        $order['product_cost_exc_gst'],
                        $order['discount'],
                        $order['shipping_charges'],
                        $order['packing_charges'],
                        $order['labour_charges'],
                        $order['payment_gateway_charges'],
                        $order['total_gst_amount'],
                        $order['order_total'],
                        $order['status'],
                        $order['order_type'],
                        $order['refund_amount'],
                        $order['processing_charges'],
                        $order['adjustment_amount'],
                        $order['tds_amount'],
                        $order['tcs_amount'],
                        $order['disburse_amount'],
                        $order['payment_status'],
                        $order['statement_date']
                    ]);

                    if(auth()->user()->hasRole(User::ROLE_ADMIN)){
                        $list = array_merge($list, [
                            $order['bank_name'],
                            $order['bank_account_no'],
                            $order['ifsc_code'],
                            $order['swift_code']
                        ]);
                    }
                    fputcsv($file, $list);
                }
            }

            // Close the file
            fclose($file);

            $response = response()->download($csvFilepath)->deleteFileAfterSend(true);
            return $response;

        }catch(\Exception $e){
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            dd($exceptionDetails);
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => 'Failed to export payment information',
                ]
            ]);
        }
    }


    /**
     * Get the order details for download invoice.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function OrderPaymentInvoice(Request $request)
    {
        try {
             // Check if the user has permission to export payment information
             if (! auth()->user()->hasPermissionTo(User::PERMISSION_PAYMENT_EXPORT)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
            // Decrypt the order ID from the request
            $orderId = salt_decrypt($request->all()[0]);

            // Find the order by the decrypted ID
            $order = Order::where('id', $orderId)->with(['supplierPayments'])->get()->first();
            
            // Check if the order exists and has associated invoices
            if (! $order || ! $order->supplierPayments->isNotEmpty()) {
                return response()->json([
                    'data' => [
                        'statusCode' => __('statusCode.statusCode400'),
                        'status' => __('statusCode.status404'),
                        'message' => __('auth.orderNotFound'),
                    ],
                ], __('statusCode.statusCode200'));
            }

            // Get the first invoice associated with the order
            $invoice = $order->supplierPayments()->first();

            if ($order && $invoice) {
                // Prepare data for the PDF
                $invoiceData = [
                    'invoice_number' => $invoice->supplierPaymentInvoice->invoice_number,
                    'total_amount' => $invoice->supplierPaymentInvoice->total_amount,
                    'invoice_date' => $invoice->supplierPaymentInvoice->invoice_date,
                    'order_number' => $order->order_number,
                    'full_name' => $order->full_name,
                    'email' => $order->email,
                    'mobile_number' => $order->mobile_number,
                    'store_order' => $order->store_order,
                    'status' => $order->getStatus(),
                    'shipping_address' => $order->shippingAddress->street.' '.$order->shippingAddress->city.' '.$order->shippingAddress->state.' - '.$order->shippingAddress->postal_code,
                    'billing_address' => $order->billingAddress->street.' '.$order->billingAddress->city.' '.$order->billingAddress->state.' - '.$order->billingAddress->postal_code,
                    'pickup_address' => $order->pickupAddress->street.' '.$order->pickupAddress->city.' '.$order->pickupAddress->state.' - '.$order->pickupAddress->postal_code,
                ];
                // Generate the PDF from the view
                $pdf = Pdf::loadView('pdf.payment_reciept', $invoiceData);
                $fileName = 'payment_reciept_'.$invoice->invoice_number.'.pdf';

                // Return the PDF as a download
                return $pdf->download($fileName);
            } else {
                // Return error response if invoice is not found
                return response()->json([
                    'data' => [
                        'statusCode' => __('statusCode.statusCode400'),
                        'status' => __('statusCode.status404'),
                        'message' => __('auth.invoiceNotFound'),
                    ],
                ], __('statusCode.statusCode200'));
            }
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
}

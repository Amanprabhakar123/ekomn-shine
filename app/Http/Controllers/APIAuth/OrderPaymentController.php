<?php

namespace App\Http\Controllers\APIAuth;

use App\Models\User;
use App\Models\Order;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Events\ExceptionEvent;
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
     * Get the payment information.
     *
     * @param Request $request
     * 
     * Illuminate\Http\JsonResponse
     */
    public function paymentWeekly(Request $request){
        try {
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

            $orderList = Order::with(['orderItemsCharges', 'orderItemsCharges.product', 'orderRefunds', 'supplierPayments'])
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('order_number', 'like', '%'.$searchTerm.'%')
                        ->orWhereHas('orderItemsCharges.product.company', function ($query) use ($searchTerm) {
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
            $orderList = $orderList->whereBetween('order_date', [$order_date, $order_last_date]);
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


            // dd($transformedData);
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200'),
                    'message' => 'Payment information fetched successfully',
                    'data' => $transformedData['data'],
                    'meta' => $transformedData['meta']
                ]
            ]);
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

    public function exportPaymentWeekly(Request $request)
    {
        try{
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
            // event(new ExceptionEvent($exceptionDetails));
            return response()->json([
                'data' => [
                    'statusCode' => __('statusCode.statusCode500'),
                    'status' => __('statusCode.status500'),
                    'message' => 'Failed to export payment information',
                ]
            ]);
        }
    }
}

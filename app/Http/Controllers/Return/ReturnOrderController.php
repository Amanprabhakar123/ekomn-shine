<?php

namespace App\Http\Controllers\Return;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\ReturnOrder;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Models\ReturnComment;
use App\Events\ExceptionEvent;
use App\Events\ReturnDeclinedApprovedEvent;
use App\Models\CourierDetails;
use App\Models\ReturnShipment;
use App\Models\SupplierPayment;
use App\Events\ReturnRaisedEvent;
use App\Http\Controllers\Controller;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Validator;
use App\Transformers\ReturnListTransformer;
use App\Transformers\ReturnOrderTrackingTransformer;


class ReturnOrderController extends Controller
{

    protected $fractal;
    protected $CategoryManagementTransform;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }


    /**
     * Create a reutrn order view page 
     * 
     * @param Request $request
     * @return view
     */

    /**
     * List a return order view page 
     * 
     * @param Request $request
     * @return view
     */
    public function createReturnOrder(Request $request)
    {
        if (! auth()->user()->hasPermissionTo(User::PERMISSION_CREATE_RETURN_ORDER)) {
            abort(403);
        }
        $returnOrder = new ReturnOrder();
        $return_request = $returnOrder->generateReturnNumber();
        $reasons = ReturnOrder::RETURN_RESON;
        return view('dashboard.common.create-return-order', get_defined_vars());
    }

    /**
     * Store a return order view page 
     * 
     * @param Request $request
     * @return view
     */
    public function store(Request $request)
    {
        if (! auth()->user()->hasPermissionTo(User::PERMISSION_CREATE_RETURN_ORDER)) {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status403'),
                'message' => __('auth.unauthorizedAction'),
            ]], __('statusCode.statusCode200'));
        }
        // Validate the request
        $validator = Validator::make($request->all(), [
            'order_number' => 'required|string',
            'reason' => 'nullable|string',
            'other_reason' => 'nullable|string',
            'comment' => 'required|string',
            'media.*' => 'required|array|min:3',
            'media.*' => 'required|mimes:png,jpeg,jpg,webp,mp4',
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => $validator->errors()->first(),
            ]], __('statusCode.statusCode200'));
        }
        $order = Order::where('order_number', $request->order_number)->first();
        if (!$order) {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => __('auth.orderNotFound'),
            ]], __('statusCode.statusCode200'));
        }

        if ($order->isRTO()) {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => __('auth.alreadyReturnOrder'),
            ]], __('statusCode.statusCode200'));
        }

        if ($order->isDispatched() && $request->reason == 1) {
            return $this->createReturnRequest($request, $order);
        } else if ($order->isDelivered()) {
            $shipments = $order->shipments()->first();
            if ($shipments) {
                $delivery_date = $shipments->delivery_date;
            } else {
                $delivery_date = '';
            }
            if (isset($delivery_date) && !empty($delivery_date)) {
                // add two days to delivery date
                $delivery_date = Carbon::parse($delivery_date)->addDays(2);
                if ($delivery_date->toDateTimeString() >= now()->toDateTimeString()) {
                    return $this->createReturnRequest($request, $order);
                } else {
                    return response()->json(['data' => [
                        'statusCode' => __('statusCode.statusCode422'),
                        'status' => __('statusCode.status422'),
                        'message' => __('auth.returnAllowed'),
                    ]], __('statusCode.statusCode200'));
                }
            } else {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => __('auth.orderNotDelivered'),
                ]], __('statusCode.statusCode200'));
            }
        } else {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => __('auth.returnAllowed'),
            ]], __('statusCode.statusCode200'));
        }
    }

    /**
     * Create a return order view page 
     * 
     * @param Request $request
     * @return view
     */
    protected function createReturnRequest($request, $order)
    {
        try {
            $ext_img_array = ['png', 'jpeg', 'jpg', 'webp'];
            $ext_video_array = ['mp4'];
            // Upload Images first
            $media = [];
            foreach ($request->media as $key => $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                if (in_array($extension, $ext_img_array)) {
                    $media_type = 'image';
                    $path = storage('return_order', file_get_contents($file), [$request->order_number], 'return_order_' . $filename, 'public');
                    $path = str_replace('public', 'storage', $path);
                    $media[$media_type][] = $path;
                } else if (in_array($extension, $ext_video_array)) {
                    $media_type = 'video';
                    $path = storage('return_order', file_get_contents($file), [$request->order_number], 'return_order_' . $filename, 'public');
                    $path = str_replace('public', 'storage', $path);
                    $media[$media_type][] = $path;
                }
            }
            $returnOrder = new ReturnOrder();
            if ($request->reason == 5) {
                $reason = $request->other_reason;
            } else {
                $reason = $returnOrder->reason($request->reason);
            }
            $createReturn = ReturnOrder::create([
                'order_id' => $order->id,
                'return_number' => $request->return_number,
                'return_date' => now(),
                'status' => ReturnOrder::STATUS_OPEN,
                'amount' => $order->total_amount,
                'file_path' => json_encode($media),
                'reason' => $reason
            ]);
            ReturnComment::create([
                'return_id' => $createReturn->id,
                'role_type' => User::ROLE_BUYER,
                'comment' => $request->comment
            ]);
            $order->status = Order::STATUS_RTO;
            $order->save();

            // Supplier Payment Status
            SupplierPayment::where('order_id', $order->id)
                ->update(['payment_status' => SupplierPayment::PAYMENT_STATUS_HOLD]);
                $detail = [
                    'return_number' => $createReturn->return_number,
                    'name' => $order->supplier->name,
                ];
                event(new ReturnRaisedEvent($order->supplier, $detail));
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.returnOrder'),
            ]], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => $e->getMessage(),
            ]], __('statusCode.statusCode200'));
        }
    }

    /**
     * Edit a return order view page 
     * 
     * @param Request $request
     * @return view
     */
    public function listReturnOrder(Request $request)
    {
        return view('dashboard.common.list-return-order');
    }

    /**
     * get return order list
     * 
     * @param Request $request
     * @return view
     */
    public function getReturnOrderList(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $search = $request->input('query', null);
            $sort = $request->input('sort', 'id'); // Default sort by 'title'
            $sortOrder = $request->input('order', 'desc'); // Default sort direction 'asc'
            $sort_by_status = $request->input('sort_by_status', null);
            $sort_by_dispute = $request->input('sort_by_dispute', null);
            // Allowed sort fields to prevent SQL injection
            $allowedSorts = ['quantity', 'return_date', 'dispute'];
            $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

            $returnOrder = ReturnOrder::with('order.orderItemsCharges');
            if ($search) {
                $returnOrder = $returnOrder->where('return_number', 'like', '%' . $search . '%')
                    ->orWhereHas('order', function ($query) use ($search) {
                        $query->where('order_number', 'like', '%' . $search . '%');
                    })
                    ->orderBy('id', 'desc');
            }

            if ($sort_by_status) {
                $returnOrder = $returnOrder->where('status', $sort_by_status)->orderBy('id', 'desc');
            }

            if (!is_null($sort_by_dispute)) {
                $returnOrder = $returnOrder->where('dispute', $sort_by_dispute)->orderBy('id', 'desc');
            }

            if ($sort == 'quantity') {
                $returnOrder->join('orders', 'orders.id', '=', 'return_orders.order_id');
                $returnOrder->join('order_item_and_charges', 'orders.id', '=', 'order_item_and_charges.order_id');
                $returnOrder->select('return_orders.*', \DB::raw('SUM(order_item_and_charges.quantity) as quantity'));
                $returnOrder->groupBy('return_orders.order_id');
            }
            $returnOrder = $returnOrder->orderBy($sort, $sortOrder)->paginate($perPage);
            $resource = new Collection($returnOrder, new ReturnListTransformer());
            $resource->setPaginator(new \League\Fractal\Pagination\IlluminatePaginatorAdapter($returnOrder));
            $data = $this->fractal->createData($resource)->toArray();
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
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => $e->getMessage(),
            ]], __('statusCode.statusCode200'));
        }
    }


    /**
     * Edit a return order view page 
     * 
     * @param Request $request
     * @return view
     */
    public function editReturnOrder(Request $request, $return_id)
    {
        $returnOrder = ReturnOrder::where('id', salt_decrypt($return_id))->with('order.orderItemsCharges')->first();
        if (!$returnOrder) {
            abort(404);
        }
        if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
            if ($returnOrder->status == ReturnOrder::STATUS_OPEN) {
                $returnOrder->status = ReturnOrder::STATUS_IN_PROGRESS;
                $returnOrder->save();
            }
        }
        $courierList = CourierDetails::orderBy('id', 'desc')->get();
        $courier_detatils = $returnOrder->returnShipments()->first();
        $attachment = json_decode($returnOrder->file_path, true);
        return view('dashboard.common.edit-return-order', get_defined_vars());
    }

    /**
     * Update a return order view page 
     * 
     * @param Request $request
     * @return view
     */
    public function addReturnOrderComment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'comment' => 'required|string',
                'return_order_id' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode200'));
            }
            $returnOrder = ReturnOrder::where('id', salt_decrypt($request->return_order_id))->first();
            if (!$returnOrder) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => __('auth.returnOrderNotFound'),
                ]], __('statusCode.statusCode200'));
            }
            // get login user role spatie
            $role = auth()->user()->roles->first()->name;
            ReturnComment::create([
                'return_id' => $returnOrder->id,
                'role_type' => $role,
                'comment' => $request->comment
            ]);
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.commentAdded'),
            ]], __('statusCode.statusCode200'));
        } catch (\Exception $e) {

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => $e->getMessage(),
            ]], __('statusCode.statusCode200'));
        }
    }

    /**
     * Update a return order view page 
     * 
     * @param Request $request
     * @return view
     */
    public function updateReturnOrder(Request $request)
    {
        try{
            if (! auth()->user()->hasPermissionTo(User::PERMISSION_EDIT_RETURN_ORDER)) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403'),
                    'message' => __('auth.unauthorizedAction'),
                ]], __('statusCode.statusCode200'));
            }
    
            $validator = Validator::make($request->all(), [
                'return_order_id' => 'required|string',
                'status' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode200'));
            }
            if ($request->courier_id) {
                $validator = Validator::make($request->all(), [
                    'courier_id' => 'required|string',
                    'tracking_number' => 'required|string',
                    'shippingDate' => 'required|string',
                    'deliveryDate' => 'required|string',
                ]);
                if ($validator->fails()) {
                    return response()->json(['data' => [
                        'statusCode' => __('statusCode.statusCode422'),
                        'status' => __('statusCode.status422'),
                        'message' => $validator->errors()->first(),
                    ]], __('statusCode.statusCode200'));
                }
            }
            $returnOrder = ReturnOrder::where('id', salt_decrypt($request->return_order_id))->first();
            if (!$returnOrder) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => __('auth.returnOrderNotFound'),
                ]], __('statusCode.statusCode200'));
            }
            // check dispute raised
            if ($returnOrder->isDisputed()) {
                $validator = Validator::make($request->all(), [
                    'comment' => 'required|string',
                ]);
                if ($validator->fails()) {
                    return response()->json(['data' => [
                        'statusCode' => __('statusCode.statusCode422'),
                        'status' => __('statusCode.status422'),
                        'message' => __('auth.commentRequired'),
                    ]], __('statusCode.statusCode200'));
                } 
            }
            if ($request->courier_id) {
                $file = $request->UploadLabel;
                $filename = $file->getClientOriginalName();
                $path = storage('return_shipment', file_get_contents($file), [$returnOrder->id], 'return_order_label' . $filename, 'public');
                $path = str_replace('public', 'storage', $path);
                ReturnShipment::updateOrCreate(
                    [
                    'order_id' => $returnOrder->order_id,
                    'return_id' => $returnOrder->id
                    ],[
                    'order_id' => $returnOrder->order_id,
                    'return_id' => $returnOrder->id,
                    'courier_id' => $request->courier_id,
                    'awb_number' => $request->tracking_number,
                    'provider_name' => $request->courier_name,
                    'shipment_date' => $request->shippingDate,
                    'expected_delivery_date' => $request->deliveryDate,
                    'status' => ReturnShipment::STATUS_CREATED,
                    'file_path' => $path
                ]);
            }
    
            $returnOrder->status = $request->status;
            $returnOrder->amount = $request->amount;
            if ($returnOrder->isDisputed()) {
                $returnOrder->dispute = ReturnOrder::DISPUTE_RESOLVED;
            }
            $returnOrder->save();
    
            if ($request->comment) {
                // get login user role spatie
                $role = auth()->user()->roles->first()->name;
                ReturnComment::create([
                    'return_id' => $returnOrder->id,
                    'role_type' => $role,
                    'comment' => $request->comment
                ]);
            }
            $details = [
                'return_number' => $returnOrder->return_number,
                'name' => $returnOrder->order->buyer->name,
                'status' => $request->status,
            ];
            event(new ReturnDeclinedApprovedEvent($returnOrder->order->buyer, $details));
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.returnOrderUpdated'),
            ]], __('statusCode.statusCode200'));
        }catch(\Exception $e){
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => $e->getMessage(),
            ]], __('statusCode.statusCode200'));
        }
    }

    /**
     * Update a return order view page 
     * 
     * @param Request $request
     * @return view
     */
    public function raiseDispute(Request $request)
    {
        try{
            if (!auth()->user()->hasRole(User::ROLE_BUYER)) {
                abort(403);
            }

            $validator = Validator::make($request->all(), [
                'return_order_id' => 'required|string',
                'comment' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode200'));
            }

            $returnOrder = ReturnOrder::where('id', salt_decrypt($request->return_order_id))->first();
            if (!$returnOrder) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => __('auth.returnOrderNotFound'),
                ]], __('statusCode.statusCode200'));
            }

            $returnOrder->dispute = ReturnOrder::DISPUTE_YES;
            $returnOrder->save();

            if($request->comment){
                ReturnComment::create([
                    'return_id' => $returnOrder->id,
                    'role_type' => User::ROLE_BUYER,
                    'comment' => $request->comment
                ]);
            }

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.disputeRaised'),
            ]], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => $e->getMessage(),
            ]], __('statusCode.statusCode200'));
        }
    }


    /**
     * Create return order tracking view page
    */
    public function returnOrderTracking(){
        return view('dashboard.common.return-order-tracking');
    }

    /**
     * Get return order tracking list
     * 
     * @param Request $request
     * @return view
     */
    public function getReturnOrderTracking(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $search = $request->input('query', null);
            $sort = $request->input('sort', 'id'); // Default sort by 'title'
            $sortOrder = $request->input('order', 'desc'); // Default sort direction 'asc'
            $sort_by_status = $request->input('sort_by_status', null);
            // Allowed sort fields to prevent SQL injection
            $allowedSorts = ['quantity', 'return_date', 'dispute'];
            $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
            $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

            $returnOrder = ReturnShipment::with('return', 'order', 'order.orderItemsCharges');
            if ($search) {
                $returnOrder = $returnOrder->whereHas('return', function ($query) use ($search) {
                    $query->where('return_number', 'like', '%' . $search . '%')
                        ->orWhereHas('order', function ($query) use ($search) {
                            $query->where('order_number', 'like', '%' . $search . '%');
                        });
                    
                })->orderBy('id', 'desc');
            }

            if ($sort_by_status) {
                $returnOrder = $returnOrder->where('status', $sort_by_status)->orderBy('id', 'desc');
            }

            $returnOrder = $returnOrder->paginate($perPage);
            $resource = new Collection($returnOrder, new ReturnOrderTrackingTransformer());
            $resource->setPaginator(new \League\Fractal\Pagination\IlluminatePaginatorAdapter($returnOrder));
            $data = $this->fractal->createData($resource)->toArray();
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
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => $e->getMessage(),
            ]], __('statusCode.statusCode200'));
        }
    }

/*
    * Update status of shipment table
    *
    * @param Request $request
    * @return view
    */
    public function updateShipmentStatus(Request $request)
    {
        try{
            $returnShipment = ReturnShipment::find(salt_decrypt($request->shipment_id));
            if (!$returnShipment) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => __('auth.returnShipmentNotFound'),
                ]], __('statusCode.statusCode200'));
            }

            $returnShipment->status = $request->status;
            $returnShipment->save();

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.returnOrderTracking'),
            ]], __('statusCode.statusCode200'));
        } catch (\Exception $e) {
            // Prepare exception details
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            // Trigger the event
            event(new ExceptionEvent($exceptionDetails));
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => $e->getMessage(),
            ]], __('statusCode.statusCode200'));
        }
    }
    
}

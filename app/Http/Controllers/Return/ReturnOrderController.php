<?php

namespace App\Http\Controllers\Return;

use App\Models\User;
use App\Models\Order;
use App\Models\ReturnOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ReturnOrderController extends Controller
{
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
    public function store(Request $request){
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
                'message' => __('return_order.orderNotFound'),
            ]], __('statusCode.statusCode200'));
        }

        // if($order->isDispatched() && $request->reason == 1){
        //     //
        // }else if( $order->isDelivered()){
        //     $shipments = $order->shipments()->first();
        //     if($shipments){
        //         $delivery_date = $shipments->delivery_date;
        //     }else{
        //         $delivery_date = '';
        //     }
        //     if(isset($delivery_date) && !empty($delivery_date)){
        //         // add two days to delivery date
        //        $delivery_date = Carbon::parse($delivery_date)->addDays(2);
        //        if($delivery_date->toDateTimeString() >= now()->toDateTimeString()){
        //            dd($delivery_date->toDateTimeString() >= now()->toDateTimeString());
        //        }else{
        //             return response()->json(['data' => [
        //                 'statusCode' => __('statusCode.statusCode422'),
        //                 'status' => __('statusCode.status422'),
        //                 'message' => __('auth.returnAllowed'),
        //             ]], __('statusCode.statusCode200'));
        //        }
        //     }else{
        //         return response()->json(['data' => [
        //             'statusCode' => __('statusCode.statusCode422'),
        //             'status' => __('statusCode.status422'),
        //             'message' => __('auth.orderNotDelivered'),
        //         ]], __('statusCode.statusCode200'));
        //     }
        // }

       return $this->createReturnRequest($request, $order);
    }

    protected function createReturnRequest($request, $order){
        try {
            $ext_img_array = ['png', 'jpeg', 'jpg', 'webp'];
            $ext_video_array = ['mp4'];
           // Upload Images first
           $media = [];
           foreach ($request->media as $key => $file) {
               $filename = $file->getClientOriginalName();
               $extension = $file->getClientOriginalExtension();
                if (in_array($extension, $ext_img_array) ){
                    $media_type = 'image';
                    $media[$media_type][] = storage('return_order', file_get_contents($file), [$request->order_number], 'return_order_' . $filename, 'public');
                }else if(in_array($extension, $ext_video_array)){
                    $media_type = 'video';
                    $media[$media_type][] = storage('return_order', file_get_contents($file), [$request->order_number], 'return_order_' . $filename, 'public');
                }
           }
           $returnOrder = new ReturnOrder();
           if($request->reason == 5){
               $reason = $request->other_reason;
           }else{
                $reason = $returnOrder->reason($request->reason);
           }
           $createReturn = ReturnOrder::create([
                'order_id' => $order->id,
                'return_number' => $request->return_number,
                'return_date' => now(),
                'status' => ReturnOrder::STATUS_OPEN,
                'file_path' => json_encode($media),
                'reason' => $reason
           ]);
           $order->status = Order::STATUS_RTO;
           $order->save();
              return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.returnOrder'),
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
     * Edit a return order view page 
     * 
     * @param Request $request
     * @return view
     */
    public function editReturnOrder(Request $request)
    {
        return view('dashboard.common.edit-return-order');
    }
}

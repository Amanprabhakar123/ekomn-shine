<?php

namespace App\Http\Controllers\APIAuth;

use App\Models\FeedBack;
use Illuminate\Http\Request;
use App\Events\ExceptionEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FeedBackController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            // Validate the request
            $validator = Validator::make($request->all(), [
                'order_id' => 'required',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string'
            ]);
    
            // Check if the validation fails
            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status422'),
                    'message' => $validator->errors()->first(),
                ]], 422);
            }
    
            // Store the feedback
            $rating = FeedBack::create([
                'order_id' => salt_decrypt($request->input('order_id')),
                'rating' => $request->input('rating'),
                'comment' => $request->input('comment')
            ]);
    
            // Return the response
            if ($rating) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode200'),
                    'status' => __('statusCode.status200')
                ]], __('statusCode.statusCode200'));
            } else {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode422'),
                    'status' => __('statusCode.status403')
                ]], __('statusCode.statusCode200'));
            }
        }catch(\Exception $e){
            // Log the exception details and trigger an ExceptionEvent 
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
                'message' => $e->getMessage()
            ]], __('statusCode.statusCode500'));
        }
        
    }
}

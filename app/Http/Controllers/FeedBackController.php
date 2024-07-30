<?php

namespace App\Http\Controllers;

use App\Models\FeedBack;
use Razorpay\Api\Product;
use Illuminate\Http\Request;

class FeedBackController extends Controller
{
   
    // Create a new feedback
    public function index(Request $request,)
    {
        // dd($request->all());
            $rating = FeedBack::create([
                'order_id' => salt_decrypt($request->input('order_id')),
                'rating' => $request->input('rating'),
                'comment' => $request->input('comment')
            ]);

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
       
    }
    
}

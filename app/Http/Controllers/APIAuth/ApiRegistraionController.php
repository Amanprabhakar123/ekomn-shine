<?php

namespace App\Http\Controllers\APIAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\registerModuleApi;
use Illuminate\Validation\Rule;

class ApiRegistraionController extends Controller
{

    function setData(Request $request){
        $business_name = $request->input('business_name');
        $gst = $request->input('gst');
        // $validatedData = $request->validate([
        //     'business_name' => 'required|string|max:255',
        //     'gst' => 'required|string|max:255',
        //     'website_url' => 'nullable|url|max:255',
        //     'first_name' => 'required|string|max:255',
        //     'last_name' => 'required|string|max:255',
        //     'mobile' => 'required|string|max:255',
        //     'designation' => 'nullable|string|max:255',
        //     'address' => 'nullable|string|max:255',
        //     'state' => 'nullable|string|max:255',
        //     'city' => 'nullable|string|max:255',
        //     'pin_code' => 'nullable|string|max:255',
        //     // Add validation rules for other fields
        //     'bulk_dispatch_time' => 'nullable|boolean',
        //     'dropship_dispatch_time' => 'nullable|boolean',
        //     'product_quality_confirm' => 'nullable|boolean',
        //     'business_compliance_confirm' => 'nullable|boolean',
        //     'stationery' => 'nullable|boolean',
        //     'furniture' => 'nullable|boolean',
        //     'food_and_bevrage' => 'nullable|boolean',
        //     'electronics' => 'nullable|boolean',
        //     'groceries' => 'nullable|boolean',
        //     'baby_products' => 'nullable|boolean',
        //     'gift_cards' => 'nullable|boolean',
        //     'cleaining_supplies' => 'nullable|boolean',
        //     'through_sms' => 'nullable|boolean',
        //     'through_email' => 'nullable|boolean',
        //     'google_search' => 'nullable|boolean',
        //     'social_media' => 'nullable|boolean',
        //     'referred' => 'nullable|boolean',
        //     'others' => 'nullable|boolean',
        //     'email' => 'required|email',
        //     'password' => 'required|string|min:6', // Example validation rule for password, adjust as needed
        // ]);

        registerModuleApi::updateOrCreate(['business_name' => $business_name],
        ['business_name' => $business_name, 'gst' => $gst]);

        // $tbl = new registerModuleApi();
       
        // $tbl->business_name = $business_name;
        // $tbl -> gst=$request->gst;
        // $tbl -> website_url=$request->website_url;
        // $tbl -> first_name=$request->first_name;
        // $tbl -> last_name=$request->last_name;
        // $tbl -> mobile=$request->mobile;
        // $tbl -> designation=$request->designation;
        // $tbl -> address=$request->address;
        // $tbl -> state=$request->state;
        // $tbl -> city=$request->city;
        // $tbl -> pin_code=$request->pin_code;
        // $tbl->bulk_dispatch_time = $request->has('bulk_dispatch_time') ? 1 : 0;
        // $tbl->dropship_dispatch_time = $request->has('dropship_dispatch_time') ? 1 : 0;
        // $tbl->product_quality_confirm = $request->has('product_quality_confirm') ? 1 : 0;
        // $tbl->business_compliance_confirm = $request->has('business_compliance_confirm') ? 1 : 0;
        // $tbl->stationery = $request->has('stationery') ? 1 : 0;
        // $tbl->furniture = $request->has('furniture') ? 1 : 0;
        // $tbl->food_and_bevrage = $request->has('food_and_bevrage') ? 1 : 0;
        // $tbl->electronics = $request->has('electronics') ? 1 : 0;
        // $tbl->groceries = $request->has('groceries') ? 1 : 0;
        // $tbl->baby_products = $request->has('baby_products') ? 1 : 0;
        // $tbl->gift_cards = $request->has('gift_cards') ? 1 : 0;
        // $tbl->cleaining_supplies = $request->has('cleaining_supplies') ? 1 : 0;
        // $tbl->through_sms = $request->has('through_sms') ? 1 : 0;
        // $tbl->through_email = $request->has('through_email') ? 1 : 0;
        // $tbl->google_search = $request->has('google_search') ? 1 : 0;
        // $tbl->social_media = $request->has('social_media') ? 1 : 0;
        // $tbl->referred = $request->has('referred') ? 1 : 0;
        // $tbl->others = $request->has('others') ? 1 : 0;
        // $tbl -> email=$request->email;
        // $tbl -> password=$request->password;
        
        
        // $tbl->save();
        $data=[
            'status'=>200,
            'msg'=> 'data inserted succesfylly'
        ];
        return response()->json($data,200);
    }
}


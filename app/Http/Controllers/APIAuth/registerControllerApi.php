<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\registerModuleApi;

class registerControllerApi extends Controller
{
    function setData(Request $req){
        $tbl = new registerModuleApi();
        $tbl -> business_name=$req->business_name;
        $tbl -> gst=$req->gst;
        $tbl -> website_url=$req->website_url;
        $tbl -> first_name=$req->first_name;
        $tbl -> last_name=$req->last_name;
        $tbl -> mobile=$req->mobile;
        $tbl -> designation=$req->designation;
        $tbl -> address=$req->address;
        $tbl -> state=$req->state;
        $tbl -> city=$req->city;
        $tbl -> pin_code=$req->pin_code;
        $tbl -> bulk_dispatch_time=$req->bulk_dispatch_time;
        $tbl -> dropship_dispatch_time=$req->dropship_dispatch_time;
        $tbl -> product_quality_confirm=$req->product_quality_confirm;
        $tbl -> business_compliance_confirm=$req->business_compliance_confirm;
        $tbl -> stationery=$req->stationery;
        $tbl -> furniture=$req->furniture;
        $tbl -> food_and_bevrage=$req->food_and_bevrage;
        $tbl -> electronics=$req->electronics;
        $tbl -> groceriesgroceries=$req->groceries;
        $tbl -> baby_products=$req->gift_cards;
        $tbl -> gift_cards=$req->gift_cards;
        $tbl -> cleaining_supplies=$req->cleaining_supplies;
        $tbl -> through_sms=$req->through_sms;
        $tbl -> through_email=$req->through_email;
        $tbl -> google_search=$req->google_search;
        $tbl -> social_media=$req->social_media;
        $tbl -> referred=$req->referred;
        $tbl -> others=$req->others;
        $tbl -> email=$req->email;
        $tbl -> password=$req->password;

        $tbl->save();
        $data=[
            'status'=>200,
            'msg'=> 'data inserted succesfylly'
        ];
        return response()->json($data,200);
    }
}

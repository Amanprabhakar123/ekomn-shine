<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CourierDetails;
use App\Http\Controllers\Controller;

class CourierDetailsController extends Controller
{

    /**
     * Display the Admin's Courier details.
     * 
     * 
     * @return \Illuminate\Contracts\View\View
     */

     public function index(Request $request){
     
        return view('dashboard.admin.courier');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */

    public function courierDetails(Request $request)
    {
        $request->validate([
            'courier_name' => 'required',
            'tracking_url' => 'required'
        ]);

        if (! auth()->user()->hasPermissionTo(User::PERMISSION_ADD_COURIER)) {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status403'),
                'message' => __('auth.unauthorizedAction'),
            ]], __('statusCode.statusCode200'));
        }

        $courierDetails = CourierDetails::create([
            'courier_name' => $request->input('courier_name'),
            'tracking_url' => $request->input('tracking_url')
        ]);

        if ($courierDetails) {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */

    public function show(){
        $courierDetails = CourierDetails::get();
        return view('dashboard.admin.courierlist', compact('courierDetails'));
    }
    
    /**
     * Edit the specified resource.
     * 
     * @param  int  $id
     */

    public function edit($id){
        $editId = salt_decrypt($id);
        $courierDetails = CourierDetails::find($editId);
        return view('dashboard.admin.editcourier', compact('courierDetails'));

    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */

    public function update(Request $request){
        $id = $request->input('id');
        $editId = salt_decrypt($id);
        if (! auth()->user()->hasPermissionTo(User::PERMISSION_EDIT_COURIER)) {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status403'),
                'message' => __('auth.unauthorizedAction'),
            ]], __('statusCode.statusCode200'));
        }

        $courierDetails = CourierDetails::find($editId);
        $courierDetails->courier_name = $request->input('courier_name');
        $courierDetails->tracking_url = $request->input('tracking_url');
        $courierDetails->save();
        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'message' => __('auth.updateSuccess')
        ]], __('statusCode.statusCode200'));

    }

}

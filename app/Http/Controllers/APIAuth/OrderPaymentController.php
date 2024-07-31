<?php

namespace App\Http\Controllers\APIAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderPaymentController extends Controller
{
    public function orderPayment(Request $request)
    {
        return view('dashboard.common.payment');
    }
}

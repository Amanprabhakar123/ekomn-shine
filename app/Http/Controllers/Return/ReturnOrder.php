<?php

namespace App\Http\Controllers\Return;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReturnOrder extends Controller
{
    /**
     * Create a reutrn order view page 
     * 
     * @param Request $request
     * @return view
     */

     // Create a return order
    public function createReturnOrder(Request $request)
    {
        return view('dashboard.common.create-return-order');
    }
    // List a return order
    public function listReturnOrder(Request $request)
    {
        return view('dashboard.common.list-return-order');
    }
    // Edit a return order
    public function editReturnOrder(Request $request)
    {
        return view('dashboard.common.edit-return-order');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MisSettingController extends Controller
{
    /**
     * display the MIS settings
     *  
     * @return \Illuminate\View\View
     */

    public function misSettingInventory()
    {
        return view('dashboard.admin.mis-setting-inventory');
    }
}

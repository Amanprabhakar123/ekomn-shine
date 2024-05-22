<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthViewController extends Controller
{
    public function __construct()
    {
        //
    }


    public function loginFormView(){
        return view('auth.layout.app');
    }
}

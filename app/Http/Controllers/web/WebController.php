<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        return view('web.index');
    }

    public function productCategory()
    {
        return view('web.product-category');
    }

    public function productDetails()
    {
        return view('web.product-details');
    }

    public function subCategory()
    {
        return view('web.sub-category');
    }
}

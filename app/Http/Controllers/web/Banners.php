<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Banners extends Controller
{
    public function banner()
    {
        return view('dashboard.admin.banners');
    }
}

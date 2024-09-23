<?php

namespace App\Http\Controllers\Shine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShineCredit;

class ShineCreditController extends Controller
{
    public function showCredits()
    {
        $shineCredits = ShineCredit::first(); // Fetch the first record
        dd('Route works!');
        return view('dashboard.buyer.new_shine', compact('shineCredits'));
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display the dashboard based on the user's role.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
            return view('dashboard.supplier.index');
        } elseif (auth()->user()->hasRole(User::ROLE_BUYER)) {
            return view('dashboard.buyer.index');
        } elseif (auth()->user()->hasRole(User::ROLE_ADMIN)) {
            return view('dashboard.admin.index');
        }
        abort('403', 'Unauthorized action.');
    }

    /**
     * Display the user's profile.
     *
     * @return \Illuminate\Contracts\View\View
     */

    public function editProfile(){
        if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
            return view('dashboard.supplier.profile');
        } elseif (auth()->user()->hasRole(User::ROLE_BUYER)) {
            return view('dashboard.buyer.profile');
        } elseif (auth()->user()->hasRole(User::ROLE_ADMIN)) {
            return view('dashboard.admin.profile');
        }
        abort('403', 'Unauthorized action.');
    }
}

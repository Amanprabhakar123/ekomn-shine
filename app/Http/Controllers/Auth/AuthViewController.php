<?php

namespace App\Http\Controllers\Auth;

use App\Models\Plan;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * The AuthViewController class handles the authentication related views.
 */
class AuthViewController extends Controller
{
    /**
     * Create a new AuthViewController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display the login form view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function loginFormView()
    {
        if(auth()->check()) {
            return redirect()->route('dashboard');
        }
        $product = Category::where([
            'root_parent_id' => 0,
            'is_active' => true,
            'depth' => 0
        ])->get();
        $plans = Plan::where('status', Plan::STATUS_ACTIVE)->get()->toArray();
        foreach ($plans as $key => $plan) {
            $feature = json_decode($plan['features'], true);
            foreach ($feature as $key2 => $value) {
                $plans[$key][$key2] = $value;
            }
        }
        return view('auth.layout.app', ['product' => $product, 'plans' => $plans]);
    }

    /**
     * Display the admin login form view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function adminloginFormView()
    {
        return view('auth.admin.login');
    }
}

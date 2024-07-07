<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

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
        $product = Category::where([
            'root_parent_id' => 0,
            'is_active' => true,
            'depth' => 0
        ])->get();
        return view('auth.layout.app', ['product' => $product]);
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

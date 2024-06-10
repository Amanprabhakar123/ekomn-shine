<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Category;
use App\Models\CanHandle;
use App\Models\BusinessType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CompanyAddressDetail;

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
        // Users tak data chahiye
        // CompanyDetails tak data chahiye
        // auth()->user()->companyDetails
        // Company Address Detail tak ka data chahiye
        // dd(auth()->user()->companyDetails->address()->where('address_type', 4)->first());
        // Company Operation Detail tak ka data chahiye
        // auth()->user()->companyDetails->operation()->first()


// $business_name = auth()->user()->companyDetails->business_name;
        // Company Product Category tak ka data chahiye
        // auth()->user()->companyDetails->productCategory()

        $product_category = Category::all();
        $selected_product_category = auth()->user()->companyDetails->productCategory->pluck('product_category_id')->toArray();

        $business_type = BusinessType::all();
        $selected_business_type = auth()->user()->companyDetails->businessType->pluck('business_type_id')->toArray();

        $can_handle = CanHandle::all();
        $selected_can_handle = auth()->user()->companyDetails->canHandle->pluck('can_handles_id')->toArray(); 

        $alternate_business_contact = json_decode(auth()->user()->companyDetails->alternate_business_contact);
        // dd($alternate_business_contact);
        $languages =  ['English', 'Hindi', 'Bengali', 'Telugu', 'Marathi', 'Tamil', 'Gujarati', 'Malayalam', 'Kannada'];
        
        $shipping_address = auth()->user()->companyDetails->address()->where('address_type', CompanyAddressDetail::TYPE_PICKUP_ADDRESS)->first();
        $billing_address = auth()->user()->companyDetails->address()->where('address_type', CompanyAddressDetail::TYPE_BILLING_ADDRESS)->first();
        // dd(auth()->user()->companyDetails);

        if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
            return view('dashboard.supplier.profile', get_defined_vars());
        } elseif (auth()->user()->hasRole(User::ROLE_BUYER)) {
            // dd( get_defined_vars());
            return view('dashboard.buyer.profile', get_defined_vars());
        } elseif (auth()->user()->hasRole(User::ROLE_ADMIN)) {
            return view('dashboard.admin.profile', get_defined_vars());
        }
        abort('403', 'Unauthorized action.');
    }
}

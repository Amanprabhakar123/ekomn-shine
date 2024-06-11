<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Category;
use App\Models\CanHandle;
use App\Models\BusinessType;
use App\Models\SalesChannel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CompanyAddressDetail;
use App\Services\CompanyService;
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
        $product_category = Category::all();
        $selected_product_category = auth()->user()->companyDetails->productCategory->pluck('product_category_id')->toArray();
        $alternate_business_contact = json_decode(auth()->user()->companyDetails->alternate_business_contact);
        $languages =  ['English', 'Hindi', 'Bengali', 'Telugu', 'Marathi', 'Tamil', 'Gujarati', 'Malayalam', 'Kannada'];
        $billing_address = auth()->user()->companyDetails->address()->where('address_type', CompanyAddressDetail::TYPE_BILLING_ADDRESS)->first();

        if (auth()->user()->hasRole(User::ROLE_SUPPLIER)) {
            $shipping_address = auth()->user()->companyDetails->address()->where('address_type', CompanyAddressDetail::TYPE_PICKUP_ADDRESS)->first();
            $business_type = BusinessType::where('type', BusinessType::TYPE_SUPPLIER)->get();
            $selected_business_type = auth()->user()->companyDetails->businessType->pluck('business_type_id')->toArray();
            $can_handle = CanHandle::all();
            $selected_can_handle = auth()->user()->companyDetails->canHandle->pluck('can_handles_id')->toArray(); 

            return view('dashboard.supplier.profile', get_defined_vars());
        } elseif (auth()->user()->hasRole(User::ROLE_BUYER)) {
            $delivery_address = auth()->user()->companyDetails->address()->where('address_type', CompanyAddressDetail::TYPE_DELIVERY_ADDRESS)->first();
            $business_type = BusinessType::where('type', BusinessType::TYPE_BUYER)->get();
            $selected_business_type = auth()->user()->companyDetails->businessType->pluck('business_type_id')->toArray();
            $sales = SalesChannel::where('is_active', true)->get();
            $selected_sales = auth()->user()->companyDetails->salesChannel->pluck('sales_channel_id')->toArray(); 
            return view('dashboard.buyer.profile', get_defined_vars());
        } elseif (auth()->user()->hasRole(User::ROLE_ADMIN)) {
            return view('dashboard.admin.profile', get_defined_vars());
        }
        abort('403', 'Unauthorized action.');
    }

    /**
     * Update the user's profile.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCompanyDetails(Request $request)
    {
        $response = (new CompanyService())->updateCompanyDetails($request);
        return response()->json($response);
    }
}
